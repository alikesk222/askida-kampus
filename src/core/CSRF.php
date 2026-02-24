<?php

namespace Core;

class CSRF
{
    private static string $key = '_csrf_token';

    public static function token(): string
    {
        if (empty($_SESSION[self::$key])) {
            $_SESSION[self::$key] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::$key];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_csrf_token" value="' . self::token() . '">';
    }

    public static function verify(): void
    {
        $token = $_POST['_csrf_token'] ?? '';
        if (!hash_equals(self::token(), $token)) {
            http_response_code(403);
            die('CSRF token doğrulaması başarısız.');
        }
    }
}
