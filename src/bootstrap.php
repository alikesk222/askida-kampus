<?php

define('ROOT', dirname(__DIR__));

// .env yükle
$envFile = ROOT . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        if (!str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
    }
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

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => false,
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
