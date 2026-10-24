<?php

namespace Core;

/**
 * SMTP şifresi gibi ayarları APP_SECRET ile mühürler.
 * Eski düz metin kayıtlar (enc:v1: öneki yok) okunmaya devam eder ama forma yazılmaz.
 */
class SecretBox
{
    private const PREFIX = 'enc:v1:';

    public static function seal(string $plain): string
    {
        $key = self::key();
        if ($key === null) {
            throw new \RuntimeException('APP_SECRET tanımlı değil.');
        }
        $iv = random_bytes(12);
        $tag = '';
        $cipher = openssl_encrypt($plain, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
        if ($cipher === false || strlen($tag) !== 16) {
            throw new \RuntimeException('Şifreleme başarısız.');
        }
        return self::PREFIX . base64_encode($iv . $tag . $cipher);
    }

    public static function open(string $stored): string
    {
        if ($stored === '' || !str_starts_with($stored, self::PREFIX)) {
            return $stored;
        }
        $key = self::key();
        if ($key === null) {
            return '';
        }
        $raw = base64_decode(substr($stored, strlen(self::PREFIX)), true);
        if ($raw === false || strlen($raw) < 12 + 16 + 1) {
            return '';
        }
        $iv = substr($raw, 0, 12);
        $tag = substr($raw, 12, 16);
        $cipher = substr($raw, 28);
        $plain = openssl_decrypt($cipher, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
        return $plain === false ? '' : $plain;
    }

    public static function isSealed(string $stored): bool
    {
        return str_starts_with($stored, self::PREFIX);
    }

    private static function key(): ?string
    {
        $secret = $_ENV['APP_SECRET'] ?? '';
        if (!is_string($secret) || strlen($secret) < 16) {
            return null;
        }
        return hash('sha256', $secret, true);
    }
}
