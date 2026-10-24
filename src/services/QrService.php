<?php

namespace Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

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
     * Kasadaki okuyucu ve sözlü teslim 6 haneli kod kullanır (kolon CHAR(6)).
     * Kod üçüncü bir servise gönderilmez; görüntü bu sunucuda üretilir.
     */
    public static function generateClaimCode(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * img src için yerel SVG data URI. Dış ağ çağrısı yapmaz.
     */
    public static function getQrImageUrl(string $data, int $size = 200): string
    {
        if (!class_exists(QRCode::class)) {
            return '';
        }
        $scale = max(3, (int) round($size / 40));
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'outputBase64' => true,
            'scale' => $scale,
            'addQuietzone' => true,
            'drawLightModules' => true,
            'svgUseFillAttributes' => true,
        ]);
        try {
            return (new QRCode($options))->render($data);
        } catch (\Throwable $e) {
            error_log('QR üretilemedi: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Eski çağrılar için. Dosyaya yazmak yerine yerel data URI döndürür.
     */
    public static function savePng(string $token, int $size = 200): string
    {
        return self::getQrImageUrl($token, $size);
    }
}
