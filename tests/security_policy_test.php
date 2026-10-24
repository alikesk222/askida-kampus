<?php

/**
 * Veritabanı gerektirmeyen güvenlik kararları.
 * Çalıştırma: php tests/security_policy_test.php
 */

$root = dirname(__DIR__);
require $root . '/src/core/Policies.php';
require $root . '/src/core/SecretBox.php';

use Core\Policies;
use Core\SecretBox;

$failed = 0;

function check(bool $ok, string $label): void
{
    global $failed;
    if ($ok) {
        echo "ok  {$label}\n";
        return;
    }
    $failed++;
    echo "FAIL {$label}\n";
}

check(Policies::isStudentEmail('2105081101@ogr.aybu.edu.tr'), 'ogrenci alan adi kabul');
check(Policies::isStudentEmail('  Ad.Soyad@OGR.AYBU.EDU.TR '), 'buyuk harf ve bosluk');
check(!Policies::isStudentEmail('hoca@aybu.edu.tr'), 'personel alan adi reddedilir');
check(!Policies::isStudentEmail('ogrenci@ogr.aybu.edu.tr.evil.test'), 'son ek reddedilir');
check(!Policies::isStudentEmail('not-an-email'), 'eksik adres');
check(!Policies::isStudentEmail('@ogr.aybu.edu.tr'), 'yerel kisim yok');

check(Policies::assignableRoles('university-admin') === ['venue-admin', 'student', 'donor'], 'universite admin rol listesi');
check(!in_array('super-admin', Policies::assignableRoles('university-admin'), true), 'super-admin atanamaz');
check(!in_array('university-admin', Policies::assignableRoles('university-admin'), true), 'esit rol atanamaz');
check(in_array('super-admin', Policies::assignableRoles('super-admin'), true), 'super-admin tum roller');
check(Policies::canManageUser('university-admin', 4, 'student', 9), 'ogrenci yonetilebilir');
check(!Policies::canManageUser('university-admin', 4, 'university-admin', 8), 'esit rol yonetilemez');
check(!Policies::canManageUser('university-admin', 4, 'super-admin', 1), 'ust rol yonetilemez');
check(!Policies::canManageUser('university-admin', 4, 'student', 4), 'kendini yonetemez');
check(Policies::canManageUser('super-admin', 1, 'super-admin', 1), 'super-admin kendini yonetebilir');
check(!Policies::canManageUser('venue-admin', 3, 'student', 9), 'isletme admin kullanici yonetemez');

check(Policies::parseBoundedQty('50') === 50, 'ust sinir');
check(Policies::parseBoundedQty('0') === 0, 'sifir gecerli');
check(Policies::parseBoundedQty('51') === false, 'sinir asimi');
check(Policies::parseBoundedQty('005') === false, 'uc hane');
check(Policies::parseBoundedQty('1.5') === false, 'ondalik');
check(Policies::parseBoundedQty(-1) === false, 'negatif');
check(Policies::parseBoundedQty(12) === 12, 'tamsayi');

check(Policies::imageExtensionForMime('image/jpeg') === 'jpg', 'jpeg uzantisi');
check(Policies::imageExtensionForMime('image/png') === 'png', 'png uzantisi');
check(Policies::imageExtensionForMime('image/gif') === 'gif', 'gif uzantisi');
check(Policies::imageExtensionForMime('image/webp') === 'webp', 'webp uzantisi');
check(Policies::imageExtensionForMime('application/x-php') === null, 'php mime reddedilir');

$hash = Policies::tokenHash('123456');
check(strlen($hash) === 64 && ctype_xdigit($hash), 'token ozeti 64 hex');
check($hash === hash('sha256', '123456'), 'sha256');
check($hash !== Policies::tokenHash('123457'), 'farkli token');

$_ENV['APP_SECRET'] = 'test-only-placeholder-secret-value-32';
$sealed = SecretBox::seal('smtp-placeholder');
check(SecretBox::isSealed($sealed), 'muhur oneki');
check(!str_contains($sealed, 'smtp-placeholder'), 'duz metin gorunmez');
check(SecretBox::open($sealed) === 'smtp-placeholder', 'muhur acilir');
check(SecretBox::open('legacy-plain') === 'legacy-plain', 'eski duz metin okunur');
$_ENV['APP_SECRET'] = 'short';
check(SecretBox::open($sealed) === '', 'kisa sirre ile acilmaz');

$qrFile = $root . '/src/services/QrService.php';
$autoload = $root . '/vendor/autoload.php';
if (is_file($qrFile) && is_file($autoload)) {
    require $autoload;
    require $qrFile;
    $uri = Services\QrService::getQrImageUrl('123456');
    check(str_starts_with($uri, 'data:image/svg+xml'), 'yerel qr data uri');
    check(!str_contains($uri, 'qrserver'), 'ucuncu parti yok');
    check(str_contains($uri, '123456') || str_contains(rawurldecode($uri), '123456') || strlen($uri) > 100, 'qr icerigi uretildi');
} else {
    echo "skip qr (kutuphane yok)\n";
}

if ($failed > 0) {
    fwrite(STDERR, "{$failed} test failed\n");
    exit(1);
}
echo "all passed\n";
