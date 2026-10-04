<?php

namespace Services;

class QrService
{
    /**
     * 64 karakterlik benzersiz QR token üretir
     */
    public static function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * 6 haneli rakam claim code üretir
     */
    public static function generateClaimCode(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * QR kodu için Google Chart API URL döndürür (harici bağımlılık gerekmez)
     */
    public static function getQrImageUrl(string $data, int $size = 200): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=' . $size . 'x' . $size
             . '&data=' . urlencode($data)
             . '&format=png&margin=10';
    }

    /**
     * QR PNG'sini public/qrcodes/ klasörüne indirir ve dosya yolunu döndürür.
     * GD veya allow_url_fopen yoksa sadece URL döndürür.
     */
    public static function savePng(string $token, int $size = 200): string
    {
        $filename  = $token . '.png';
        $localPath = ROOT . '/public/qrcodes/' . $filename;
        $publicUrl = url('qrcodes/' . $filename);

        if (file_exists($localPath)) {
            return $publicUrl;
        }

        if (!ini_get('allow_url_fopen')) {
            return self::getQrImageUrl($token, $size);
        }

        $imgData = @file_get_contents(self::getQrImageUrl($token, $size));
        if ($imgData !== false) {
            file_put_contents($localPath, $imgData);
            return $publicUrl;
        }

        return self::getQrImageUrl($token, $size);
    }
}
