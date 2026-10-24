<?php

/**
 * İlk süper yöneticiyi oluşturur. Parola yalnızca ortam değişkeninden okunur
 * ve ekrana yazılmaz.
 *
 *   ADMIN_EMAIL=admin@example.com ADMIN_PASSWORD='uzun-rastgele-parola' php scripts/create_admin.php
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require dirname(__DIR__) . '/src/bootstrap.php';

use Core\Validator;
use Models\UserModel;

$email = strtolower(trim((string) getenv('ADMIN_EMAIL')));
$password = (string) getenv('ADMIN_PASSWORD');
$name = trim((string) (getenv('ADMIN_NAME') ?: 'Süper Admin'));

if ($email === '' || $password === '') {
    fwrite(STDERR, "ADMIN_EMAIL ve ADMIN_PASSWORD ortam değişkenleri zorunludur.\n");
    exit(1);
}

$v = new Validator([
    'email' => $email,
    'password' => $password,
    'name' => $name,
]);
$v->required('name', 'Ad')->required('email', 'E-posta')->email('email', 'E-posta')
    ->required('password', 'Şifre')->min('password', 12, 'Şifre')->strongPassword('password', 'Şifre');

if ($v->fails()) {
    fwrite(STDERR, $v->firstError() . "\n");
    exit(1);
}

$users = new UserModel();
if ($users->findByEmail($email)) {
    fwrite(STDERR, "Bu e-posta zaten kayıtlı. Mevcut parolayı bu betik değiştirmez.\n");
    exit(1);
}

$users->create([
    'name' => $name,
    'email' => $email,
    'password' => $password,
    'role' => 'super-admin',
    'university_verified' => 1,
]);

fwrite(STDOUT, "Süper yönetici oluşturuldu: {$email}\n");
