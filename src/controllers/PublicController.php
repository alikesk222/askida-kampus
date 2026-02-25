<?php

namespace Controllers;

use Models\VenueModel;
use Models\ProductModel;
use Models\StockModel;

class PublicController
{
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
