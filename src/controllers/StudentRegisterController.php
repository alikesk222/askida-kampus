<?php

namespace Controllers;

use Core\Auth;
use Core\CSRF;
use Core\Validator;
use Core\Database;
use Core\Policies;
use Models\UserModel;
use Services\EmailService;
use Services\VerificationService;

class StudentRegisterController
{
    public function form(): void
    {
        if (Auth::check()) {
            redirect('/isletmeler');
        }
        $errors    = flash('errors') ?? [];
        $old       = flash('old') ?? [];
        $pageTitle = t('student_reg.page_title');
        view('auth/student-register', compact('pageTitle', 'errors', 'old'));
    }

    public function store(): void
    {
        CSRF::verify();

        if (Auth::check()) {
            redirect('/isletmeler');
        }

        $v = new Validator($_POST);
        $v->required('name',     t('student_reg.name'))
          ->required('email',    t('student_reg.email'))
          ->email('email',       t('student_reg.email'))
          ->required('phone',    t('student_reg.phone'))
          ->required('password', t('auth.password'))
          ->min('password', 8,   t('auth.password'))
          ->strongPassword('password', t('auth.password'));

        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('old', ['name' => $_POST['name'] ?? '', 'email' => $_POST['email'] ?? '', 'phone' => $_POST['phone'] ?? '']);
            redirect('/ogrenci-kayit');
        }

        $email = strtolower(trim($_POST['email']));

        if (!Policies::isStudentEmail($email)) {
            flash('errors', ['email' => t('student_reg.email_domain_error')]);
            flash('old', ['name' => $_POST['name'] ?? '', 'email' => $_POST['email'] ?? '', 'phone' => $_POST['phone'] ?? '']);
            redirect('/ogrenci-kayit');
        }

        // Şifre tekrar kontrolü
        if (($_POST['password'] ?? '') !== ($_POST['password_confirm'] ?? '')) {
            flash('errors', ['password_confirm' => t('student_reg.password_mismatch')]);
            flash('old', ['name' => $_POST['name'] ?? '', 'email' => $email, 'phone' => $_POST['phone'] ?? '']);
            redirect('/ogrenci-kayit');
        }

        $userModel = new UserModel();

        // Zaten kayıtlı mı?
        $existing = $userModel->findByEmail($email);
        if ($existing) {
            if ($existing['university_verified'] == 0 && $existing['role'] === 'student') {
                $userId = (int) $existing['id'];
                $userModel->updatePassword($userId, (string) $_POST['password']);
                if (!VerificationService::canResend($userId)) {
                    $_SESSION['pending_verify_id'] = $userId;
                    $_SESSION['pending_verify_email'] = $email;
                    flash('info', t('student_verify.resend_wait'));
                    redirect('/ogrenci-kayit/dogrula');
                }
                $token = VerificationService::issue($userId);
                VerificationService::markResent($userId);
                $this->sendVerificationEmail($email, $existing['name'], $token);
                $_SESSION['pending_verify_id']    = $existing['id'];
                $_SESSION['pending_verify_email'] = $email;
                flash('info', t('student_reg.already_pending'));
                redirect('/ogrenci-kayit/dogrula');
            }
            flash('errors', ['email' => t('student_reg.email_taken')]);
            flash('suggest_login', true);
            flash('old', ['name' => $_POST['name'] ?? '', 'email' => $email, 'phone' => $_POST['phone'] ?? '']);
            redirect('/ogrenci-kayit');
        }

        // Yeni kullanıcı oluştur (doğrulanmamış)
        $userId = $userModel->create([
            'name'                => trim($_POST['name']),
            'email'               => $email,
            'password'            => $_POST['password'],
            'role'                => 'student',
            'phone'               => trim($_POST['phone']),
            'university_verified' => 0,
        ]);

        $token = VerificationService::issue($userId);
        $this->sendVerificationEmail($email, trim($_POST['name']), $token);

        $_SESSION['pending_verify_id']    = $userId;
        $_SESSION['pending_verify_email'] = $email;

        redirect('/ogrenci-kayit/dogrula');
    }

    public function verifyForm(): void
    {
        if (Auth::check()) {
            redirect('/isletmeler');
        }

        $email     = $_SESSION['pending_verify_email'] ?? '';
        $errors    = flash('errors') ?? [];
        $pageTitle = t('student_verify.page_title');
        view('auth/student-verify', compact('pageTitle', 'email', 'errors'));
    }

    public function verify(): void
    {
        CSRF::verify();

        if (Auth::check()) {
            redirect('/isletmeler');
        }

        $userId = (int) ($_SESSION['pending_verify_id'] ?? 0);
        $email  = $_SESSION['pending_verify_email'] ?? '';

        if (!$userId || !$email) {
            flash('error', t('student_verify.session_expired'));
            redirect('/ogrenci-kayit');
        }

        $code = trim($_POST['code'] ?? '');
        if (!preg_match('/^\d{6}$/', $code)) {
            flash('errors', ['code' => [t('student_verify.wrong_code')]]);
            redirect('/ogrenci-kayit/dogrula');
        }

        $result = VerificationService::check($userId, $email, $code);
        if ($result === 'expired') {
            flash('errors', ['code' => [t('student_verify.expired')]]);
            redirect('/ogrenci-kayit/dogrula');
        }
        if ($result === 'locked') {
            flash('errors', ['code' => [t('student_verify.too_many')]]);
            redirect('/ogrenci-kayit/dogrula');
        }
        if ($result !== 'ok') {
            flash('errors', ['code' => [t('student_verify.wrong_code')]]);
            redirect('/ogrenci-kayit/dogrula');
        }

        $db = Database::getInstance();

        // Doğrulama tamamlandı
        $db->prepare(
            'UPDATE users SET university_verified = 1, email_verify_token = NULL, email_verify_expires = NULL, is_active = 1 WHERE id = ?'
        )->execute([$userId]);

        unset($_SESSION['pending_verify_id'], $_SESSION['pending_verify_email']);

        $userModel = new UserModel();
        $user      = $userModel->findById($userId);
        Auth::login($user);

        flash('success', t('student_verify.success'));
        redirect('/isletmeler');
    }

    public function resend(): void
    {
        CSRF::verify();

        $userId = (int) ($_SESSION['pending_verify_id'] ?? 0);
        $email  = $_SESSION['pending_verify_email'] ?? '';

        if (!$userId || !$email) {
            redirect('/ogrenci-kayit');
        }

        $userModel = new UserModel();
        $user      = $userModel->findById($userId);
        if (!$user) {
            redirect('/ogrenci-kayit');
        }

        if (!VerificationService::canResend($userId)) {
            flash('error', t('student_verify.resend_wait'));
            redirect('/ogrenci-kayit/dogrula');
        }
        $token = VerificationService::issue($userId);
        VerificationService::markResent($userId);
        $this->sendVerificationEmail($email, $user['name'], $token);

        flash('success', t('student_verify.resend_success'));
        redirect('/ogrenci-kayit/dogrula');
    }

    private function sendVerificationEmail(string $email, string $name, string $token): void
    {
        try {
            $svc = new EmailService();
            $svc->sendEmailVerification($email, $name, $token);
        } catch (\Throwable $e) {
            error_log('[ASKIDA_VERIFY_EMAIL] ' . $e->getMessage());
        }
    }
}
