<?php

namespace Services;

use Core\Database;
use Models\DonationModel;
use Models\StockModel;
use Models\AuditLogModel;
use Models\UserModel;
use Models\VenueModel;

class DonationService
{
    private DonationModel $donationModel;
    private StockModel    $stockModel;
    private AuditLogModel $auditLog;

    public function __construct()
    {
        $this->donationModel = new DonationModel();
        $this->stockModel    = new StockModel();
        $this->auditLog      = new AuditLogModel();
    }

    /**
     * Yeni bağış oluştur (items dahil). Status: waiting_approval
     * $items = [['product_id'=>x, 'quantity'=>y, 'price_snapshot'=>z], ...]
     */
    public function create(int $donorId, int $venueId, array $items, ?string $notes = null): int
    {
        $db = Database::getInstance();
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item['price_snapshot'] * $item['quantity'];
        }

        $db->beginTransaction();
        try {
            $donationId = $this->donationModel->create([
                'donor_id'     => $donorId,
                'venue_id'     => $venueId,
                'total_amount' => $totalAmount,
                'notes'        => $notes,
            ]);

            foreach ($items as $item) {
                $this->donationModel->createItem([
                    'donation_id'    => $donationId,
                    'product_id'     => $item['product_id'],
                    'quantity'       => $item['quantity'],
                    'price_snapshot' => $item['price_snapshot'],
                ]);
            }

            $this->auditLog->log('donation.create', 'donation', $donationId,
                null, ['donor_id' => $donorId, 'venue_id' => $venueId, 'total' => $totalAmount]
            );

            $db->commit();
            return $donationId;
        } catch (\Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    /**
     * Bağışı onayla: status = 'paid', stok artır, email gönder
     */
    public function approve(int $donationId, int $approvedBy): void
    {
        $db = Database::getInstance();
        $donation = $this->donationModel->findById($donationId);

        if (!$donation || $donation['status'] !== 'waiting_approval') {
            throw new \RuntimeException('Bağış onaylanamaz.');
        }

        $items = $this->donationModel->getItems($donationId);

        $db->beginTransaction();
        try {
            $this->donationModel->approve($donationId, $approvedBy);

            foreach ($items as $item) {
                $this->stockModel->increaseAvailable(
                    $donation['venue_id'],
                    $item['product_id'],
                    $item['quantity']
                );
            }

            $this->auditLog->log('donation.approve', 'donation', $donationId,
                ['status' => 'waiting_approval'], ['status' => 'paid', 'approved_by' => $approvedBy]
            );

            $db->commit();
            
            // Email gönder
            $this->sendThankYouEmail($donation, $items);
            
        } catch (\Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    /**
     * Bağışçıya teşekkür emaili gönder
     */
    private function sendThankYouEmail(array $donation, array $items): void
    {
        try {
            $userModel = new UserModel();
            $venueModel = new VenueModel();
            
            $donor = $userModel->findById($donation['donor_id']);
            $venue = $venueModel->findById($donation['venue_id']);
            
            if (!$donor || !$venue) {
                return;
            }

            $donationDetails = [
                'venue_name' => $venue['name'],
                'total_amount' => $donation['total_amount'],
                'created_at' => $donation['created_at'],
                'items' => $items
            ];

            $donorName = $donor['name'] ?? $donor['email'];
            
            $emailService = new EmailService();
            $emailService->sendDonationThankYouEmail($donor['email'], $donorName, $donationDetails);
            
        } catch (\Throwable $e) {
            // Email gönderme hatası bağış onayını etkilemesin
            error_log("Bağış teşekkür emaili gönderilemedi: " . $e->getMessage());
        }
    }
}
