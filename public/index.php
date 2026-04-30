<?php

require dirname(__DIR__) . '/src/bootstrap.php';

use Core\Router;

$router = new Router();

// ── Kimlik Doğrulama ──────────────────────────────────────
$router->get('/giris', [Controllers\AuthController::class, 'loginForm']);
$router->post('/giris', [Controllers\AuthController::class, 'login']);
$router->post('/cikis', [Controllers\AuthController::class, 'logout']);

// ── Şifre Sıfırlama ───────────────────────────────────────
$router->get('/sifremi-unuttum', [Controllers\PasswordResetController::class, 'forgotPasswordForm']);
$router->post('/sifremi-unuttum', [Controllers\PasswordResetController::class, 'sendResetLink']);
$router->get('/sifre-sifirla', [Controllers\PasswordResetController::class, 'resetPasswordForm']);
$router->post('/sifre-sifirla', [Controllers\PasswordResetController::class, 'resetPassword']);

// ── Admin ─────────────────────────────────────────────────
$router->get('/admin', [Controllers\AdminController::class, 'dashboard']);
$router->get('/admin/isletmeler', [Controllers\AdminController::class, 'venuesList']);
$router->get('/admin/isletmeler/yeni', [Controllers\AdminController::class, 'venueCreate']);
$router->post('/admin/isletmeler/yeni', [Controllers\AdminController::class, 'venueStore']);
$router->get('/admin/isletmeler/{id}', [Controllers\AdminController::class, 'venueShow']);
$router->get('/admin/isletmeler/{id}/duzenle', [Controllers\AdminController::class, 'venueEdit']);
$router->post('/admin/isletmeler/{id}/duzenle', [Controllers\AdminController::class, 'venueUpdate']);
$router->post('/admin/isletmeler/{id}/urun-ekle', [Controllers\AdminController::class, 'productStore']);
$router->post('/admin/isletmeler/{id}/urun/{pid}/guncelle', [Controllers\AdminController::class, 'productUpdate']);
$router->post('/admin/isletmeler/{id}/urun/{pid}/sil', [Controllers\AdminController::class, 'productDelete']);
$router->get('/admin/bagislar', [Controllers\AdminController::class, 'donationsList']);
$router->post('/admin/bagislar/{id}/onayla', [Controllers\AdminController::class, 'donationApprove']);
$router->get('/admin/kullanicilar', [Controllers\AdminController::class, 'usersList']);
$router->post('/admin/kullanicilar/ekle', [Controllers\AdminController::class, 'userStore']);
$router->post('/admin/kullanicilar/{id}/toggle', [Controllers\AdminController::class, 'userToggle']);
$router->post('/admin/kullanicilar/{id}/ata', [Controllers\AdminController::class, 'userAssignVenue']);
$router->get('/admin/rezervasyonlar', [Controllers\AdminController::class, 'reservationsList']);
$router->get('/admin/ayarlar', [Controllers\AdminController::class, 'settingsForm']);
$router->post('/admin/ayarlar', [Controllers\AdminController::class, 'settingsUpdate']);

// ── Venue Admin ───────────────────────────────────────────
$router->get('/isletme', [Controllers\VenueAdminController::class, 'dashboard']);
$router->get('/isletme/stok', [Controllers\VenueAdminController::class, 'stock']);
$router->get('/isletme/bagislar', [Controllers\VenueAdminController::class, 'donations']);
$router->post('/isletme/bagislar/{id}/onayla', [Controllers\VenueAdminController::class, 'donationApprove']);
$router->get('/isletme/rezervasyonlar', [Controllers\VenueAdminController::class, 'reservations']);
$router->get('/isletme/teslim', [Controllers\VenueAdminController::class, 'cashier']);
$router->get('/isletme/kod-sorgula', [Controllers\VenueAdminController::class, 'claimLookup']);
$router->post('/isletme/teslim', [Controllers\VenueAdminController::class, 'claim']);

// ── Eski /kasa rotaları → geriye dönük uyumluluk (308 kalıcı yönlendirme) ──
$router->get('/kasa', [Controllers\LegacyRedirectController::class, 'kasaTeslim']);
$router->post('/kasa/teslim', [Controllers\LegacyRedirectController::class, 'kasaTeslimPost']);

// ── Öğrenci ───────────────────────────────────────────────
$router->get('/isletmeler', [Controllers\StudentController::class, 'venues']);
$router->get('/isletmeler/{id}', [Controllers\StudentController::class, 'venueDetail']);
$router->get('/isletmeler/{id}/rezerve', [Controllers\StudentController::class, 'reserveForm']);
$router->post('/isletmeler/{id}/rezerve', [Controllers\StudentController::class, 'reserveStore']);
$router->get('/rezervasyonlarim', [Controllers\StudentController::class, 'reservations']);
$router->get('/rezervasyonlarim/{id}/qr', [Controllers\StudentController::class, 'showQr']);

// ── Bağışçı ───────────────────────────────────────────────
$router->get('/bagis', [Controllers\DonorController::class, 'venues']);
$router->get('/bagis/{id}', [Controllers\DonorController::class, 'donateForm']);
$router->post('/bagis/{id}', [Controllers\DonorController::class, 'donateStore']);
$router->get('/bagislarim', [Controllers\DonorController::class, 'donations']);

// ── Misafir Bağış (giriş gerekmez) ────────────────────────
$router->get('/misafir-bagis', [Controllers\GuestDonorController::class, 'venuesList']);
$router->get('/misafir-bagis/{id}', [Controllers\GuestDonorController::class, 'donateForm']);
$router->post('/misafir-bagis/{id}', [Controllers\GuestDonorController::class, 'donateStore']);

// ── Bağışçı Kaydı ─────────────────────────────────────────
$router->get('/kayit', [Controllers\RegisterController::class, 'form']);
$router->post('/kayit', [Controllers\RegisterController::class, 'store']);

// ── Dil Değiştirme ────────────────────────────────────────
$router->get('/lang/{code}', [Controllers\PublicController::class, 'setLang']);

// ── Public Sayfalar ───────────────────────────────────────
$router->get('/hakkimizda', [Controllers\PublicController::class, 'about']);
$router->get('/iletisim',   [Controllers\PublicController::class, 'contact']);
$router->get('/sss',        [Controllers\PublicController::class, 'faq']);
$router->get('/isletme/{id}', [Controllers\PublicController::class, 'venueDetail']);

// ── Root redirect ─────────────────────────────────────────
$router->get('/', [Controllers\AuthController::class, 'root']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
