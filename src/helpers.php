<?php

use Core\Auth;
use Core\CSRF;

if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url): never
    {
        // Eğer tam URL değilse (http ile başlamıyorsa) BASE_URL ekle
        if (!str_starts_with($url, 'http')) {
            $url = BASE_URL . '/' . ltrim($url, '/');
        }
        header('Location: ' . $url);
        exit;
    }
}

if (!function_exists('flash')) {
    function flash(string $key, mixed $value = null): mixed
    {
        if ($value !== null) {
            $_SESSION['flash'][$key] = $value;
            return null;
        }
        $val = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $val;
    }
}

if (!function_exists('view')) {
    function view(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $file = ROOT . '/views/' . $template . '.php';
        if (!file_exists($file)) {
            die("View bulunamadı: $template");
        }
        require $file;
    }
}

if (!function_exists('auth')) {
    function auth(): ?array
    {
        return Auth::user();
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return CSRF::field();
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        return CSRF::token();
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return BASE_URL . '/assets/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        if ($path === '') {
            return BASE_URL;
        }
        return BASE_URL . '/' . ltrim($path, '/');
    }
}

if (!function_exists('old')) {
    function old(string $key, mixed $default = ''): string
    {
        $old = $_SESSION['old_input'] ?? [];
        return e($old[$key] ?? $default);
    }
}

if (!function_exists('has_error')) {
    function has_error(array $errors, string $field): bool
    {
        return isset($errors[$field]);
    }
}

if (!function_exists('error_msg')) {
    function error_msg(array $errors, string $field): string
    {
        return isset($errors[$field])
            ? '<p class="text-red-500 text-sm mt-1">' . e($errors[$field]) . '</p>'
            : '';
    }
}

if (!function_exists('t')) {
    function t(string $key, array $replace = []): string
    {
        $lang = $GLOBALS['__lang'] ?? [];
        $str  = $lang[$key] ?? $key;
        foreach ($replace as $k => $v) {
            $str = str_replace(':' . $k, (string)$v, $str);
        }
        return $str;
    }
}

if (!function_exists('current_lang')) {
    function current_lang(): string
    {
        return $_SESSION['lang'] ?? 'tr';
    }
}

if (!function_exists('format_date')) {
    function format_date(?string $date, string $format = 'd.m.Y H:i'): string
    {
        if (!$date) return '-';
        return date($format, strtotime($date));
    }
}

if (!function_exists('status_badge')) {
    function status_badge(string $status): string
    {
        $map = [
            'waiting_approval' => ['bg-yellow-100 text-yellow-800', 'Onay Bekliyor'],
            'paid'             => ['bg-green-100 text-green-800',  'Ödendi'],
            'failed'           => ['bg-red-100 text-red-800',      'Başarısız'],
            'reserved'         => ['bg-blue-100 text-blue-800',    'Rezerve'],
            'claimed'          => ['bg-green-100 text-green-800',  'Teslim Alındı'],
            'expired'          => ['bg-gray-100 text-gray-600',    'Süresi Doldu'],
            'cancelled'        => ['bg-red-100 text-red-800',      'İptal'],
        ];
        [$cls, $label] = $map[$status] ?? ['bg-gray-100 text-gray-600', $status];
        return "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium $cls\">$label</span>";
    }
}
