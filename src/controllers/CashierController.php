<?php

namespace Controllers;

use Core\Auth;
use Core\CSRF;
use Core\Validator;
use Models\UserModel;
use Models\VenueModel;
use Models\ReservationModel;
use Services\ReservationService;

class CashierController
{
    private int $venueId;

    public function __construct()
    {
        Auth::requireRole('cashier');
        $userModel     = new UserModel();
        $this->venueId = $userModel->getVenueIdForUser(Auth::id()) ?? 0;
        if (!$this->venueId) {
            flash('error', 'Atandığınız bir işletme bulunamadı.');
            redirect('/giris');
        }
    }

    public function dashboard(): void
    {
        $venueModel = new VenueModel();
        $venue      = $venueModel->findById($this->venueId);
        $errors     = flash('errors') ?? [];
        $pageTitle  = 'Kasa';
        view('cashier/dashboard', compact('pageTitle', 'venue', 'errors'));
    }

    public function claim(): void
    {
        CSRF::verify();

        $v = new Validator($_POST);
        $v->required('claim_code', 'Teslim Kodu');
        if ($v->fails()) {
            flash('error', $v->firstError());
            redirect('/kasa');
        }

        $code             = strtoupper(trim($_POST['claim_code']));
        $reservationModel = new ReservationModel();
        $reservation      = $reservationModel->findByClaimCode($code);

        if (!$reservation) {
            flash('error', 'Geçersiz teslim kodu.');
            redirect('/kasa');
        }

        if ((int)$reservation['venue_id'] !== $this->venueId) {
            flash('error', 'Bu rezervasyon başka bir işletmeye aittir.');
            redirect('/kasa');
        }

        $service = new ReservationService();
        try {
            $service->claim((int)$reservation['id'], Auth::id());
            flash('success', 'Rezervasyon başarıyla teslim alındı! (' . e($code) . ')');
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
        }
        redirect('/kasa');
    }
}
