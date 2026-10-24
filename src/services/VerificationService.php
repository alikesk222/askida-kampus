<?php

namespace Services;

use Core\Database;
use Core\Policies;

/**
 * E-posta doğrulama kodu. Kodun kendisi yalnızca e-postada durur;
 * veritabanında SHA-256 özeti saklanır.
 */
class VerificationService
{
    public const MAX_ATTEMPTS = 5;
    public const RESEND_COOLDOWN = 60;
    public const MAX_RESENDS_PER_HOUR = 5;

    public static function issue(int $userId): string
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        Database::getInstance()->prepare(
            'UPDATE users SET email_verify_token = ?, email_verify_expires = ? WHERE id = ?'
        )->execute([Policies::tokenHash($code), $expires, $userId]);
        unset($_SESSION['verify_fails'][$userId]);
        return $code;
    }

    /**
     * @return 'ok'|'wrong'|'expired'|'locked'
     */
    public static function check(int $userId, string $email, string $code): string
    {
        $fails = (int) ($_SESSION['verify_fails'][$userId] ?? 0);
        if ($fails >= self::MAX_ATTEMPTS) {
            return 'locked';
        }

        $stmt = Database::getInstance()->prepare(
            'SELECT email_verify_token, email_verify_expires FROM users WHERE id = ? AND email = ? LIMIT 1'
        );
        $stmt->execute([$userId, $email]);
        $row = $stmt->fetch();

        $stored = (string) ($row['email_verify_token'] ?? '');
        $hash = Policies::tokenHash($code);
        $matches = $stored !== '' && strlen($stored) === strlen($hash) && hash_equals($stored, $hash);

        if (!$row || !$matches) {
            $_SESSION['verify_fails'][$userId] = $fails + 1;
            if ($_SESSION['verify_fails'][$userId] >= self::MAX_ATTEMPTS) {
                Database::getInstance()->prepare(
                    'UPDATE users SET email_verify_token = NULL, email_verify_expires = NULL WHERE id = ?'
                )->execute([$userId]);
                return 'locked';
            }
            return 'wrong';
        }

        if (!$row['email_verify_expires'] || new \DateTime() > new \DateTime($row['email_verify_expires'])) {
            return 'expired';
        }

        unset($_SESSION['verify_fails'][$userId]);
        return 'ok';
    }

    public static function canResend(int $userId): bool
    {
        $now = time();
        $last = (int) ($_SESSION['verify_resend_at'][$userId] ?? 0);
        if ($now - $last < self::RESEND_COOLDOWN) {
            return false;
        }
        $window = array_values(array_filter(
            $_SESSION['verify_resend_log'][$userId] ?? [],
            static fn ($t) => $now - (int) $t < 3600
        ));
        $_SESSION['verify_resend_log'][$userId] = $window;
        return count($window) < self::MAX_RESENDS_PER_HOUR;
    }

    public static function markResent(int $userId): void
    {
        $now = time();
        $_SESSION['verify_resend_at'][$userId] = $now;
        $_SESSION['verify_resend_log'][$userId][] = $now;
    }
}
