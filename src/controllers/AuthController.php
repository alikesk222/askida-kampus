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
        $user = $userModel->findByEmail(trim($_POST['email']));

        if (!$user || !password_verify($_POST['password'], $user['password'])) {
            flash('error', 'E-posta veya şifre hatalı.');
            redirect('/giris');
        }

        if (!$user['is_active']) {
            flash('error', 'Hesabınız devre dışı bırakılmıştır.');
            redirect('/giris');
        }

        Auth::login($user);
        $this->redirectByRole($user['role']);
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
        $pageTitle = 'Erişim Reddedildi';
        view('errors/403');
        exit;
    }
}
