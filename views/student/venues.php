<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <h1 class="page-title"><?= t('student.venues_title') ?></h1>
        <p class="page-desc"><?= t('student.venues_sub') ?></p>
    </div>
</div>

<?php if (empty($venues)): ?>
<div class="empty-state card">
    <div class="empty-state-icon">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 21V10a9 9 0 0 1 18 0v11M7 21v-9a5 5 0 0 1 10 0v9"/></svg>
    </div>
    <p class="empty-state-title"><?= t('student.no_venues') ?></p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php foreach ($venues as $venue): ?>
    <?php
    $isOpen = true;
    if ($venue['opens_at'] && $venue['closes_at']) {
        $cur    = date('H:i:s');
        $isOpen = ($cur >= $venue['opens_at'] && $cur <= $venue['closes_at']);
    }
    ?>
    <a href="<?= url('isletmeler/' . $venue['id']) ?>"
       class="card block overflow-hidden transition hover:shadow-lift hover:-translate-y-0.5 focus-visible:outline-none focus-visible:shadow-focus">
        <div class="h-28 bg-navy-100 text-navy-400 flex items-center justify-center">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 21V10a9 9 0 0 1 18 0v11M7 21v-9a5 5 0 0 1 10 0v9"/></svg>
        </div>
        <div class="p-5">
            <div class="flex items-start justify-between gap-3 mb-3">
                <div class="min-w-0">
                    <h2 class="font-bold text-slate-900 text-base leading-snug"><?= e($venue['name']) ?></h2>
                    <p class="text-xs text-slate-500 mt-0.5"><?= e($venue['campus_name']) ?></p>
                </div>
                <span class="badge <?= $isOpen ? 'badge-approved' : 'badge-expired' ?>"><?= $isOpen ? t('student.open') : t('student.closed') ?></span>
            </div>

            <?php if ($venue['location']): ?>
            <p class="text-xs text-slate-600 flex items-center gap-1.5 mb-2">
                <svg class="w-3.5 h-3.5 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <?= e($venue['location']) ?>
            </p>
            <?php endif; ?>

            <?php if ($venue['opens_at'] && $venue['closes_at']): ?>
            <p class="text-xs text-slate-600 flex items-center gap-1.5 mb-2">
                <svg class="w-3.5 h-3.5 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?= e(substr($venue['opens_at'], 0, 5)) ?> – <?= e(substr($venue['closes_at'], 0, 5)) ?>
            </p>
            <?php endif; ?>

            <div class="flex items-center justify-between gap-2 mt-4">
                <?php if (isset($venue['product_count'])): ?>
                <span class="badge badge-gold-soft"><?= t('student.suspended_items', ['n' => (int)$venue['product_count']]) ?></span>
                <?php else: ?>
                <span></span>
                <?php endif; ?>
                <span class="text-sm font-semibold text-navy-800"><?= t('student.detail') ?> →</span>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
