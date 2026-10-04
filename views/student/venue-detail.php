<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-5">
    <a href="<?= url('isletmeler') ?>" class="inline-flex items-center gap-1.5 text-sm text-[#00A3B4] hover:text-[#008899] font-medium transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <?= t('student.back_venues') ?>
    </a>
</div>

<?php
$isOpen = true;
if ($venue['opens_at'] && $venue['closes_at']) {
    $now    = new DateTime();
    $opens  = DateTime::createFromFormat('H:i:s', $venue['opens_at']);
    $closes = DateTime::createFromFormat('H:i:s', $venue['closes_at']);
    $cur    = DateTime::createFromFormat('H:i:s', $now->format('H:i:s'));
    $isOpen = ($cur >= $opens && $cur <= $closes);
}
?>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="h-28 relative" style="background:linear-gradient(135deg,#0d1f3c 0%,#00A3B4 100%);">
        <div class="absolute inset-0 opacity-10"
             style="background-image:radial-gradient(circle at 20% 50%,white 1px,transparent 1px);background-size:24px 24px;"></div>
    </div>
    <div class="px-6 pb-6">
        <div class="flex items-end gap-4 -mt-10 mb-4">
            <div class="w-20 h-20 rounded-2xl flex-shrink-0 flex items-center justify-center text-white text-3xl font-bold shadow-lg border-4 border-white"
                 style="background:linear-gradient(135deg,#00A3B4,#006B76);">
                <?= mb_strtoupper(mb_substr(e($venue['name']), 0, 1)) ?>
            </div>
            <div class="pb-1">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                    <?= $isOpen ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-gray-100 text-gray-500 ring-1 ring-gray-200' ?>">
                    <span class="w-1.5 h-1.5 rounded-full <?= $isOpen ? 'bg-emerald-500 animate-pulse' : 'bg-gray-400' ?>"></span>
                    <?= $isOpen ? t('student.open') : t('student.closed') ?>
                </span>
            </div>
        </div>

        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900"><?= e($venue['name']) ?></h1>
                <p class="text-sm text-gray-500 mt-0.5"><?= e($venue['campus_name']) ?></p>
            </div>
            <a href="<?= url('isletmeler/' . $venue['id'] . '/rezerve') ?>"
               class="flex-shrink-0 px-5 py-2.5 text-white text-sm font-semibold rounded-xl transition-colors inline-flex items-center gap-2 shadow-sm"
               style="background:#00A3B4;" onmouseover="this.style.background='#008899'" onmouseout="this.style.background='#00A3B4'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <?= t('student.make_reserve') ?>
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-4 mt-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
            <?php if ($venue['location']): ?>
            <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($venue['location']) ?>" target="_blank"
               class="flex items-center gap-1.5 hover:text-[#00A3B4] transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <?= e($venue['location']) ?> <span class="text-[#00A3B4]">↗</span>
            </a>
            <?php endif; ?>
            <?php if ($venue['opens_at'] && $venue['closes_at']): ?>
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?= e(substr($venue['opens_at'], 0, 5)) ?> – <?= e(substr($venue['closes_at'], 0, 5)) ?>
            </span>
            <?php endif; ?>
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <?= count($products) ?> <?= t('common.items') ?>
            </span>
        </div>
    </div>
</div>

<div class="flex items-center justify-between mb-5">
    <h2 class="text-base font-bold text-gray-800"><?= t('student.avail_products') ?></h2>
    <span class="text-xs text-gray-400"><?= count($products) ?> <?= t('common.items') ?></span>
</div>

<?php if (empty($products)): ?>
<div class="bg-white rounded-2xl shadow-sm p-14 text-center">
    <svg class="w-14 h-14 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
    </svg>
    <p class="text-sm text-gray-400"><?= t('student.no_reservable') ?></p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($products as $product): ?>
    <?php $free = $stocks[$product['id']] ?? 0; ?>
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-200 <?= $free <= 0 ? 'opacity-60' : '' ?>
                border border-transparent hover:border-[#00A3B4]/30">

        <?php if (!empty($product['image_url'])): ?>
        <div class="relative h-44 overflow-hidden bg-gray-100">
            <img src="<?= url($product['image_url']) ?>"
                 alt="<?= e(pname($product)) ?>"
                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
            <div class="absolute top-2.5 right-2.5">
                <?php if ($free > 0): ?>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/90 backdrop-blur-sm text-emerald-700 text-[11px] font-semibold rounded-full shadow-sm ring-1 ring-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <?= t('student.in_stock') ?>
                </span>
                <?php else: ?>
                <span class="inline-flex items-center px-2.5 py-1 bg-white/90 backdrop-blur-sm text-gray-500 text-[11px] font-semibold rounded-full shadow-sm ring-1 ring-gray-200">
                    <?= t('student.out_of_stock') ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="relative h-44 flex items-center justify-center" style="background:linear-gradient(135deg,#e8f7f9,#d0eef1);">
            <svg class="w-12 h-12 text-[#00A3B4]/25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <div class="absolute top-2.5 right-2.5">
                <?php if ($free > 0): ?>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/90 text-emerald-700 text-[11px] font-semibold rounded-full shadow-sm ring-1 ring-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <?= t('student.in_stock') ?>
                </span>
                <?php else: ?>
                <span class="inline-flex items-center px-2.5 py-1 bg-white/90 text-gray-500 text-[11px] font-semibold rounded-full shadow-sm ring-1 ring-gray-200">
                    <?= t('student.out_of_stock') ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="p-4">
            <?php if ($product['category']): ?>
            <span class="inline-block text-[10px] font-semibold uppercase tracking-wide text-[#00A3B4] bg-[#e8f7f9] px-2 py-0.5 rounded-md mb-2"><?= e($product['category']) ?></span>
            <?php endif; ?>
            <h3 class="font-semibold text-gray-800 text-sm leading-snug"><?= e(pname($product)) ?></h3>
            <?php if ($product['description']): ?>
            <p class="text-xs text-gray-400 mt-1 line-clamp-2"><?= e($product['description']) ?></p>
            <?php endif; ?>
            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                <span class="text-xs text-gray-500">
                    <?= t('student.stock') ?>:
                    <span class="font-bold <?= $free > 0 ? 'text-[#00A3B4]' : 'text-gray-400' ?>"><?= $free ?></span>
                </span>
                <span class="text-xs font-bold text-gray-600"><?= number_format($product['price_snapshot'], 2) ?> ₺</span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
