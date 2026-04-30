<?php

namespace Controllers;

use Models\VenueModel;
use Models\ProductModel;
use Models\StockModel;

class PublicController
{
    public function about(): void
    {
        $pageTitle = 'Hakkımızda';
        view('about', compact('pageTitle'));
    }

    public function contact(): void
    {
        $pageTitle = 'İletişim';
        view('contact', compact('pageTitle'));
    }

    public function faq(): void
    {
        $pageTitle = 'Sık Sorulan Sorular';
        view('faq', compact('pageTitle'));
    }

    public function setLang(string $code): void
    {
        if (in_array($code, ['tr', 'en'], true)) {
            $_SESSION['lang'] = $code;
        }
        $ref = $_SERVER['HTTP_REFERER'] ?? '';
        $base = BASE_URL;
        if ($ref && str_starts_with($ref, $base)) {
            header('Location: ' . $ref);
        } else {
            header('Location: ' . $base . '/');
        }
        exit;
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
        view('public/venue-detail', compact('pageTitle', 'venue', 'products', 'stocks'));
    }
}
