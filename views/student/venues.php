<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">İşletmeler</h1>
    <p class="text-gray-500 text-sm mt-1">Askıda ürün rezervasyonu yapabileceğiniz işletmeler</p>
</div>

<?php if (empty($venues)): ?>
<div class="bg-white rounded-xl shadow-sm p-10 text-center text-gray-400">
    Şu an aktif işletme bulunmamaktadır.
</div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php foreach ($venues as $venue): ?>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
        <div class="h-2 bg-[#00A3B4]"></div>
        <div class="p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h2 class="font-semibold text-gray-800 text-base"><?= e($venue['name']) ?></h2>
                    <p class="text-xs text-gray-500 mt-0.5"><?= e($venue['campus_name']) ?></p>
                </div>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">Açık</span>
            </div>

            <?php if ($venue['location']): ?>
            <p class="text-xs text-gray-500 flex items-center gap-1 mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <?= e($venue['location']) ?>
            </p>
            <?php endif; ?>

            <?php if ($venue['opens_at'] && $venue['closes_at']): ?>
            <p class="text-xs text-gray-500 flex items-center gap-1 mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?= e($venue['opens_at']) ?> – <?= e($venue['closes_at']) ?>
            </p>
            <?php else: ?>
            <div class="mb-4"></div>
            <?php endif; ?>

            <div class="flex gap-2">
                <a href="<?= url('isletmeler/' . $venue['id']) ?>"
                   class="flex-1 text-center py-2 border border-[#00A3B4] text-[#00A3B4] hover:bg-[#00A3B4] hover:text-white rounded-lg text-sm font-medium transition">
                    Detay
                </a>
                <a href="<?= url('isletmeler/' . $venue['id'] . '/rezerve') ?>"
                   class="flex-1 text-center py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
                    Rezerve Et
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
