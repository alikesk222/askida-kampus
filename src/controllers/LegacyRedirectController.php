<?php

namespace Controllers;

/**
 * Eski /kasa URL'lerini yeni /isletme/teslim adresine yönlendirir.
 * Geriye dönük uyumluluk için tutulmuştur.
 */
class LegacyRedirectController
{
    public function kasaTeslim(): void
    {
        header('Location: ' . BASE_URL . '/isletme/teslim', true, 308);
        exit;
    }

    public function kasaTeslimPost(): void
    {
        header('Location: ' . BASE_URL . '/isletme/teslim', true, 308);
        exit;
    }
}
