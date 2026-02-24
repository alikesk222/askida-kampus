<?php include ROOT . '/views/layout/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Rezervasyonlarım</h1>
        <p class="text-gray-500 text-sm mt-1"><?= count($reservations) ?> rezervasyon</p>
    </div>
    <a href="<?= url('isletmeler') ?>"
       class="px-4 py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
        + Yeni Rezervasyon
    </a>
</div>

<?php if (empty($reservations)): ?>
<div class="bg-white rounded-xl shadow-sm p-10 text-center">
    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
    </div>
    <p class="text-gray-500">Henüz rezervasyonunuz bulunmamaktadır.</p>
    <a href="<?= url('isletmeler') ?>" class="mt-3 inline-block text-[#00A3B4] text-sm hover:underline">
        İşletmelere göz atın →
    </a>
</div>
<?php else: ?>
<div class="space-y-3">
    <?php foreach ($reservations as $r): ?>
    <div class="bg-white rounded-xl shadow-sm p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-[#E0F7FA] rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="text-[#00A3B4] font-bold text-xs font-mono"><?= mb_substr(e($r['claim_code']), 0, 4) ?></span>
            </div>
            <div>
                <p class="font-semibold text-gray-800"><?= e($r['venue_name']) ?></p>
                <p class="text-xs text-gray-400 mt-0.5">
                    Kod: <span class="font-mono font-bold tracking-widest"><?= e($r['claim_code']) ?></span>
                </p>
                <p class="text-xs text-gray-400">
                    Oluşturulma: <?= format_date($r['created_at']) ?>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <?= status_badge($r['status']) ?>
            <?php if ($r['status'] === 'reserved'): ?>
            <span class="text-xs text-orange-500">
                Son: <?= format_date($r['expires_at']) ?>
            </span>
            <a href="<?= url('rezervasyonlarim/' . $r['id'] . '/qr') ?>"
               class="px-3 py-1.5 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-xs font-medium transition">
                QR Göster
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
