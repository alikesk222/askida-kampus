<?php

/*
 * Cron Job: Süresi dolan rezervasyonları kapat ve stoku iade et.
 * Crontab: dakika-5 * * * * php /path/to/askida/cron/expire_reservations.php
 */

define('ROOT', dirname(__DIR__));

require ROOT . '/src/bootstrap.php';

use Services\ReservationService;

$service = new ReservationService();
$count   = $service->expireAll();

$msg = date('Y-m-d H:i:s') . " — $count rezervasyon sona erdirildi.\n";
echo $msg;

// İsteğe bağlı: log dosyasına yaz
file_put_contents(ROOT . '/cron/expire.log', $msg, FILE_APPEND);
