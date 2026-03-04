<?php

namespace Controllers;

use Core\Auth;
use Core\CSRF;
use Models\UserModel;
use Models\VenueModel;
use Models\StockModel;
use Models\DonationModel;
use Models\ReservationModel;
use Services\DonationService;
use Services\ReservationService;

class VenueAdminController
{
    private int $venueId;

    public function __construct()
    {
        Auth::requireRole('venue-admin');
        $userModel = new UserModel();
        $this->venueId = $userModel->getVenueIdForUser(Auth::id()) ?? 0;
        if (!$this->venueId) {
            // Oturum açık kullanıcıyı /giris'e göndermek döngüye neden olur
            flash('error', 'Atandığınız bir işletme bulunamadı. Lütfen yöneticinizle iletişime geçin.');
        }
    }

    public function dashboard(): void
    {
        $venueModel = new VenueModel();
        $stockModel = new StockModel();
        $donationModel = new DonationModel();
        $reservationModel = new ReservationModel();

        $venue = $this->venueId ? $venueModel->findById($this->venueId) : null;
        $freeStock = $this->venueId ? $stockModel->getTotalAvailable($this->venueId) : 0;
        $waiting = $this->venueId ? $donationModel->countByVenue($this->venueId) : 0;
        $active = $this->venueId ? $reservationModel->getByVenue($this->venueId, 1, 5) : [];

        $pageTitle = 'İşletme Paneli';
        view('venue_admin/dashboard', compact('pageTitle', 'venue', 'freeStock', 'waiting', 'active'));
    }

    public function stock(): void
    {
        $venueModel = new VenueModel();
        $stockModel = new StockModel();
        $venue = $this->venueId ? $venueModel->findById($this->venueId) : null;
        $stocks = $this->venueId ? $stockModel->getByVenue($this->venueId) : [];
        $pageTitle = 'Stok Durumu';
        view('venue_admin/stock', compact('pageTitle', 'venue', 'stocks'));
    }

    public function donations(): void
    {
        $donationModel = new DonationModel();
        $page = max(1, (int) ($_GET['sayfa'] ?? 1));
        $donations = $this->venueId ? $donationModel->getByVenue($this->venueId, $page, 20) : [];
        $total = $this->venueId ? $donationModel->countByVenue($this->venueId) : 0;
        $pageTitle = 'Bağışlar';
        view('venue_admin/donations', compact('pageTitle', 'donations', 'page', 'total'));
    }

    public function donationApprove(string $id): void
    {
        CSRF::verify();
        $donationModel = new DonationModel();
        $donation = $donationModel->findById((int) $id);

        if (!$donation || (int) $donation['venue_id'] !== $this->venueId) {
            flash('error', 'Bağış bulunamadı.');
            redirect('/isletme/bagislar');
        }

        $service = new DonationService();
        try {
            $service->approve((int) $id, Auth::id());
            flash('success', 'Bağış onaylandı ve stok güncellendi.');
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
        }
        redirect('/isletme/bagislar');
    }

    public function reservations(): void
    {
        $reservationModel = new ReservationModel();
        $page = max(1, (int) ($_GET['sayfa'] ?? 1));
        $reservations = $this->venueId ? $reservationModel->getByVenueWithItems($this->venueId, $page, 20) : [];
        $total = $this->venueId ? $reservationModel->countByVenue($this->venueId) : 0;
        $pageTitle = 'Rezervasyonlar';
        view('venue_admin/reservations', compact('pageTitle', 'reservations', 'page', 'total'));
    }

    // ── Kasa / Teslim Al ─────────────────────────────────────

    public function cashier(): void
    {
        $venueModel = new VenueModel();
        $venue = $this->venueId ? $venueModel->findById($this->venueId) : null;
        $errors = flash('errors') ?? [];
        $pageTitle = 'Teslim Al';
        view('venue_admin/cashier', compact('pageTitle', 'venue', 'errors'));
    }

    /**
     * AJAX: Koda göre rezervasyon + ürün bilgisi döner (JSON)
     */
    public function claimLookup(): void
    {
        header('Content-Type: application/json');

        $code = strtoupper(trim($_GET['kod'] ?? ''));
        if (strlen($code) < 4) {
            echo json_encode(['found' => false]);
            exit;
        }

        $reservationModel = new ReservationModel();
        $reservation = $reservationModel->findByClaimCode($code);

        if (!$reservation) {
            echo json_encode(['found' => false, 'message' => 'Rezervasyon bulunamadı.']);
            exit;
        }

        if ((int) $reservation['venue_id'] !== $this->venueId) {
            echo json_encode(['found' => false, 'message' => 'Bu rezervasyon başka bir işletmeye aittir.']);
            exit;
        }

        if ($reservation['status'] !== 'reserved') {
            $statusLabel = match ($reservation['status']) {
                'claimed' => 'Bu rezervasyon zaten teslim alınmış.',
                'expired' => 'Bu rezervasyonun süresi dolmuş.',
                'cancelled' => 'Bu rezervasyon iptal edilmiş.',
                default => 'Rezervasyon geçerli değil (' . $reservation['status'] . ').',
            };
            echo json_encode(['found' => false, 'message' => $statusLabel]);
            exit;
        }

        if (strtotime($reservation['expires_at']) < time()) {
            echo json_encode(['found' => false, 'message' => 'Rezervasyonun süresi dolmuş.']);
            exit;
        }

        $items = $reservationModel->getItems((int) $reservation['id']);

        echo json_encode([
            'found' => true,
            'student_name' => $reservation['student_name'] ?? '',
            'venue_name' => $reservation['venue_name'] ?? '',
            'expires_at' => $reservation['expires_at'],
            'items' => array_map(fn($i) => [
                'product_name' => $i['product_name'],
                'quantity' => (int) $i['quantity'],
                'price_snapshot' => (float) $i['price_snapshot'],
            ], $items),
        ]);
        exit;
    }

    public function claim(): void
    {
        CSRF::verify();

        if (!$this->venueId) {
            flash('error', 'İşletme atamanız bulunmuyor.');
            redirect('/isletme');
        }

        $v = new \Core\Validator($_POST);
        $v->required('claim_code', 'Teslim Kodu');
        if ($v->fails()) {
            flash('error', $v->firstError());
            redirect('/isletme/teslim');
        }

        $code = strtoupper(trim($_POST['claim_code']));
        $reservationModel = new ReservationModel();
        $reservation = $reservationModel->findByClaimCode($code);

        if (!$reservation) {
            flash('error', 'Geçersiz teslim kodu.');
            redirect('/isletme/teslim');
        }

        if ((int) $reservation['venue_id'] !== $this->venueId) {
            flash('error', 'Bu rezervasyon başka bir işletmeye aittir.');
            redirect('/isletme/teslim');
        }

        $service = new ReservationService();
        try {
            $service->claim((int) $reservation['id'], Auth::id());
            flash('success', 'Rezervasyon başarıyla teslim alındı! (' . e($code) . ')');
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
        }
        redirect('/isletme/teslim');
    }
}
