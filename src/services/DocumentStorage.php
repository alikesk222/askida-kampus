<?php

namespace Services;

/**
 * Öğrenci belgeleri web kökünün dışında durur.
 * Eski kayıtlar public/assets/documents altında kalmış olabilir; indirme
 * yalnızca bu sınıfın doğruladığı yollardan yapılır.
 */
class DocumentStorage
{
    public static function directory(): string
    {
        $dir = ROOT . '/storage/documents';
        if (!is_dir($dir) && !mkdir($dir, 0750, true) && !is_dir($dir)) {
            throw new \RuntimeException('Belge klasörü oluşturulamadı.');
        }
        return $dir;
    }

    public static function store(int $userId, string $tmpPath, string $ext): string
    {
        $ext = strtolower($ext);
        if (!in_array($ext, ['pdf', 'jpg', 'png', 'webp'], true)) {
            throw new \RuntimeException('Desteklenmeyen dosya türü.');
        }
        $name = 'doc_' . $userId . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $dest = self::directory() . '/' . $name;
        if (!move_uploaded_file($tmpPath, $dest)) {
            throw new \RuntimeException('Dosya kaydedilemedi.');
        }
        @chmod($dest, 0640);
        return 'storage/documents/' . $name;
    }

    public static function resolve(string $storedPath): ?string
    {
        if ($storedPath === '' || str_contains($storedPath, "\0")) {
            return null;
        }
        $storedPath = str_replace('\\', '/', $storedPath);
        $candidate = null;
        if (str_starts_with($storedPath, 'storage/documents/')) {
            $candidate = ROOT . '/' . $storedPath;
        } elseif (preg_match('#^documents/[A-Za-z0-9._-]+$#', $storedPath) === 1) {
            $candidate = ROOT . '/public/assets/' . $storedPath;
        }
        if ($candidate === null) {
            return null;
        }
        $real = realpath($candidate);
        if ($real === false || !is_file($real)) {
            return null;
        }
        foreach (self::allowedRoots() as $root) {
            if (str_starts_with($real, $root . DIRECTORY_SEPARATOR)) {
                return $real;
            }
        }
        return null;
    }

    public static function send(string $path, string $downloadName): void
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $types = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
        ];
        $safe = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($downloadName)) ?: 'belge';
        header('Content-Type: ' . ($types[$ext] ?? 'application/octet-stream'));
        header('X-Content-Type-Options: nosniff');
        header('Content-Disposition: inline; filename="' . $safe . '"');
        header('Content-Length: ' . (string) filesize($path));
        header('Cache-Control: private, no-store');
        readfile($path);
        exit;
    }

    /** @return list<string> */
    private static function allowedRoots(): array
    {
        $roots = [];
        foreach ([ROOT . '/storage/documents', ROOT . '/public/assets/documents'] as $dir) {
            $real = realpath($dir);
            if ($real !== false && is_dir($real)) {
                $roots[] = $real;
            }
        }
        return $roots;
    }
}
