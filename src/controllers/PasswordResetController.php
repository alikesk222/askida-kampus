<?php

namespace Controllers;

use Core\CSRF;
use Core\Validator;
use Core\Database;
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

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        // Güvenlik için: Email bulunamasa bile başarılı mesajı göster
        if (!$user) {
            flash('success', 'Eğer bu e-posta adresine kayıtlı bir hesap varsa, şifre sıfırlama linki gönderildi.');
            redirect('/sifremi-unuttum');
        }

        // Token oluştur
        $token = bin2hex(random_bytes(32));
        
        // Eski tokenları sil
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);

        // Yeni token kaydet
        $stmt = $this->db->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->execute([$email, $token]);

        // Email gönder
        $emailService = new EmailService();
        $sent = $emailService->sendPasswordResetEmail($email, $token);

        if ($sent) {
            flash('success', 'Şifre sıfırlama linki e-posta adresinize gönderildi.');
        } else {
            flash('error', 'E-posta gönderilemedi. Lütfen daha sonra tekrar deneyin.');
        }

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
        $stmt->execute([$email, $token]);
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
            redirect("/sifre-sifirla?token=$token&email=" . urlencode($email));
        }

        // Token kontrolü
        $stmt = $this->db->prepare("
            SELECT * FROM password_resets 
            WHERE email = ? AND token = ? 
            AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ");
        $stmt->execute([$email, $token]);
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

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $user['id']]);

        // Token'ı sil
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);

        flash('success', 'Şifreniz başarıyla güncellendi. Giriş yapabilirsiniz.');
        redirect('/giris');
    }
}
