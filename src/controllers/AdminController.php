<?php

namespace Controllers;

use Core\Auth;
use Core\CSRF;
use Core\Validator;
use Models\UserModel;
use Models\VenueModel;
use Models\ProductModel;
use Models\DonationModel;
use Models\ReservationModel;
use Models\SettingsModel;
use Services\DonationService;

class AdminController
{
    public function __construct()
    {
        Auth::requireRole(['super-admin', 'university-admin']);
    }

    public function dashboard(): void
    {
        $userModel = new UserModel();
        $venueModel = new VenueModel();
        $donationModel = new DonationModel();
        $reservationModel = new ReservationModel();

        $stats = [
            'total_users' => $userModel->countAll(),
            'total_venues' => $venueModel->countAll(),
            'waiting_donations' => $donationModel->countWaiting(),
            'total_paid' => $donationModel->sumPaid(),
            'active_reservations' => $reservationModel->countActive(),
            'claimed_today' => $reservationModel->countClaimed(),
            'students' => $userModel->countByRole('student'),
            'donors' => $userModel->countByRole('donor'),
        ];

        $pageTitle = 'Admin Dashboard';
        view('admin/dashboard', compact('pageTitle', 'stats'));
    }

    // ── İşletmeler ────────────────────────────────────────

    public function venuesList(): void
    {
        $venueModel = new VenueModel();
        $venues = $venueModel->getAll();
        $pageTitle = 'İşletmeler';
        view('admin/venues/index', compact('pageTitle', 'venues'));
    }

    public function venueCreate(): void
    {
        $pageTitle = 'Yeni İşletme';
        $errors = flash('errors') ?? [];
        view('admin/venues/create', compact('pageTitle', 'errors'));
    }

    public function venueStore(): void
    {
        CSRF::verify();
        $v = new Validator($_POST);
        $v->required('name', 'Ad')
            ->required('campus_name', 'Kampüs')
            ->required('slug', 'Slug');

        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('error', $v->firstError());
            redirect('/admin/isletmeler/yeni');
        }

        $venueModel = new VenueModel();
        $slug = trim($_POST['slug']) ?: $venueModel->generateSlug($_POST['name']);

        $venueModel->create([
            'name' => trim($_POST['name']),
            'campus_name' => trim($_POST['campus_name']),
            'slug' => $slug,
            'description' => trim($_POST['description'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'opens_at' => $_POST['opens_at'] ?? null,
            'closes_at' => $_POST['closes_at'] ?? null,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        flash('success', 'İşletme başarıyla oluşturuldu.');
        redirect('/admin/isletmeler');
    }

    public function venueShow(string $id): void
    {
        $venueModel = new VenueModel();
        $productModel = new ProductModel();
        $venue = $venueModel->findById((int) $id);
        if (!$venue) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $products = $productModel->getByVenue((int) $id, false);
        $errors = flash('errors') ?? [];
        $pageTitle = e($venue['name']);
        view('admin/venues/show', compact('pageTitle', 'venue', 'products', 'errors'));
    }

    public function venueEdit(string $id): void
    {
        $venueModel = new VenueModel();
        $venue = $venueModel->findById((int) $id);
        if (!$venue) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $errors = flash('errors') ?? [];
        $pageTitle = 'İşletme Düzenle: ' . e($venue['name']);
        view('admin/venues/edit', compact('pageTitle', 'venue', 'errors'));
    }

    public function venueUpdate(string $id): void
    {
        CSRF::verify();
        $venueModel = new VenueModel();
        $venue = $venueModel->findById((int) $id);
        if (!$venue) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $v = new Validator($_POST);
        $v->required('name', 'Ad')->required('campus_name', 'Kampüs')->required('slug', 'Slug');
        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('error', $v->firstError());
            redirect("/admin/isletmeler/$id/duzenle");
        }

        $venueModel->update((int) $id, [
            'name' => trim($_POST['name']),
            'campus_name' => trim($_POST['campus_name']),
            'slug' => trim($_POST['slug']),
            'description' => trim($_POST['description'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'opens_at' => $_POST['opens_at'] ?: null,
            'closes_at' => $_POST['closes_at'] ?: null,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        flash('success', 'İşletme güncellendi.');
        redirect("/admin/isletmeler/$id");
    }

    public function productStore(string $id): void
    {
        CSRF::verify();
        $v = new Validator($_POST);
        $v->required('name', 'Ürün Adı')
            ->required('price_snapshot', 'Fiyat')
            ->numeric('price_snapshot', 'Fiyat')
            ->minVal('price_snapshot', 0.01, 'Fiyat');

        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('error', $v->firstError());
            redirect("/admin/isletmeler/$id");
        }

        $imageUrl = null;
        if (!empty($_FILES['image']['name'])) {
            $imageUrl = $this->uploadProductImage($_FILES['image']);
            if (!$imageUrl) {
                flash('error', 'Görsel yüklenirken hata oluştu. Yalnızca JPG, PNG, GIF, WEBP desteklenir (max 2MB).');
                redirect("/admin/isletmeler/$id");
            }
        }

        $productModel = new ProductModel();
        $productModel->create([
            'venue_id' => (int) $id,
            'name' => trim($_POST['name']),
            'category' => trim($_POST['category'] ?? ''),
            'price_snapshot' => (float) $_POST['price_snapshot'],
            'description' => trim($_POST['description'] ?? ''),
            'image_url' => $imageUrl,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        flash('success', 'Ürün eklendi.');
        redirect("/admin/isletmeler/$id");
    }

    public function productUpdate(string $id, string $pid): void
    {
        CSRF::verify();
        $v = new Validator($_POST);
        $v->required('name', 'Ürün Adı')
            ->required('price_snapshot', 'Fiyat')
            ->numeric('price_snapshot', 'Fiyat')
            ->minVal('price_snapshot', 0.01, 'Fiyat');

        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('error', $v->firstError());
            redirect("/admin/isletmeler/$id");
        }

        $productModel = new ProductModel();
        $product = $productModel->findById((int) $pid);
        if (!$product || (int) $product['venue_id'] !== (int) $id) {
            flash('error', 'Ürün bulunamadı.');
            redirect("/admin/isletmeler/$id");
        }

        $imageUrl = $product['image_url'];

        // Resmi sil isteği
        if (!empty($_POST['remove_image'])) {
            $imageUrl = null;
            if ($product['image_url']) {
                $oldPath = ROOT . '/public/' . ltrim($product['image_url'], '/');
                if (file_exists($oldPath))
                    @unlink($oldPath);
            }
        }

        // Yeni resim yüklendi mi?
        if (!empty($_FILES['image']['name'])) {
            $newUrl = $this->uploadProductImage($_FILES['image']);
            if (!$newUrl) {
                flash('error', 'Görsel yüklenirken hata oluştu.');
                redirect("/admin/isletmeler/$id");
            }
            // Eski dosyayı sil
            if ($product['image_url']) {
                $oldPath = ROOT . '/public/' . ltrim($product['image_url'], '/');
                if (file_exists($oldPath))
                    @unlink($oldPath);
            }
            $imageUrl = $newUrl;
        }

        $productModel->update((int) $pid, [
            'name' => trim($_POST['name']),
            'category' => trim($_POST['category'] ?? ''),
            'price_snapshot' => (float) $_POST['price_snapshot'],
            'description' => trim($_POST['description'] ?? ''),
            'image_url' => $imageUrl,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);

        flash('success', 'Ürün güncellendi.');
        redirect("/admin/isletmeler/$id");
    }

    private function uploadProductImage(array $file): ?string
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if ($file['error'] !== UPLOAD_ERR_OK)
            return null;
        if ($file['size'] > $maxSize)
            return null;

        $mimeType = mime_content_type($file['tmp_name']);
        if (!in_array($mimeType, $allowedTypes))
            return null;

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'product_' . uniqid() . '.' . strtolower($ext);
        $uploadDir = ROOT . '/public/assets/images/products/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destination = $uploadDir . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination))
            return null;

        return 'assets/images/products/' . $filename;
    }

    public function productDelete(string $id, string $pid): void
    {
        CSRF::verify();
        $productModel = new ProductModel();
        $product = $productModel->findById((int) $pid);
        // Görseli de sil
        if ($product && $product['image_url']) {
            $imgPath = ROOT . '/public/' . ltrim($product['image_url'], '/');
            if (file_exists($imgPath))
                @unlink($imgPath);
        }
        $productModel->delete((int) $pid);
        flash('success', 'Ürün silindi.');
        redirect("/admin/isletmeler/$id");
    }

    // ── Bağışlar ──────────────────────────────────────────

    public function donationsList(): void
    {
        $donationModel = new DonationModel();
        $page = max(1, (int) ($_GET['sayfa'] ?? 1));
        $status = $_GET['durum'] ?? null;
        $donations = $donationModel->getAll($page, 20, $status ?: null);
        $total = $donationModel->countAll($status ?: null);
        $pageTitle = 'Bağışlar';
        view('admin/donations/index', compact('pageTitle', 'donations', 'page', 'total', 'status'));
    }

    public function donationApprove(string $id): void
    {
        CSRF::verify();
        $service = new DonationService();
        try {
            $service->approve((int) $id, Auth::id());
            flash('success', 'Bağış onaylandı ve stok güncellendi.');
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
        }
        redirect('/admin/bagislar');
    }

    // ── Kullanıcılar ──────────────────────────────────────

    public function usersList(): void
    {
        $userModel = new UserModel();
        $venueModel = new VenueModel();
        $page = max(1, (int) ($_GET['sayfa'] ?? 1));
        $users = $userModel->getAll($page, 20);
        $total = $userModel->countAll();
        $venues = $venueModel->getAll();
        $errors = flash('errors') ?? [];
        // Her venue-admin için atanmış işletmeyi al
        $venueAssignments = [];
        foreach ($users as $u) {
            if ($u['role'] === 'venue-admin') {
                $venueAssignments[$u['id']] = $userModel->getVenueIdForUser((int) $u['id']);
            }
        }
        $pageTitle = 'Kullanıcılar';
        view('admin/users/index', compact('pageTitle', 'users', 'page', 'total', 'venues', 'errors', 'venueAssignments'));
    }

    public function userStore(): void
    {
        CSRF::verify();
        $v = new Validator($_POST);
        $v->required('name', 'Ad Soyad')
            ->required('email', 'E-posta')
            ->email('email', 'E-posta')
            ->required('password', 'Şifre')
            ->min('password', 6, 'Şifre')
            ->required('role', 'Rol');

        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('error', $v->firstError());
            redirect('/admin/kullanicilar');
        }

        $userModel = new UserModel();
        if ($userModel->findByEmail(trim($_POST['email']))) {
            flash('error', 'Bu e-posta zaten kayıtlı.');
            redirect('/admin/kullanicilar');
        }

        $userId = $userModel->create([
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'password' => $_POST['password'],
            'role' => $_POST['role'],
            'student_number' => trim($_POST['student_number'] ?? '') ?: null,
            'phone' => trim($_POST['phone'] ?? '') ?: null,
            'daily_limit' => (int) ($_POST['daily_limit'] ?? 3),
        ]);

        // venue-admin ise işletmeye ata
        if (!empty($_POST['venue_id']) && $_POST['role'] === 'venue-admin') {
            $userModel->assignVenue($userId, (int) $_POST['venue_id']);
        }

        flash('success', 'Kullanıcı oluşturuldu.');
        redirect('/admin/kullanicilar');
    }

    public function userToggle(string $id): void
    {
        CSRF::verify();
        $userModel = new UserModel();
        $userModel->toggleActive((int) $id);
        flash('success', 'Kullanıcı durumu güncellendi.');
        redirect('/admin/kullanicilar');
    }

    public function userAssignVenue(string $id): void
    {
        CSRF::verify();
        $userModel = new UserModel();
        $user = $userModel->findById((int) $id);
        if (!$user || $user['role'] !== 'venue-admin') {
            flash('error', 'Yalnızca işletme yöneticileri işletmeye atanabilir.');
            redirect('/admin/kullanicilar');
        }
        $venueId = (int) ($_POST['venue_id'] ?? 0);
        if (!$venueId) {
            flash('error', 'Geçerli bir işletme seçin.');
            redirect('/admin/kullanicilar');
        }
        // Önce mevcut atamayı kaldır, sonra yenisini ekle
        $userModel->removeVenueAssignment((int) $id);
        $userModel->assignVenue((int) $id, $venueId);
        flash('success', 'İşletme ataması güncellendi.');
        redirect('/admin/kullanicilar');
    }

    // ── Rezervasyonlar ────────────────────────────────────

    public function reservationsList(): void
    {
        $reservationModel = new ReservationModel();
        $page = max(1, (int) ($_GET['sayfa'] ?? 1));
        $reservations = $reservationModel->getAllWithItems($page, 20);
        $total = $reservationModel->countAll();
        $pageTitle = 'Rezervasyonlar';
        view('admin/reservations/index', compact('pageTitle', 'reservations', 'page', 'total'));
    }

    // ── Ayarlar ───────────────────────────────────────────────

    public function settingsForm(): void
    {
        $settingsModel = new SettingsModel();
        $mailSettings = $settingsModel->getMailSettings();

        // Email template ayarlarını getir
        $emailSettings = [
            'donation_subject' => $settingsModel->get('email_donation_subject'),
            'donation_greeting' => $settingsModel->get('email_donation_greeting'),
            'donation_body' => $settingsModel->get('email_donation_body'),
            'donation_footer_text' => $settingsModel->get('email_donation_footer_text'),
            'donation_signature' => $settingsModel->get('email_donation_signature'),
        ];

        $pageTitle = 'Sistem Ayarları';
        $errors = flash('errors') ?? [];
        view('admin/settings', compact('pageTitle', 'mailSettings', 'emailSettings', 'errors'));
    }

    public function settingsUpdate(): void
    {
        CSRF::verify();
        Auth::requireRole(['super-admin']);

        $settingsModel = new SettingsModel();
        $tab = $_POST['tab'] ?? 'smtp';

        if ($tab === 'smtp') {
            // SMTP ayarlarını kaydet
            $settingsModel->set('mail_host', $_POST['mail_host'] ?? '', 'SMTP sunucu adresi');
            $settingsModel->set('mail_port', $_POST['mail_port'] ?? '587', 'SMTP port numarası');
            $settingsModel->set('mail_username', $_POST['mail_username'] ?? '', 'SMTP kullanıcı adı');
            $settingsModel->set('mail_password', $_POST['mail_password'] ?? '', 'SMTP şifresi');
            $settingsModel->set('mail_encryption', $_POST['mail_encryption'] ?? 'tls', 'Şifreleme türü');
            $settingsModel->set('mail_from_address', $_POST['mail_from_address'] ?? '', 'Gönderen email adresi');
            $settingsModel->set('mail_from_name', $_POST['mail_from_name'] ?? 'AYBÜ Askıda Kampüs', 'Gönderen adı');

            flash('success', 'SMTP ayarları başarıyla güncellendi.');
        } elseif ($tab === 'email') {
            // Email template ayarlarını kaydet
            $settingsModel->set('email_donation_subject', $_POST['email_donation_subject'] ?? '', 'Bağış teşekkür emaili konusu');
            $settingsModel->set('email_donation_greeting', $_POST['email_donation_greeting'] ?? '', 'Email selamlama');
            $settingsModel->set('email_donation_body', $_POST['email_donation_body'] ?? '', 'Email ana içerik');
            $settingsModel->set('email_donation_footer_text', $_POST['email_donation_footer_text'] ?? '', 'Email alt bilgi');
            $settingsModel->set('email_donation_signature', $_POST['email_donation_signature'] ?? '', 'Email imza');

            flash('success', 'Email içerikleri başarıyla güncellendi.');
        }

        redirect('/admin/ayarlar');
    }
}
