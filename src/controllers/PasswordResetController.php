<?php

namespace Controllers;

use Core\CSRF;
use Core\Policies;
use Core\Validator;
use Core\Database;
use Models\AuditLogModel;
use Models\UserModel;
use Services\EmailService;

class PasswordResetController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Şifremi unuttum formu
    public function forgotPasswordForm(): void
    {
        $pageTitle = 'Şifremi Unuttum';
        $errors = flash('errors') ?? [];
        view('auth/forgot-password', compact('pageTitle', 'errors'));
    }

    // Şifre sıfırlama emaili gönder
    public function sendResetLink(): void
    {
        CSRF::verify();

        $email = trim($_POST['email'] ?? '');
        
        $validator = new Validator(['email' => $email]);
        $validator->required('email')->email('email');

        if (!$validator->passes()) {
            flash('errors', $validator->errors());
            redirect('/sifremi-unuttum');
        }

        $generic = 'Eğer bu e-posta adresine kayıtlı bir hesap varsa, şifre sıfırlama linki gönderildi.';
        $emailHash = Policies::tokenHash(strtolower($email));
        $audit = new AuditLogModel();
        $limited = $audit->countSince('password_reset_request', 60, client_ip()) >= 5
            || $audit->countSince('password_reset_request', 60, null, null, $emailHash) >= 5;
        if ($limited) {
            flash('success', $generic);
            redirect('/sifremi-unuttum');
        }
        $audit->log('password_reset_request', null, null, null, ['email_hash' => $emailHash]);

        $user = (new UserModel())->findByEmail($email);
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $this->db->prepare('DELETE FROM password_resets WHERE email = ?')->execute([$email]);
            $this->db->prepare('INSERT INTO password_resets (email, token) VALUES (?, ?)')
                ->execute([$email, Policies::tokenHash($token)]);
            $sent = (new EmailService())->sendPasswordResetEmail($email, $token);
            if (!$sent) {
                error_log('Şifre sıfırlama e-postası gönderilemedi.');
            }
        }

        flash('success', $generic);
        redirect('/sifremi-unuttum');
    }

    // Şifre sıfırlama formu
    public function resetPasswordForm(): void
    {
        $token = $_GET['token'] ?? '';
        $email = $_GET['email'] ?? '';

        if (!$token || !$email) {
            flash('error', 'Geçersiz şifre sıfırlama linki.');
            redirect('/giris');
        }

        // Token kontrolü
        $stmt = $this->db->prepare("
            SELECT * FROM password_resets 
            WHERE email = ? AND token = ? 
            AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ");
        $stmt->execute([$email, Policies::tokenHash($token)]);
        $reset = $stmt->fetch();

        if (!$reset) {
            flash('error', 'Şifre sıfırlama linki geçersiz veya süresi dolmuş.');
            redirect('/giris');
        }

        $pageTitle = 'Yeni Şifre Oluştur';
        $errors = flash('errors') ?? [];
        view('auth/reset-password', compact('pageTitle', 'token', 'email', 'errors'));
    }

    // Şifreyi sıfırla
    public function resetPassword(): void
    {
        CSRF::verify();

        $token = $_POST['token'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirmation = $_POST['password_confirmation'] ?? '';

        $validator = new Validator([
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation
        ]);
        
        $validator->required('email')->email('email');
        $validator->required('password')->min('password', 8);
        $validator->required('password_confirmation')->same('password_confirmation', 'password', 'Şifreler');

        if (!$validator->passes()) {
            flash('errors', $validator->errors());
            redirect('/sifre-sifirla?token=' . urlencode($token) . '&email=' . urlencode($email));
        }

        // Token kontrolü
        $stmt = $this->db->prepare("
            SELECT * FROM password_resets 
            WHERE email = ? AND token = ? 
            AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ");
        $stmt->execute([$email, Policies::tokenHash($token)]);
        $reset = $stmt->fetch();

        if (!$reset) {
            flash('error', 'Şifre sıfırlama linki geçersiz veya süresi dolmuş.');
            redirect('/giris');
        }

        // Şifreyi güncelle
        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            flash('error', 'Kullanıcı bulunamadı.');
            redirect('/giris');
        }

        $userModel->updatePassword((int) $user['id'], $password);

        // Token'ı sil
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);

        flash('success', 'Şifreniz başarıyla güncellendi. Giriş yapabilirsiniz.');
        redirect('/giris');
    }
}
