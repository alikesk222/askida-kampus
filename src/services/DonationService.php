<?php

namespace Services;

use Core\Database;
use Models\DonationModel;
use Models\StockModel;
use Models\AuditLogModel;

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
     * Bağışı onayla: status = 'paid', stok artır
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
        } catch (\Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }
}
