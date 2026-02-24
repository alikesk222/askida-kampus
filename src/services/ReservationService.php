<?php

namespace Services;

use Core\Database;
use Models\ReservationModel;
use Models\StockModel;
use Models\UserModel;
use Models\AuditLogModel;

class ReservationService
{
    private ReservationModel $reservationModel;
    private StockModel       $stockModel;
    private UserModel        $userModel;
    private AuditLogModel    $auditLog;

    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
        $this->stockModel       = new StockModel();
        $this->userModel        = new UserModel();
        $this->auditLog         = new AuditLogModel();
    }

    /**
     * Yeni rezervasyon oluştur
     * $items = [['product_id'=>x, 'quantity'=>y, 'price_snapshot'=>z], ...]
     */
    public function create(int $studentId, int $venueId, array $items): array
    {
        $db     = Database::getInstance();
        $config = require ROOT . '/src/config/app.php';
        $expireMinutes = $config['reservation_expire_min'];

        $student = $this->userModel->findById($studentId);
        if (!$student || !$student['is_active']) {
            throw new \RuntimeException('Öğrenci bulunamadı.');
        }

        // Günlük limit kontrolü
        $todayCount = $this->reservationModel->countTodayByStudent($studentId);
        if ($todayCount >= $student['daily_limit']) {
            throw new \RuntimeException(
                "Günlük rezervasyon limitinize ({$student['daily_limit']}) ulaştınız."
            );
        }

        $db->beginTransaction();
        try {
            // Her ürün için stok kilitle ve kontrol et
            foreach ($items as $item) {
                $stock = $this->stockModel->findByVenueProductForUpdate($venueId, $item['product_id']);
                if (!$stock) {
                    throw new \RuntimeException('Stok bulunamadı.');
                }
                $free = $stock['available_quantity'] - $stock['reserved_quantity'];
                if ($free < $item['quantity']) {
                    throw new \RuntimeException('Yeterli stok yok.');
                }
            }

            // Rezervasyon oluştur
            $token     = QrService::generateToken();
            $claimCode = $this->generateUniqueClaimCode();
            $expiresAt = date('Y-m-d H:i:s', time() + $expireMinutes * 60);

            $reservationId = $this->reservationModel->create([
                'student_id' => $studentId,
                'venue_id'   => $venueId,
                'qr_token'   => $token,
                'claim_code' => $claimCode,
                'expires_at' => $expiresAt,
            ]);

            foreach ($items as $item) {
                $this->reservationModel->createItem([
                    'reservation_id' => $reservationId,
                    'product_id'     => $item['product_id'],
                    'quantity'       => $item['quantity'],
                    'price_snapshot' => $item['price_snapshot'],
                ]);
                $this->stockModel->increaseReserved($venueId, $item['product_id'], $item['quantity']);
            }

            $this->auditLog->log('reservation.create', 'reservation', $reservationId,
                null, ['student_id' => $studentId, 'venue_id' => $venueId]
            );

            $db->commit();

            return [
                'id'         => $reservationId,
                'claim_code' => $claimCode,
                'qr_token'   => $token,
                'expires_at' => $expiresAt,
            ];
        } catch (\Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    /**
     * Rezervasyonu teslim al (kasiyer)
     */
    public function claim(int $reservationId, int $cashierId): void
    {
        $db          = Database::getInstance();
        $reservation = $this->reservationModel->findById($reservationId);

        if (!$reservation) {
            throw new \RuntimeException('Rezervasyon bulunamadı.');
        }
        if ($reservation['status'] !== 'reserved') {
            throw new \RuntimeException('Bu rezervasyon teslim alınamaz (Durum: ' . $reservation['status'] . ').');
        }
        if (strtotime($reservation['expires_at']) < time()) {
            throw new \RuntimeException('Rezervasyonun süresi dolmuş.');
        }

        $items = $this->reservationModel->getItems($reservationId);

        $db->beginTransaction();
        try {
            $this->reservationModel->updateStatus($reservationId, 'claimed', ['claimed_by' => $cashierId]);

            foreach ($items as $item) {
                $this->stockModel->decreaseAvailableAndReserved(
                    $reservation['venue_id'],
                    $item['product_id'],
                    $item['quantity']
                );
            }

            $this->auditLog->log('reservation.claim', 'reservation', $reservationId,
                ['status' => 'reserved'], ['status' => 'claimed', 'cashier_id' => $cashierId]
            );

            $db->commit();
        } catch (\Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    /**
     * Süresi dolan rezervasyonları kapat (cron'dan çağrılır)
     */
    public function expireAll(): int
    {
        $db      = Database::getInstance();
        $expired = $this->reservationModel->getExpired();

        // Gruplama: reservation_id bazında
        $grouped = [];
        foreach ($expired as $row) {
            $id = $row['id'];
            if (!isset($grouped[$id])) {
                $grouped[$id] = [
                    'venue_id' => $row['venue_id'],
                    'items'    => [],
                ];
            }
            $grouped[$id]['items'][] = [
                'product_id' => $row['product_id'],
                'quantity'   => $row['quantity'],
            ];
        }

        $count = 0;
        foreach ($grouped as $reservationId => $data) {
            $db->beginTransaction();
            try {
                $this->reservationModel->updateStatus($reservationId, 'expired');
                foreach ($data['items'] as $item) {
                    $this->stockModel->decreaseReserved(
                        $data['venue_id'],
                        $item['product_id'],
                        $item['quantity']
                    );
                }
                $this->auditLog->log('reservation.expire', 'reservation', $reservationId);
                $db->commit();
                $count++;
            } catch (\Throwable $e) {
                $db->rollBack();
            }
        }
        return $count;
    }

    private function generateUniqueClaimCode(): string
    {
        $reservationModel = $this->reservationModel;
        do {
            $code = QrService::generateClaimCode();
        } while ($reservationModel->findByClaimCode($code) !== null);
        return $code;
    }
}
