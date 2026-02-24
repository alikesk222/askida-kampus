<?php

namespace Controllers;

use Core\Auth;
use Core\CSRF;
use Core\Validator;
use Models\VenueModel;
use Models\ProductModel;
use Models\DonationModel;
use Services\DonationService;

class DonorController
{
    public function __construct()
    {
        Auth::requireRole('donor');
    }

    public function venues(): void
    {
        $venueModel = new VenueModel();
        $venues     = $venueModel->getAll(true);
        $pageTitle  = 'Bağış Yapılacak İşletmeler';
        view('donor/venues', compact('pageTitle', 'venues'));
    }

    public function donateForm(string $id): void
    {
        $venueModel   = new VenueModel();
        $productModel = new ProductModel();

        $venue = $venueModel->findById((int)$id);
        if (!$venue || !$venue['is_active']) { http_response_code(404); view('errors/404'); return; }

        $products  = $productModel->getByVenue((int)$id, true);
        $config    = require ROOT . '/src/config/app.php';
        $iban      = $config['iban'];
        $errors    = flash('errors') ?? [];
        $pageTitle = 'Bağış Yap — ' . e($venue['name']);
        view('donor/donate', compact('pageTitle', 'venue', 'products', 'iban', 'errors'));
    }

    public function donateStore(string $id): void
    {
        CSRF::verify();

        $venueModel   = new VenueModel();
        $productModel = new ProductModel();

        $venue = $venueModel->findById((int)$id);
        if (!$venue || !$venue['is_active']) { http_response_code(404); view('errors/404'); return; }

        $quantities = $_POST['qty'] ?? [];
        $items = [];

        foreach ($quantities as $productId => $qty) {
            $qty = (int)$qty;
            if ($qty <= 0) continue;
            $product = $productModel->findById((int)$productId);
            if (!$product || (int)$product['venue_id'] !== (int)$id) continue;
            $items[] = [
                'product_id'     => (int)$productId,
                'quantity'       => $qty,
                'price_snapshot' => (float)$product['price_snapshot'],
            ];
        }

        if (empty($items)) {
            flash('error', 'Lütfen en az bir ürün ve miktar seçin.');
            redirect("/bagis/$id");
        }

        $service = new DonationService();
        try {
            $donationId = $service->create(
                Auth::id(),
                (int)$id,
                $items,
                trim($_POST['notes'] ?? '')
            );
            flash('success', 'Bağışınız alındı! Ödemeniz onaylandıktan sonra stoğa eklenecektir.');
            redirect('/bagislarim');
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
            redirect("/bagis/$id");
        }
    }

    public function donations(): void
    {
        $donationModel = new DonationModel();
        $donations     = $donationModel->getByDonor(Auth::id());
        $pageTitle     = 'Bağışlarım';
        view('donor/donations', compact('pageTitle', 'donations'));
    }
}
