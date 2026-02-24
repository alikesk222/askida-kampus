<?php

namespace Controllers;

use Core\CSRF;
use Core\Validator;
use Core\Database;
use Models\VenueModel;
use Models\ProductModel;
use Models\DonationModel;

class GuestDonorController
{
    public function venuesList(): void
    {
        $venueModel = new VenueModel();
        $venues     = $venueModel->getAll(true);
        $pageTitle  = 'Bağış Yapılacak İşletme Seçin';
        view('guest/venues', compact('pageTitle', 'venues'));
    }

    public function donateForm(string $id): void
    {
        $venueModel   = new VenueModel();
        $productModel = new ProductModel();

        $venue = $venueModel->findById((int)$id);
        if (!$venue || !$venue['is_active']) {
            http_response_code(404); view('errors/404'); return;
        }

        $products  = $productModel->getByVenue((int)$id, true);
        $config    = require ROOT . '/src/config/app.php';
        $iban      = $config['iban'];
        $errors    = flash('errors') ?? [];
        $old       = flash('old') ?? [];
        $pageTitle = 'Bağış Yap — ' . e($venue['name']);
        view('guest/donate', compact('pageTitle', 'venue', 'products', 'iban', 'errors', 'old'));
    }

    public function donateStore(string $id): void
    {
        CSRF::verify();

        $venueModel   = new VenueModel();
        $productModel = new ProductModel();

        $venue = $venueModel->findById((int)$id);
        if (!$venue || !$venue['is_active']) {
            http_response_code(404); view('errors/404'); return;
        }

        $v = new Validator($_POST);
        $v->required('donor_name', 'Adınız')
          ->required('donor_email', 'E-posta')
          ->email('donor_email', 'E-posta');

        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('old', ['donor_name' => $_POST['donor_name'] ?? '', 'donor_email' => $_POST['donor_email'] ?? '']);
            redirect("/misafir-bagis/$id");
        }

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
            flash('old', ['donor_name' => $_POST['donor_name'] ?? '', 'donor_email' => $_POST['donor_email'] ?? '']);
            redirect("/misafir-bagis/$id");
        }

        $totalAmount = array_sum(array_map(fn($i) => $i['quantity'] * $i['price_snapshot'], $items));

        $donationModel = new DonationModel();
        $db = Database::getInstance();

        try {
            $db->beginTransaction();
            $donationId = $donationModel->create([
                'donor_id'    => null,
                'venue_id'    => (int)$id,
                'total_amount'=> $totalAmount,
                'notes'       => trim($_POST['notes'] ?? ''),
                'donor_name'  => trim($_POST['donor_name']),
                'donor_email' => trim($_POST['donor_email']),
                'is_guest'    => 1,
            ]);
            foreach ($items as $item) {
                $donationModel->createItem(['donation_id' => $donationId] + $item);
            }
            $db->commit();
        } catch (\Throwable $e) {
            $db->rollBack();
            flash('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
            redirect("/misafir-bagis/$id");
        }

        $config = require ROOT . '/src/config/app.php';
        $iban   = $config['iban'];
        view('guest/thanks', compact('donationId', 'totalAmount', 'iban'));
    }
}
