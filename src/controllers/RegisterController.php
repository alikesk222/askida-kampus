<?php

namespace Controllers;

use Core\Auth;
use Core\CSRF;
use Core\Validator;
use Core\Database;
use Models\UserModel;
use Services\EmailService;
use Services\VerificationService;

class RegisterController
{
    public function form(): void
    {
        if (Auth::check()) {
            redirect('/bagis');
        }
        $errors    = flash('errors') ?? [];
        $old       = flash('old') ?? [];
        $pageTitle = t('donor_reg.page_title');
        view('auth/register', compact('pageTitle', 'errors', 'old'));
    }

    public function store(): void
    {
        CSRF::verify();

        if (Auth::check()) {
            redirect('/bagis');
        }

        $v = new Validator($_POST);
        $v->required('name',     t('donor_reg.name'))
          ->required('email',    t('donor_reg.email'))
          ->email('email',       t('donor_reg.email'))
          ->required('password', t('auth.password'))
          ->min('password', 8,   t('auth.password'))
          ->strongPassword('password', t('auth.password'));

        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('old', ['name' => $_POST['name'] ?? '', 'email' => $_POST['email'] ?? '']);
            redirect('/bagisci-kayit');
        }

        if (($_POST['password'] ?? '') !== ($_POST['password_confirm'] ?? '')) {
            flash('errors', ['password_confirm' => t('donor_reg.password_mismatch')]);
            flash('old', ['name' => $_POST['name'] ?? '', 'email' => $_POST['email'] ?? '']);
            redirect('/bagisci-kayit');
        }

        $email     = strtolower(trim($_POST['email']));
        $userModel = new UserModel();
        $existing  = $userModel->findByEmail($email);

        if ($existing) {
            if ($existing['university_verified'] == 0 && $existing['role'] === 'donor') {
                $userId = (int) $existing['id'];
                $userModel->updatePassword($userId, (string) $_POST['password']);
                if (!VerificationService::canResend($userId)) {
                    $_SESSION['pending_donor_verify_id'] = $userId;
                    $_SESSION['pending_donor_verify_email'] = $email;
                    flash('info', t('donor_verify.resend_wait'));
                    redirect('/bagisci-kayit/dogrula');
                }
                $token = VerificationService::issue($userId);
                VerificationService::markResent($userId);
                $this->sendVerificationEmail($email, $existing['name'], $token);
                $_SESSION['pending_donor_verify_id']    = $existing['id'];
                $_SESSION['pending_donor_verify_email'] = $email;
                flash('info', t('donor_reg.already_pending'));
                redirect('/bagisci-kayit/dogrula');
            }
            flash('errors', ['email' => t('donor_reg.email_taken')]);
            flash('suggest_login', true);
            flash('old', ['name' => $_POST['name'] ?? '', 'email' => $email]);
            redirect('/bagisci-kayit');
        }

        $userId = $userModel->create([
            'name'                => trim($_POST['name']),
            'email'               => $email,
            'password'            => $_POST['password'],
            'role'                => 'donor',
            'university_verified' => 0,
        ]);

        $token = VerificationService::issue($userId);
        $this->sendVerificationEmail($email, trim($_POST['name']), $token);

        $_SESSION['pending_donor_verify_id']    = $userId;
        $_SESSION['pending_donor_verify_email'] = $email;

        redirect('/bagisci-kayit/dogrula');
    }

    public function verifyForm(): void
    {
        if (Auth::check()) {
            redirect('/bagis');
        }

        $email     = $_SESSION['pending_donor_verify_email'] ?? '';
        $errors    = flash('errors') ?? [];
        $pageTitle = t('donor_verify.page_title');
        view('auth/donor-verify', compact('pageTitle', 'email', 'errors'));
    }

    public function verify(): void
    {
        CSRF::verify();

        if (Auth::check()) {
            redirect('/bagis');
        }

        $userId = (int) ($_SESSION['pending_donor_verify_id'] ?? 0);
        $email  = $_SESSION['pending_donor_verify_email'] ?? '';

        if (!$userId || !$email) {
            flash('error', t('donor_verify.session_expired'));
            redirect('/bagisci-kayit');
        }

        $code = trim($_POST['code'] ?? '');
        if (!preg_match('/^\d{6}$/', $code)) {
            flash('errors', ['code' => t('donor_verify.wrong_code')]);
            redirect('/bagisci-kayit/dogrula');
        }

        $result = VerificationService::check($userId, $email, $code);
        if ($result === 'expired') {
            flash('errors', ['code' => t('donor_verify.expired')]);
            redirect('/bagisci-kayit/dogrula');
        }
        if ($result === 'locked') {
            flash('errors', ['code' => t('donor_verify.too_many')]);
            redirect('/bagisci-kayit/dogrula');
        }
        if ($result !== 'ok') {
            flash('errors', ['code' => t('donor_verify.wrong_code')]);
            redirect('/bagisci-kayit/dogrula');
        }

        $db = Database::getInstance();

        $db->prepare(
            'UPDATE users SET university_verified = 1, email_verify_token = NULL, email_verify_expires = NULL, is_active = 1 WHERE id = ?'
        )->execute([$userId]);

        unset($_SESSION['pending_donor_verify_id'], $_SESSION['pending_donor_verify_email']);

        $userModel = new UserModel();
        $user      = $userModel->findById($userId);
        Auth::login($user);

        flash('success', t('donor_verify.success'));
        redirect('/bagis');
    }

    public function resend(): void
    {
        CSRF::verify();

        $userId = (int) ($_SESSION['pending_donor_verify_id'] ?? 0);
        $email  = $_SESSION['pending_donor_verify_email'] ?? '';

        if (!$userId || !$email) {
            redirect('/bagisci-kayit');
        }

        $userModel = new UserModel();
        $user      = $userModel->findById($userId);
        if (!$user) {
            redirect('/bagisci-kayit');
        }

        if (!VerificationService::canResend($userId)) {
            flash('error', t('donor_verify.resend_wait'));
            redirect('/bagisci-kayit/dogrula');
        }
        $token = VerificationService::issue($userId);
        VerificationService::markResent($userId);
        $this->sendVerificationEmail($email, $user['name'], $token);

        flash('success', t('donor_verify.resend_success'));
        redirect('/bagisci-kayit/dogrula');
    }

    private function sendVerificationEmail(string $email, string $name, string $token): void
    {
        try {
            $svc = new EmailService();
            $svc->sendEmailVerification($email, $name, $token);
        } catch (\Throwable $e) {
            error_log('[ASKIDA_DONOR_VERIFY_EMAIL] ' . $e->getMessage());
        }
    }
}
