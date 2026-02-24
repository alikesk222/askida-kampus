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

class VenueAdminController
{
    private int $venueId;

    public function __construct()
    {
        Auth::requireRole('venue-admin');
        $userModel     = new UserModel();
        $this->venueId = $userModel->getVenueIdForUser(Auth::id()) ?? 0;
        if (!$this->venueId) {
            flash('error', 'Atandığınız bir işletme bulunamadı.');
            redirect('/giris');
        }
    }

    public function dashboard(): void
    {
        $venueModel       = new VenueModel();
        $stockModel       = new StockModel();
        $donationModel    = new DonationModel();
        $reservationModel = new ReservationModel();

        $venue     = $venueModel->findById($this->venueId);
        $freeStock = $stockModel->getTotalAvailable($this->venueId);
        $waiting   = $donationModel->countByVenue($this->venueId);
        $active    = $reservationModel->getByVenue($this->venueId, 1, 5);

        $pageTitle = 'İşletme Paneli';
        view('venue_admin/dashboard', compact('pageTitle', 'venue', 'freeStock', 'waiting', 'active'));
    }

    public function stock(): void
    {
        $venueModel = new VenueModel();
        $stockModel = new StockModel();
        $venue      = $venueModel->findById($this->venueId);
        $stocks     = $stockModel->getByVenue($this->venueId);
        $pageTitle  = 'Stok Durumu';
        view('venue_admin/stock', compact('pageTitle', 'venue', 'stocks'));
    }

    public function donations(): void
    {
        $donationModel = new DonationModel();
        $page          = max(1, (int)($_GET['sayfa'] ?? 1));
        $donations     = $donationModel->getByVenue($this->venueId, $page, 20);
        $total         = $donationModel->countByVenue($this->venueId);
        $pageTitle     = 'Bağışlar';
        view('venue_admin/donations', compact('pageTitle', 'donations', 'page', 'total'));
    }

    public function donationApprove(string $id): void
    {
        CSRF::verify();
        $donationModel = new DonationModel();
        $donation      = $donationModel->findById((int)$id);

        if (!$donation || (int)$donation['venue_id'] !== $this->venueId) {
            flash('error', 'Bağış bulunamadı.');
            redirect('/isletme/bagislar');
        }

        $service = new DonationService();
        try {
            $service->approve((int)$id, Auth::id());
            flash('success', 'Bağış onaylandı ve stok güncellendi.');
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
        }
        redirect('/isletme/bagislar');
    }

    public function reservations(): void
    {
        $reservationModel = new ReservationModel();
        $page             = max(1, (int)($_GET['sayfa'] ?? 1));
        $reservations     = $reservationModel->getByVenue($this->venueId, $page, 20);
        $total            = $reservationModel->countAll();
        $pageTitle        = 'Rezervasyonlar';
        view('venue_admin/reservations', compact('pageTitle', 'reservations', 'page', 'total'));
    }
}
