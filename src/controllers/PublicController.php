<?php

namespace Controllers;

use Core\CSRF;
use Core\Database;
use Core\Validator;
use Models\FaqModel;
use Models\VenueModel;
use Models\ProductModel;
use Models\StockModel;
use Services\EmailService;

class PublicController
{
    public function about(): void
    {
        $pageTitle = 'Hakkımızda';
        view('about', compact('pageTitle'));
    }

    public function contact(): void
    {
        $pageTitle  = 'İletişim';
        $old        = flash('old') ?? [];
        $errors     = flash('errors') ?? [];
        view('contact', compact('pageTitle', 'old', 'errors'));
    }

    public function contactStore(): void
    {
        CSRF::verify();

        $v = new Validator($_POST);
        $v->required('name',    'Ad Soyad')
          ->required('email',   'E-posta')
          ->email('email',      'E-posta')
          ->required('subject', 'Konu')
          ->required('message', 'Mesaj')
          ->min('message', 10,  'Mesaj');

        if ($v->fails()) {
            flash('errors', $v->errors());
            flash('old', [
                'name'    => $_POST['name']    ?? '',
                'email'   => $_POST['email']   ?? '',
                'subject' => $_POST['subject'] ?? '',
                'message' => $_POST['message'] ?? '',
            ]);
            redirect('/iletisim');
        }

        // Süper adminin e-postasını veritabanından al
        $db   = Database::getInstance();
        $stmt = $db->query("SELECT email FROM users WHERE role='super-admin' AND is_active=1 ORDER BY id ASC LIMIT 1");
        $admin = $stmt->fetch();

        if (!$admin) {
            flash('error', 'İletişim formu şu an kullanılamıyor.');
            redirect('/iletisim');
        }

        try {
            $emailService = new EmailService();
            $sent = $emailService->sendContactEmail(
                $admin['email'],
                trim($_POST['name']),
                trim($_POST['email']),
                trim($_POST['subject']),
                trim($_POST['message'])
            );

            if ($sent) {
                flash('success', t('contact.form_success'));
            } else {
                flash('error', t('contact.form_error'));
            }
        } catch (\Throwable $e) {
            error_log('İletişim formu hatası: ' . $e->getMessage());
            flash('error', t('contact.form_error'));
        }

        redirect('/iletisim');
    }

    public function faq(): void
    {
        $faqModel  = new FaqModel();
        $faqItems  = $faqModel->getAllActive();
        $pageTitle = 'Sık Sorulan Sorular';
        view('faq', compact('pageTitle', 'faqItems'));
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
