<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <a href="<?= url('rezervasyonlarim') ?>" class="text-[#00A3B4] text-sm hover:underline">← Rezervasyonlarım</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">QR Kod</h1>
</div>

<div class="max-w-sm mx-auto">
    <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
        <!-- Durum -->
        <div class="mb-4">
            <?= status_badge($reservation['status']) ?>
        </div>

        <!-- QR Görsel -->
        <?php if ($reservation['status'] === 'reserved'): ?>
        <div class="flex justify-center mb-4">
            <div class="p-3 border-2 border-[#00A3B4] rounded-xl inline-block">
                <img src="<?= e($qrImgUrl) ?>" alt="QR Kod"
                     class="w-48 h-48 block" loading="lazy">
            </div>
        </div>
        <?php endif; ?>

        <!-- Kod -->
        <div class="bg-gray-50 rounded-xl p-4 mb-4">
            <p class="text-xs text-gray-400 mb-1">Teslim Kodu</p>
            <p class="text-3xl font-mono font-bold tracking-[0.3em] text-gray-800">
                <?= e($reservation['claim_code']) ?>
            </p>
        </div>

        <!-- Detaylar -->
        <div class="text-sm space-y-2 text-left border-t border-gray-100 pt-4">
            <div class="flex justify-between">
                <span class="text-gray-500">İşletme</span>
                <span class="font-medium text-gray-800"><?= e($reservation['venue_name']) ?></span>
            </div>
            <?php if ($reservation['status'] === 'reserved'): ?>
            <div class="flex justify-between">
                <span class="text-gray-500">Son Kullanma</span>
                <span class="font-medium text-orange-500"><?= format_date($reservation['expires_at']) ?></span>
            </div>
            <?php endif; ?>
            <div class="flex justify-between">
                <span class="text-gray-500">Oluşturulma</span>
                <span class="text-gray-600"><?= format_date($reservation['created_at']) ?></span>
            </div>
        </div>

        <!-- Ürünler -->
        <?php if (!empty($items)): ?>
        <div class="mt-4 border-t border-gray-100 pt-4 text-left">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Ürünler</p>
            <div class="space-y-1">
                <?php foreach ($items as $item): ?>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-700"><?= e($item['product_name']) ?> × <?= e($item['quantity']) ?></span>
                    <?php if (auth()['role'] !== 'student'): ?>
                    <span class="text-gray-500">₺<?= number_format($item['price_snapshot'] * $item['quantity'], 2, ',', '.') ?></span>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php if ($reservation['status'] === 'reserved'): ?>
    <p class="text-center text-xs text-gray-400 mt-4">
        Bu QR kodu veya teslim kodunu kasiyere gösterin.
    </p>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
