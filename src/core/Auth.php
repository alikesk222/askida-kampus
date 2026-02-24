<?php

namespace Core;

class Auth
{
    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['auth_user'] = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ];
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']
            );
        }
        session_destroy();
    }

    public static function user(): ?array
    {
        return $_SESSION['auth_user'] ?? null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['auth_user']);
    }

    public static function id(): ?int
    {
        return $_SESSION['auth_user']['id'] ?? null;
    }

    public static function role(): ?string
    {
        return $_SESSION['auth_user']['role'] ?? null;
    }

    public static function requireRole(string|array $roles): void
    {
        if (!self::check()) {
            redirect('/giris');
        }
        $roles = (array) $roles;
        if (!in_array(self::role(), $roles, true)) {
            http_response_code(403);
            view('errors/403');
            exit;
        }
    }

    public static function requireAuth(): void
    {
        if (!self::check()) {
            redirect('/giris');
        }
    }

    public static function isAdmin(): bool
    {
        return in_array(self::role(), ['super-admin', 'university-admin'], true);
    }
}
