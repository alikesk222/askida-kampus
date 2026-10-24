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
        if (!isset($errors[$field])) return '';
        $msg = is_array($errors[$field]) ? ($errors[$field][0] ?? '') : $errors[$field];
        return '<p class="form-error">' . e($msg) . '</p>';
    }
}

if (!function_exists('pname')) {
    function pname(array $product): string
    {
        if (current_lang() === 'en' && !empty($product['name_en'])) {
            return $product['name_en'];
        }
        return $product['name'];
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

if (!function_exists('client_ip')) {
    function client_ip(): string
    {
        // Cloudflare kullanılıyorsa gerçek IP'yi mod_remoteip REMOTE_ADDR'a yazsın.
        // İstemcinin gönderdiği CF-Connecting-IP başlığına bakılmaz.
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        return is_string($ip) && filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }
}

if (!function_exists('safe_error_message')) {
    /**
     * Kullanıcıya gösterilecek iş kuralı mesajları RuntimeException'dır.
     * PDOException da RuntimeException olduğu için ayrıca elenir.
     */
    function safe_error_message(\Throwable $e, string $fallback): string
    {
        if ($e instanceof \PDOException) {
            error_log($e->getMessage());
            return $fallback;
        }
        if ($e instanceof \RuntimeException) {
            return $e->getMessage();
        }
        error_log($e->getMessage());
        return $fallback;
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
        // Rozet sınıfları public/assets/css/app.css içindeki .badge-* tanımlarına karşılık gelir.
        $map = [
            'waiting_approval' => ['badge-pending',   'status.waiting_approval'],
            'paid'             => ['badge-approved',  'status.paid'],
            'failed'           => ['badge-rejected',  'status.failed'],
            'reserved'         => ['badge-approved',  'status.reserved'],
            'claimed'          => ['badge-delivered', 'status.claimed'],
            'expired'          => ['badge-expired',   'status.expired'],
            'cancelled'        => ['badge-rejected',  'status.cancelled'],
        ];
        [$cls, $key] = $map[$status] ?? ['badge-expired', $status];
        $label = isset($map[$status]) ? t($key) : e($status);
        return "<span class=\"badge $cls\">$label</span>";
    }
}
