<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <a href="<?= url('rezervasyonlarim') ?>" class="text-[#00A3B4] text-sm hover:underline">← <?= t('student.reservations') ?></a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2"><?= t('student.res_code_title') ?></h1>
</div>

<div class="max-w-sm mx-auto">
    <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
        <div class="mb-4">
            <?= status_badge($reservation['status']) ?>
        </div>

        <?php if ($reservation['status'] === 'reserved'): ?>
            <div class="bg-gradient-to-br from-[#00A3B4] to-[#005F6B] rounded-2xl p-6 mb-5">
                <p class="text-white/70 text-xs font-semibold uppercase tracking-widest mb-2"><?= t('student.claim_code_title') ?></p>
                <p class="text-5xl font-mono font-black tracking-[0.2em] text-white drop-shadow">
                    <?= e($reservation['claim_code']) ?>
                </p>
                <p class="text-white/60 text-xs mt-3"><?= t('student.tell_cashier') ?></p>
            </div>
        <?php else: ?>
            <div class="bg-gray-50 rounded-xl p-4 mb-4">
                <p class="text-xs text-gray-400 mb-1"><?= t('student.claim_code') ?></p>
                <p class="text-3xl font-mono font-bold tracking-[0.3em] text-gray-800">
                    <?= e($reservation['claim_code']) ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="text-sm space-y-2 text-left border-t border-gray-100 pt-4">
            <div class="flex justify-between">
                <span class="text-gray-500"><?= t('student.venue') ?></span>
                <span class="font-medium text-gray-800"><?= e($reservation['venue_name']) ?></span>
            </div>
            <?php if ($reservation['status'] === 'reserved'): ?>
                <div class="flex justify-between">
                    <span class="text-gray-500"><?= t('student.expires_at') ?></span>
                    <span class="font-medium text-orange-500"><?= format_date($reservation['expires_at']) ?></span>
                </div>
            <?php endif; ?>
            <div class="flex justify-between">
                <span class="text-gray-500"><?= t('student.created_at') ?></span>
                <span class="text-gray-600"><?= format_date($reservation['created_at']) ?></span>
            </div>
        </div>

        <?php if (!empty($items)): ?>
            <div class="mt-4 border-t border-gray-100 pt-4 text-left">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2"><?= t('student.items_to_collect') ?></p>
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
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
            <p class="text-sm text-blue-700 font-medium"><?= t('student.cashier_only') ?></p>
            <p class="text-xs text-blue-500 mt-1"><?= t('student.no_qr') ?></p>
        </div>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
