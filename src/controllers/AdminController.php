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
use Services\DonationService;

class AdminController
{
    public function __construct()
    {
        Auth::requireRole(['super-admin', 'university-admin']);
    }

    public function dashboard(): void
    {
        $userModel        = new UserModel();
        $venueModel       = new VenueModel();
        $donationModel    = new DonationModel();
        $reservationModel = new ReservationModel();

        $stats = [
            'total_users'        => $userModel->countAll(),
            'total_venues'       => $venueModel->countAll(),
            'waiting_donations'  => $donationModel->countWaiting(),
            'total_paid'         => $donationModel->sumPaid(),
            'active_reservations'=> $reservationModel->countActive(),
            'claimed_today'      => $reservationModel->countClaimed(),
            'students'           => $userModel->countByRole('student'),
            'donors'             => $userModel->countByRole('donor'),
        ];

        $pageTitle = 'Admin Dashboard';
        view('admin/dashboard', compact('pageTitle', 'stats'));
    }

    // ── İşletmeler ────────────────────────────────────────

    public function venuesList(): void
    {
        $venueModel = new VenueModel();
        $venues     = $venueModel->getAll();
        $pageTitle  = 'İşletmeler';
        view('admin/venues/index', compact('pageTitle', 'venues'));
    }

    public function venueCreate(): void
    {
        $pageTitle = 'Yeni İşletme';
        $errors    = flash('errors') ?? [];
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
        $slug       = trim($_POST['slug']) ?: $venueModel->generateSlug($_POST['name']);

        $venueModel->create([
            'name'        => trim($_POST['name']),
            'campus_name' => trim($_POST['campus_name']),
            'slug'        => $slug,
            'description' => trim($_POST['description'] ?? ''),
            'location'    => trim($_POST['location'] ?? ''),
            'phone'       => trim($_POST['phone'] ?? ''),
            'opens_at'    => $_POST['opens_at'] ?? null,
            'closes_at'   => $_POST['closes_at'] ?? null,
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ]);

        flash('success', 'İşletme başarıyla oluşturuldu.');
        redirect('/admin/isletmeler');
    }

    public function venueShow(string $id): void
    {
        $venueModel   = new VenueModel();
        $productModel = new ProductModel();
        $venue        = $venueModel->findById((int)$id);
        if (!$venue) { http_response_code(404); view('errors/404'); return; }

        $products  = $productModel->getByVenue((int)$id, false);
        $errors    = flash('errors') ?? [];
        $pageTitle = e($venue['name']);
        view('admin/venues/show', compact('pageTitle', 'venue', 'products', 'errors'));
    }

    public function venueEdit(string $id): void
    {
        $venueModel = new VenueModel();
        $venue      = $venueModel->findById((int)$id);
        if (!$venue) { http_response_code(404); view('errors/404'); return; }

        $errors    = flash('errors') ?? [];
        $pageTitle = 'İşletme Düzenle: ' . e($venue['name']);
        view('admin/venues/edit', compact('pageTitle', 'venue', 'errors'));
    }

    public function venueUpdate(string $id): void
    {
        CSRF::verify();
        $venueModel = new VenueModel();
        $venue      = $venueModel->findById((int)$id);
        if (!$venue) { http_response_code(404); view('errors/404'); return; }

        $v = new Validator($_POST);
        $v->required('name', 'Ad')->required('campus_name', 'Kampüs')->required('slug', 'Slug');
        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('error', $v->firstError());
            redirect("/admin/isletmeler/$id/duzenle");
        }

        $venueModel->update((int)$id, [
            'name'        => trim($_POST['name']),
            'campus_name' => trim($_POST['campus_name']),
            'slug'        => trim($_POST['slug']),
            'description' => trim($_POST['description'] ?? ''),
            'location'    => trim($_POST['location'] ?? ''),
            'phone'       => trim($_POST['phone'] ?? ''),
            'opens_at'    => $_POST['opens_at'] ?: null,
            'closes_at'   => $_POST['closes_at'] ?: null,
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
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

        $productModel = new ProductModel();
        $productModel->create([
            'venue_id'       => (int)$id,
            'name'           => trim($_POST['name']),
            'category'       => trim($_POST['category'] ?? ''),
            'price_snapshot' => (float)$_POST['price_snapshot'],
            'description'    => trim($_POST['description'] ?? ''),
            'is_active'      => isset($_POST['is_active']) ? 1 : 0,
        ]);

        flash('success', 'Ürün eklendi.');
        redirect("/admin/isletmeler/$id");
    }

    public function productDelete(string $id, string $pid): void
    {
        CSRF::verify();
        $productModel = new ProductModel();
        $productModel->delete((int)$pid);
        flash('success', 'Ürün silindi.');
        redirect("/admin/isletmeler/$id");
    }

    // ── Bağışlar ──────────────────────────────────────────

    public function donationsList(): void
    {
        $donationModel = new DonationModel();
        $page          = max(1, (int)($_GET['sayfa'] ?? 1));
        $status        = $_GET['durum'] ?? null;
        $donations     = $donationModel->getAll($page, 20, $status ?: null);
        $total         = $donationModel->countAll($status ?: null);
        $pageTitle     = 'Bağışlar';
        view('admin/donations/index', compact('pageTitle', 'donations', 'page', 'total', 'status'));
    }

    public function donationApprove(string $id): void
    {
        CSRF::verify();
        $service = new DonationService();
        try {
            $service->approve((int)$id, Auth::id());
            flash('success', 'Bağış onaylandı ve stok güncellendi.');
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
        }
        redirect('/admin/bagislar');
    }

    // ── Kullanıcılar ──────────────────────────────────────

    public function usersList(): void
    {
        $userModel  = new UserModel();
        $venueModel = new VenueModel();
        $page       = max(1, (int)($_GET['sayfa'] ?? 1));
        $users      = $userModel->getAll($page, 20);
        $total      = $userModel->countAll();
        $venues     = $venueModel->getAll();
        $errors     = flash('errors') ?? [];
        $pageTitle  = 'Kullanıcılar';
        view('admin/users/index', compact('pageTitle', 'users', 'page', 'total', 'venues', 'errors'));
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
            'name'           => trim($_POST['name']),
            'email'          => trim($_POST['email']),
            'password'       => $_POST['password'],
            'role'           => $_POST['role'],
            'student_number' => trim($_POST['student_number'] ?? '') ?: null,
            'phone'          => trim($_POST['phone'] ?? '') ?: null,
            'daily_limit'    => (int)($_POST['daily_limit'] ?? 3),
        ]);

        // venue-admin veya cashier ise işletmeye ata
        if (!empty($_POST['venue_id']) && in_array($_POST['role'], ['venue-admin', 'cashier'])) {
            $userModel->assignVenue($userId, (int)$_POST['venue_id']);
        }

        flash('success', 'Kullanıcı oluşturuldu.');
        redirect('/admin/kullanicilar');
    }

    public function userToggle(string $id): void
    {
        CSRF::verify();
        $userModel = new UserModel();
        $userModel->toggleActive((int)$id);
        flash('success', 'Kullanıcı durumu güncellendi.');
        redirect('/admin/kullanicilar');
    }

    // ── Rezervasyonlar ────────────────────────────────────

    public function reservationsList(): void
    {
        $reservationModel = new ReservationModel();
        $page             = max(1, (int)($_GET['sayfa'] ?? 1));
        $reservations     = $reservationModel->getAll($page, 20);
        $total            = $reservationModel->countAll();
        $pageTitle        = 'Rezervasyonlar';
        view('admin/reservations/index', compact('pageTitle', 'reservations', 'page', 'total'));
    }
}
