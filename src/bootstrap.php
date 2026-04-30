<?php

define('ROOT', dirname(__DIR__));

// Ortam tespiti: canlı host ise production .env yükle
$currentHost = $_SERVER['HTTP_HOST'] ?? php_uname('n');
$isProduction = str_contains($currentHost, 'alikesik.com.tr');

$envFile = $isProduction
    ? ROOT . '/.env.production'
    : ROOT . '/.env';

// Fallback: production dosyası yoksa standart .env'e dön
if (!file_exists($envFile)) {
    $envFile = ROOT . '/.env';
}

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        if (!str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
    }
}

define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');

// Hata gösterimi: production'da kapat
if (APP_ENV === 'production') {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

// BASE_URL + SCRIPT_BASE
if (!empty($_ENV['APP_URL'])) {
    // .env'de APP_URL tanımlıysa doğrudan kullan (en güvenilir yol)
    $appUrl     = rtrim($_ENV['APP_URL'], '/');
    $parsedPath = parse_url($appUrl, PHP_URL_PATH) ?? '';
    $scriptBase = rtrim($parsedPath, '/');
    define('BASE_URL',    $appUrl);
    define('SCRIPT_BASE', $scriptBase);
} else {
    // Otomatik hesapla
    $scheme     = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host       = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $publicDir  = rtrim(dirname($scriptName), '/');
    $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    if ($publicDir && (str_starts_with($requestUri, $publicDir . '/') || $requestUri === $publicDir)) {
        $scriptBase = $publicDir;
    } else {
        $scriptBase = rtrim(dirname($publicDir), '/');
    }
    define('BASE_URL',    $scheme . '://' . $host . $scriptBase);
    define('SCRIPT_BASE', $scriptBase);
}

// Session — cookie path'i subfolder'a göre ayarla
if (session_status() === PHP_SESSION_NONE) {
    $cookiePath = defined('SCRIPT_BASE') && SCRIPT_BASE ? SCRIPT_BASE . '/' : '/';
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => $cookiePath,
        'domain'   => '',
        'secure'   => APP_ENV === 'production',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Autoloader
spl_autoload_register(function (string $class): void {
    $map = [
        'Core\\'       => ROOT . '/src/core/',
        'Models\\'     => ROOT . '/src/models/',
        'Services\\'   => ROOT . '/src/services/',
        'Controllers\\' => ROOT . '/src/controllers/',
    ];
    foreach ($map as $prefix => $dir) {
        if (str_starts_with($class, $prefix)) {
            $relative = substr($class, strlen($prefix));
            $file = $dir . str_replace('\\', '/', $relative) . '.php';
            if (file_exists($file)) {
                require $file;
            }
            return;
        }
    }
});

// Helpers
require ROOT . '/src/helpers.php';

// Language
$__langCode = $_SESSION['lang'] ?? 'tr';
if (!in_array($__langCode, ['tr', 'en'], true)) {
    $__langCode = 'tr';
}
$GLOBALS['__lang'] = require ROOT . '/lang/' . $__langCode . '.php';
