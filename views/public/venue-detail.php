<?php
$activePage = '';
include ROOT . '/views/layout/public-header.php';
?>

<!-- İşletme başlığı -->
<div class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-6xl px-6 py-8">
        <nav class="breadcrumb mb-5" aria-label="breadcrumb">
            <a href="<?= url('/') ?>"><?= t('nav.home') ?></a>
            <span class="mx-2 text-slate-400" aria-hidden="true">›</span>
            <span class="text-slate-700"><?= e($venue['name']) ?></span>
        </nav>

        <div class="flex items-start gap-5">
            <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-navy-800 text-2xl font-bold text-white">
                <?= mb_strtoupper(mb_substr(e($venue['name']), 0, 1)) ?>
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl"><?= e($venue['name']) ?></h1>
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
                    <span class="badge <?= $isOpen ? 'badge-approved' : 'badge-muted' ?>"><?= $isOpen ? t('venue.open') : t('venue.closed') ?></span>
                </div>
                <p class="mt-1 text-sm text-slate-600"><?= e($venue['campus_name']) ?></p>
                <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-slate-600">
                    <?php if ($venue['location']): ?>
                    <span class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <?= e($venue['location']) ?>
                    </span>
                    <?php endif; ?>
                    <?php if ($venue['opens_at'] && $venue['closes_at']): ?>
                    <span class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <?= e(substr($venue['opens_at'], 0, 5)) ?> – <?= e(substr($venue['closes_at'], 0, 5)) ?>
                    </span>
                    <?php endif; ?>
                    <span class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <?= count($products) ?> <?= t('common.items') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mx-auto max-w-6xl px-6 py-10">

    <div class="mb-5 flex items-center justify-between">
        <h2 class="text-lg font-bold text-slate-900"><?= t('venue.avail_products') ?></h2>
        <span class="text-sm text-slate-500"><?= count($products) ?> <?= t('common.items') ?></span>
    </div>

    <?php if (empty($products)): ?>
    <div class="empty-state">
        <span class="empty-state-icon" aria-hidden="true">
            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </span>
        <p><?= t('venue.no_products') ?></p>
    </div>
    <?php else: ?>
    <div class="mb-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($products as $p): ?>
        <?php $free = $stocks[$p['id']] ?? 0; ?>
        <div class="card venue-product <?= $free <= 0 ? 'opacity-60' : '' ?>">

            <div class="relative h-44 overflow-hidden bg-navy-50">
                <?php if (!empty($p['image_url'])): ?>
                <img src="<?= url($p['image_url']) ?>" alt="<?= e(pname($p)) ?>" class="h-full w-full object-cover">
                <?php else: ?>
                <div class="flex h-full w-full items-center justify-center">
                    <svg class="h-12 w-12 text-navy-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <?php endif; ?>
                <div class="absolute right-3 top-3">
                    <?php if ($free > 0): ?>
                    <span class="badge badge-approved"><?= t('venue.in_stock') ?></span>
                    <?php else: ?>
                    <span class="badge badge-muted"><?= t('venue.out_of_stock') ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="p-5">
                <?php if ($p['category']): ?>
                <span class="badge badge-plain badge-gold-soft mb-2"><?= e($p['category']) ?></span>
                <?php endif; ?>
                <h3 class="text-[15px] font-bold leading-snug text-slate-900"><?= e(pname($p)) ?></h3>
                <?php if ($p['description']): ?>
                <p class="mt-1 line-clamp-2 text-sm text-slate-600"><?= e($p['description']) ?></p>
                <?php endif; ?>
                <div class="mt-3 flex items-center justify-between border-t border-slate-100 pt-3">
                    <span class="text-sm text-slate-600"><?= t('student.stock') ?>:
                        <span class="font-bold <?= $free > 0 ? 'text-navy-800' : 'text-slate-500' ?>"><?= $free ?></span>
                    </span>
                    <span class="text-sm font-semibold text-slate-700"><?= number_format($p['price_snapshot'], 2) ?> ₺</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- CTA -->
    <div class="on-dark relative flex flex-col items-center justify-between gap-5 overflow-hidden rounded-3xl bg-navy-800 p-6 sm:flex-row sm:p-9">
        <div class="arch-lines arch-lines-sm" aria-hidden="true"></div>
        <div class="relative text-center sm:text-left">
            <p class="text-lg font-bold text-white"><?= t('venue.cta_title') ?></p>
            <p class="mt-1 text-sm text-navy-200"><?= t('venue.cta_desc') ?></p>
        </div>
        <div class="relative flex flex-shrink-0 flex-wrap items-center justify-center gap-3">
            <a href="<?= url('misafir-bagis/' . $venue['id']) ?>" class="btn btn-gold"><?= t('nav.donate') ?></a>
            <a href="<?= url('giris') ?>" class="btn btn-outline-light"><?= t('nav.login') ?></a>
        </div>
    </div>

</div>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
