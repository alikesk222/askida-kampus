<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Bağış Yapılacak İşletmeler</h1>
    <p class="text-gray-500 text-sm mt-1">Kampüs öğrencilerine destek olmak için bir işletme seçin</p>
</div>

<?php if (empty($venues)): ?>
<div class="bg-white rounded-xl shadow-sm p-10 text-center text-gray-400">
    Şu an aktif işletme bulunmamaktadır.
</div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php foreach ($venues as $venue): ?>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
        <div class="h-2 bg-gradient-to-r from-[#00A3B4] to-[#007A8A]"></div>
        <div class="p-5">
            <div class="mb-3">
                <h2 class="font-semibold text-gray-800 text-base"><?= e($venue['name']) ?></h2>
                <p class="text-xs text-gray-500 mt-0.5"><?= e($venue['campus_name']) ?></p>
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

            <?php if ($venue['description']): ?>
            <p class="text-xs text-gray-500 mb-4 line-clamp-2"><?= e($venue['description']) ?></p>
            <?php else: ?>
            <div class="mb-4"></div>
            <?php endif; ?>

            <a href="<?= url('bagis/' . $venue['id']) ?>"
               class="block w-full text-center py-2 bg-gradient-to-r from-[#00A3B4] to-[#007A8A] hover:from-[#007A8A] hover:to-[#005F6B] text-white rounded-lg text-sm font-medium transition">
                Bağış Yap
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
