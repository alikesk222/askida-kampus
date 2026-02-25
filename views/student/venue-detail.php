<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <a href="<?= url('isletmeler') ?>" class="text-[#00A3B4] text-sm hover:underline inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        İşletmelere Dön
    </a>
</div>

<!-- İşletme Header -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="h-32 bg-gradient-to-br from-[#00A3B4] to-[#007A8A] relative">
        <div class="absolute inset-0 bg-black/10"></div>
    </div>
    <div class="px-6 pb-6 -mt-12 relative">
        <div class="flex items-start gap-4">
            <div class="w-24 h-24 bg-white rounded-2xl shadow-lg flex items-center justify-center border-4 border-white">
                <span class="text-4xl font-bold text-[#00A3B4]"><?= mb_substr(e($venue['name']), 0, 1) ?></span>
            </div>
            <div class="flex-1 mt-12">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800"><?= e($venue['name']) ?></h1>
                        <p class="text-sm text-gray-500 mt-1"><?= e($venue['campus_name']) ?></p>
                    </div>
                    <?php
                    $isOpen = true;
                    if ($venue['opens_at'] && $venue['closes_at']) {
                        $now = new DateTime();
                        $opens = DateTime::createFromFormat('H:i:s', $venue['opens_at']);
                        $closes = DateTime::createFromFormat('H:i:s', $venue['closes_at']);
                        $currentTime = DateTime::createFromFormat('H:i:s', $now->format('H:i:s'));
                        $isOpen = ($currentTime >= $opens && $currentTime <= $closes);
                    }
                    ?>
                    <?php if ($isOpen): ?>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Açık</span>
                    <?php else: ?>
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">Kapalı</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- İşletme Bilgileri -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <?php if ($venue['location']): ?>
    <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($venue['location']) ?>" target="_blank" class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition block">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-xs text-gray-500">Konum</p>
                <p class="text-sm font-medium text-gray-800"><?= e($venue['location']) ?></p>
                <p class="text-xs text-blue-600 mt-1">Haritada Gör →</p>
            </div>
        </div>
    </a>
    <?php endif; ?>

    <?php if ($venue['opens_at'] && $venue['closes_at']): ?>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Çalışma Saatleri</p>
                <p class="text-sm font-medium text-gray-800"><?= e($venue['opens_at']) ?> – <?= e($venue['closes_at']) ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Mevcut Ürün</p>
                <p class="text-sm font-medium text-gray-800"><?= count($products) ?> Çeşit</p>
            </div>
        </div>
    </div>
</div>

<!-- Ürünler -->
<div class="bg-white rounded-2xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">Mevcut Ürünler</h2>
        <a href="<?= url('isletmeler/' . $venue['id'] . '/rezerve') ?>" 
           class="px-6 py-2.5 bg-[#00A3B4] hover:bg-[#008899] text-white rounded-lg text-sm font-medium transition inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Rezervasyon Yap
        </a>
    </div>

    <?php if (empty($products)): ?>
    <div class="text-center py-12 text-gray-400">
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        <p class="text-sm">Henüz ürün bulunmamaktadır.</p>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($products as $product): ?>
        <div class="border border-gray-200 rounded-xl p-4 hover:border-[#00A3B4] transition">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800 text-sm"><?= e($product['name']) ?></h3>
                    <?php if ($product['description']): ?>
                    <p class="text-xs text-gray-500 mt-1 line-clamp-2"><?= e($product['description']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                <div>
                    <p class="text-xs text-gray-500">Stok</p>
                    <p class="text-sm font-semibold <?= ($stocks[$product['id']] ?? 0) > 0 ? 'text-green-600' : 'text-red-600' ?>">
                        <?= $stocks[$product['id']] ?? 0 ?> Adet
                    </p>
                </div>
                <?php if (($stocks[$product['id']] ?? 0) > 0): ?>
                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">Mevcut</span>
                <?php else: ?>
                <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full font-medium">Tükendi</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
