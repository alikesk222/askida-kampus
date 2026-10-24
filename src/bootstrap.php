<?php

define('ROOT', dirname(__DIR__));

if (file_exists(ROOT . '/vendor/autoload.php')) {
    require ROOT . '/vendor/autoload.php';
}

// Ortam dosyası. Host başlığının alt dizgisine bakılmaz (alikesik.com.tr.evil gibi).
// Canlıda Apache SetEnv APP_ENV production kullanın. Bu yoksa yalnızca tam
// alikesik.com.tr / www.alikesik.com.tr production dosyasını seçer.
$envFromServer = getenv('APP_ENV');
if ($envFromServer === false || $envFromServer === '') {
    $envFromServer = $_SERVER['APP_ENV'] ?? '';
}
$envFromServer = is_string($envFromServer) ? strtolower(trim($envFromServer)) : '';

$httpHost = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
$httpHost = preg_replace('/:\d+$/', '', $httpHost) ?? '';
$isKnownProdHost = preg_match('/^(www\.)?alikesik\.com\.tr$/', $httpHost) === 1;

if ($envFromServer === 'production' || ($envFromServer === '' && $isKnownProdHost)) {
    $envFile = ROOT . '/.env.production';
} elseif (PHP_SAPI === 'cli' && $envFromServer === '' && is_file(ROOT . '/.env.production') && !is_file(ROOT . '/.env')) {
    $envFile = ROOT . '/.env.production';
} else {
    $envFile = ROOT . '/.env';
}

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

define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');

// Hatalar yalnızca açıkça development iken ekrana yazılır.
if (APP_ENV === 'development') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
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
        'secure'   => APP_ENV === 'production'
            || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https'),
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

// Oturumdaki rol ve aktiflik her istekte veritabanından yenilenir.
// Devre dışı bırakılan hesap aynı istekte düşer.
if (PHP_SAPI !== 'cli' && !empty($_SESSION['auth_user']['id'])) {
    try {
        $freshUser = (new Models\UserModel())->findById((int) $_SESSION['auth_user']['id']);
        if (!$freshUser || empty($freshUser['is_active'])) {
            Core\Auth::logout();
        } else {
            $_SESSION['auth_user']['name'] = $freshUser['name'];
            $_SESSION['auth_user']['email'] = $freshUser['email'];
            $_SESSION['auth_user']['role'] = $freshUser['role'];
        }
    } catch (\Throwable $e) {
        error_log('Oturum yenilenemedi: ' . $e->getMessage());
    }
}
