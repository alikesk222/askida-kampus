<?php

namespace Controllers;

use Core\Auth;
use Core\CSRF;
use Models\SettingsModel;
use Models\VenueModel;
use Models\ProductModel;
use Models\StockModel;
use Models\ReservationModel;
use Services\ReservationService;
use Services\QrService;

class StudentController
{
    public function __construct()
    {
        Auth::requireRole('student');
    }

    public function venues(): void
    {
        $venueModel = new VenueModel();
        $venues     = $venueModel->getAll(true);
        $pageTitle  = 'İşletmeler';
        view('student/venues', compact('pageTitle', 'venues'));
    }

    public function venueDetail(string $id): void
    {
        $venueModel   = new VenueModel();
        $productModel = new ProductModel();
        $stockModel   = new StockModel();

        $venue = $venueModel->findById((int)$id);
        if (!$venue || !$venue['is_active']) { 
            http_response_code(404); 
            view('errors/404'); 
            return; 
        }

        $products = $productModel->getByVenue((int)$id, true);
        $stocks   = [];
        foreach ($products as $p) {
            $stocks[$p['id']] = $stockModel->getFreeQuantity((int)$id, $p['id']);
        }

        $pageTitle = e($venue['name']);
        view('student/venue-detail', compact('pageTitle', 'venue', 'products', 'stocks'));
    }

    public function reserveForm(string $id): void
    {
        $venueModel   = new VenueModel();
        $productModel = new ProductModel();
        $stockModel   = new StockModel();

        $venue    = $venueModel->findById((int)$id);
        if (!$venue || !$venue['is_active']) { http_response_code(404); view('errors/404'); return; }

        $products = $productModel->getByVenue((int)$id, true);
        $stocks   = [];
        foreach ($products as $p) {
            $stocks[$p['id']] = $stockModel->getFreeQuantity((int)$id, $p['id']);
        }

        $reservationModel = new ReservationModel();
        $settingsModel    = new SettingsModel();
        $currentUser      = Auth::user();
        $weeklyLimit      = $currentUser['weekly_limit'] !== null
            ? (int) $currentUser['weekly_limit']
            : (int) $settingsModel->get('student_weekly_limit', 5);
        $weeklyUsed       = $reservationModel->countWeekItemsByStudent(Auth::id());
        $weeklyRemaining  = max(0, $weeklyLimit - $weeklyUsed);

        $errors    = flash('errors') ?? [];
        $pageTitle = 'Rezervasyon — ' . e($venue['name']);
        view('student/reserve', compact('pageTitle', 'venue', 'products', 'stocks', 'errors', 'weeklyLimit', 'weeklyUsed', 'weeklyRemaining'));
    }

    public function reserveStore(string $id): void
    {
        CSRF::verify();
        Auth::requireRole('student');

        $venueModel   = new VenueModel();
        $productModel = new ProductModel();

        $venue = $venueModel->findById((int)$id);
        if (!$venue || !$venue['is_active']) { http_response_code(404); view('errors/404'); return; }

        // qty[product_id] => quantity
        $quantities = $_POST['qty'] ?? [];
        $items = [];
        $hasAny = false;

        foreach ($quantities as $productId => $qty) {
            $qty = (int)$qty;
            if ($qty <= 0) continue;
            $hasAny = true;
            $product = $productModel->findById((int)$productId);
            if (!$product || (int)$product['venue_id'] !== (int)$id) continue;
            $items[] = [
                'product_id'     => (int)$productId,
                'quantity'       => $qty,
                'price_snapshot' => (float)$product['price_snapshot'],
            ];
        }

        if (!$hasAny || empty($items)) {
            flash('error', 'Lütfen en az bir ürün seçin.');
            redirect("/isletmeler/$id/rezerve");
        }

        $service = new ReservationService();
        try {
            $result = $service->create(Auth::id(), (int)$id, $items);
            flash('success', 'Rezervasyonunuz oluşturuldu! Kod: ' . $result['claim_code']);
            redirect('/rezervasyonlarim/' . $result['id'] . '/qr');
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
            redirect("/isletmeler/$id/rezerve");
        }
    }

    public function reservations(): void
    {
        $reservationModel = new ReservationModel();
        $reservations     = $reservationModel->getByStudent(Auth::id());
        $pageTitle        = 'Rezervasyonlarım';
        view('student/reservations', compact('pageTitle', 'reservations'));
    }

    public function showQr(string $id): void
    {
        $reservationModel = new ReservationModel();
        $reservation      = $reservationModel->findById((int)$id);

        if (!$reservation || (int)$reservation['student_id'] !== Auth::id()) {
            http_response_code(404); view('errors/404'); return;
        }

        $items    = $reservationModel->getItems((int)$id);
        $qrImgUrl = QrService::getQrImageUrl($reservation['qr_token']);
        $pageTitle = 'QR Kod — ' . $reservation['claim_code'];
        view('student/qr', compact('pageTitle', 'reservation', 'items', 'qrImgUrl'));
    }
}
