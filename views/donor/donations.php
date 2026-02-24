<?php include ROOT . '/views/layout/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Bağışlarım</h1>
        <p class="text-gray-500 text-sm mt-1"><?= count($donations) ?> bağış</p>
    </div>
    <a href="<?= url('bagis') ?>"
       class="px-4 py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
        + Yeni Bağış
    </a>
</div>

<?php if (empty($donations)): ?>
<div class="bg-white rounded-xl shadow-sm p-10 text-center">
    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <p class="text-gray-500">Henüz bağış yapmadınız.</p>
    <a href="<?= url('bagis') ?>" class="mt-3 inline-block text-[#00A3B4] text-sm hover:underline">
        Bağış yapmak için tıklayın →
    </a>
</div>
<?php else: ?>
<div class="space-y-3">
    <?php foreach ($donations as $d): ?>
    <div class="bg-white rounded-xl shadow-sm p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-[#E0F7FA] rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[#00A3B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800"><?= e($d['venue_name']) ?></p>
                <p class="text-xs text-gray-400 mt-0.5"><?= format_date($d['created_at']) ?></p>
                <?php if ($d['notes']): ?>
                <p class="text-xs text-gray-500 mt-0.5 italic"><?= e($d['notes']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="font-bold text-lg text-gray-800">₺<?= number_format($d['total_amount'], 2, ',', '.') ?></p>
                <?php if ($d['approved_at']): ?>
                <p class="text-xs text-gray-400">Onay: <?= format_date($d['approved_at'], 'd.m.Y') ?></p>
                <?php endif; ?>
            </div>
            <?= status_badge($d['status']) ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
