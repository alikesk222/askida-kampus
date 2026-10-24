<?php

namespace Core;

/**
 * Saf kararlar: rol, öğrenci e-postası, miktar sınırı, token özeti.
 * Veritabanı kullanmaz; testler doğrudan bu sınıfı çağırır.
 */
class Policies
{
    public const MAX_LINE_QTY = 50;

    public static function tokenHash(string $token): string
    {
        return hash('sha256', $token);
    }

    public static function isStudentEmail(string $email): bool
    {
        $email = strtolower(trim($email));
        $at = strrpos($email, '@');
        if ($at === false || $at === 0) {
            return false;
        }
        return substr($email, $at + 1) === 'ogr.aybu.edu.tr';
    }

    /** @return list<string> */
    public static function assignableRoles(string $actorRole): array
    {
        if ($actorRole === 'super-admin') {
            return ['super-admin', 'university-admin', 'venue-admin', 'student', 'donor'];
        }
        if ($actorRole === 'university-admin') {
            return ['venue-admin', 'student', 'donor'];
        }
        return [];
    }

    public static function canManageUser(string $actorRole, int $actorId, string $targetRole, int $targetId): bool
    {
        if ($actorRole === 'super-admin') {
            return true;
        }
        if ($actorRole !== 'university-admin') {
            return false;
        }
        if ($actorId === $targetId) {
            return false;
        }
        return in_array($targetRole, self::assignableRoles($actorRole), true);
    }

    /**
     * Formdan gelen adet. 0 geçerlidir (satır atlanır). Geçersiz veya üst sınırın
     * üstündeyse false döner; çağıran isteği reddetmelidir.
     */
    public static function parseBoundedQty(mixed $raw, int $max = self::MAX_LINE_QTY): int|false
    {
        if (is_int($raw)) {
            $n = $raw;
        } elseif (is_string($raw) && preg_match('/^\d{1,2}$/', $raw) === 1) {
            $n = (int) $raw;
        } else {
            return false;
        }
        if ($n < 0 || $n > $max) {
            return false;
        }
        return $n;
    }

    public static function imageExtensionForMime(string $mime): ?string
    {
        return match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            default => null,
        };
    }
}
