<?php include ROOT . '/views/layout/header.php'; ?>

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

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="breadcrumb">
            <a href="<?= url('isletmeler') ?>">← <?= t('student.back_venues') ?></a>
        </nav>
        <h1 class="page-title"><?= e($venue['name']) ?></h1>
        <p class="page-desc"><?= e($venue['campus_name']) ?></p>
    </div>
    <div class="page-actions">
        <span class="badge <?= $isOpen ? 'badge-approved' : 'badge-expired' ?>"><?= $isOpen ? t('student.open') : t('student.closed') ?></span>
        <a href="<?= url('isletmeler/' . $venue['id'] . '/rezerve') ?>" class="btn btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <?= t('student.make_reserve') ?>
        </a>
    </div>
</div>

<div class="card p-5 mb-6">
    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-600">
        <?php if ($venue['location']): ?>
        <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($venue['location']) ?>" target="_blank"
           class="link inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <?= e($venue['location']) ?> ↗
        </a>
        <?php endif; ?>
        <?php if ($venue['opens_at'] && $venue['closes_at']): ?>
        <span class="inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <?= e(substr($venue['opens_at'], 0, 5)) ?> – <?= e(substr($venue['closes_at'], 0, 5)) ?>
        </span>
        <?php endif; ?>
        <span class="inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <?= count($products) ?> <?= t('common.items') ?>
        </span>
    </div>
</div>

<div class="flex items-center justify-between mb-4">
    <h2 class="text-base font-bold text-slate-900"><?= t('student.avail_products') ?></h2>
    <span class="badge badge-gold-soft"><?= count($products) ?> <?= t('common.items') ?></span>
</div>

<?php if (empty($products)): ?>
<div class="empty-state card">
    <div class="empty-state-icon">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
    </div>
    <p class="empty-state-title"><?= t('student.no_reservable') ?></p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($products as $product): ?>
    <?php $free = $stocks[$product['id']] ?? 0; ?>
    <div class="card overflow-hidden flex flex-col <?= $free <= 0 ? 'opacity-70' : '' ?>">

        <div class="relative h-44 overflow-hidden bg-navy-100 flex items-center justify-center text-navy-400">
            <?php if (!empty($product['image_url'])): ?>
            <img src="<?= url($product['image_url']) ?>"
                 alt="<?= e(pname($product)) ?>"
                 class="w-full h-full object-cover">
            <?php else: ?>
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <?php endif; ?>
            <div class="absolute top-2.5 right-2.5">
                <span class="badge <?= $free > 0 ? 'badge-approved' : 'badge-expired' ?>"><?= $free > 0 ? t('student.in_stock') : t('student.out_of_stock') ?></span>
            </div>
        </div>

        <div class="p-4 flex flex-col flex-1">
            <?php if ($product['category']): ?>
            <span class="badge badge-plain badge-gold-soft self-start mb-2"><?= e($product['category']) ?></span>
            <?php endif; ?>
            <h3 class="font-bold text-slate-900 text-sm leading-snug"><?= e(pname($product)) ?></h3>
            <?php if ($product['description']): ?>
            <p class="text-xs text-slate-500 mt-1 line-clamp-2"><?= e($product['description']) ?></p>
            <?php endif; ?>
            <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-200">
                <span class="text-xs text-slate-600">
                    <?= t('student.stock') ?>:
                    <span class="font-bold tabular-nums <?= $free > 0 ? 'text-navy-800' : 'text-slate-500' ?>"><?= $free ?></span>
                </span>
                <span class="text-xs font-bold text-slate-700 tabular-nums"><?= number_format($product['price_snapshot'], 2) ?> ₺</span>
            </div>
            <?php if ($free > 0): ?>
            <a href="<?= url('isletmeler/' . $venue['id'] . '/rezerve') ?>" class="btn btn-primary btn-sm btn-block mt-3">
                <?= t('student.reserve') ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
