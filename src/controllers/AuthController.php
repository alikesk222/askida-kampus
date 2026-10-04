<?php

namespace Controllers;

use Core\Auth;
use Core\CSRF;
use Core\Validator;
use Core\Database;
use Models\UserModel;
use Models\VenueModel;

class AuthController
{
    public function root(): void
    {
        if (Auth::check()) {
            $this->redirectByRole(Auth::role());
        }

        $db = Database::getInstance();
        $venueModel = new VenueModel();

        $venues = $venueModel->getAll(true);

        $stats = [
            'venues' => (int) $db->query('SELECT COUNT(*) FROM venues WHERE is_active = 1')->fetchColumn(),
            'donations' => (int) $db->query('SELECT COUNT(*) FROM donations WHERE status = "paid"')->fetchColumn(),
            'reservations' => (int) $db->query('SELECT COUNT(*) FROM reservations WHERE status = "claimed"')->fetchColumn(),
            'stock' => (int) $db->query('SELECT COALESCE(SUM(available_quantity - reserved_quantity), 0) FROM suspended_stocks')->fetchColumn(),
        ];

        view('home', compact('venues', 'stats'));
    }

    public function loginForm(): void
    {
        if (Auth::check()) {
            $this->redirectByRole(Auth::role());
        }
        $pageTitle = 'Giriş Yap';
        $errors = flash('errors') ?? [];
        view('auth/login', compact('pageTitle', 'errors'));
    }

    public function login(): void
    {
        CSRF::verify();

        $ip = $this->getClientIp();

        // Honeypot: gerçek kullanıcılar bu alanı doldurmaz
        if (!empty($_POST['website'])) {
            $this->recordFailedLogin($ip, '');
            flash('error', 'E-posta veya şifre hatalı.');
            redirect('/giris');
        }

        if ($this->isRateLimited($ip)) {
            http_response_code(429);
            flash('error', 'Çok fazla başarısız giriş denemesi. Lütfen 15 dakika sonra tekrar deneyin.');
            redirect('/giris');
        }

        $v = new Validator($_POST);
        $v->required('email', 'E-posta')
            ->email('email', 'E-posta')
            ->required('password', 'Şifre');

        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('error', $v->firstError());
            redirect('/giris');
        }

        $userModel = new UserModel();
        $email     = trim($_POST['email']);
        $user      = $userModel->findByEmail($email);

        if (!$user || !password_verify($_POST['password'], $user['password'])) {
            $this->recordFailedLogin($ip, $email);
            flash('error', 'E-posta veya şifre hatalı.');
            redirect('/giris');
        }

        if (!$user['is_active']) {
            $this->recordFailedLogin($ip, $email);
            flash('error', 'Hesabınız devre dışı bırakılmıştır.');
            redirect('/giris');
        }

        // E-posta doğrulama kontrolü
        if (!$user['university_verified']) {
            if ($user['role'] === 'student') {
                $_SESSION['pending_verify_id']    = $user['id'];
                $_SESSION['pending_verify_email'] = $user['email'];
                flash('error', t('auth.not_verified'));
                redirect('/ogrenci-kayit/dogrula');
            }
            if ($user['role'] === 'donor') {
                $_SESSION['pending_donor_verify_id']    = $user['id'];
                $_SESSION['pending_donor_verify_email'] = $user['email'];
                flash('error', t('donor_verify.not_verified'));
                redirect('/bagisci-kayit/dogrula');
            }
        }

        Auth::login($user);
        $this->redirectByRole($user['role']);
    }

    private function getClientIp(): string
    {
        // Cloudflare gerçek IP başlığı
        $cfIp = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? '';
        if ($cfIp && filter_var($cfIp, FILTER_VALIDATE_IP)) {
            return $cfIp;
        }
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    private function isRateLimited(string $ip): bool
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            "SELECT COUNT(*) FROM audit_logs
             WHERE action = 'login_failed' AND ip_address = ?
             AND created_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)"
        );
        $stmt->execute([$ip]);
        return (int) $stmt->fetchColumn() >= 10;
    }

    private function recordFailedLogin(string $ip, string $email): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            "INSERT INTO audit_logs (action, ip_address, new_values)
             VALUES ('login_failed', ?, ?)"
        );
        $stmt->execute([$ip, json_encode(['email' => substr($email, 0, 100)])]);
        // fail2ban için Apache error log'una da yaz
        error_log("[ASKIDA_LOGIN_FAILED] ip={$ip}");
    }

    public function logout(): void
    {
        CSRF::verify();
        Auth::logout();
        redirect('/giris');
    }

    private function redirectByRole(string $role): never
    {
        $map = [
            'super-admin' => '/admin',
            'university-admin' => '/admin',
            'venue-admin' => '/isletme',
            'student' => '/isletmeler',
            'donor' => '/bagis',
        ];
        if (isset($map[$role])) {
            redirect($map[$role]);
        }
        // Tanınmayan rol: oturum kapat ve hata göster
        Auth::logout();
        http_response_code(403);
        view('errors/403', ['pageTitle' => 'Erişim Reddedildi']);
        exit;
    }
}
