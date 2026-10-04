<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <h1 class="page-title"><?= t('donor.my_donations') ?></h1>
        <p class="page-desc"><?= count($donations) ?> <?= t('common.donations') ?></p>
    </div>
    <div class="page-actions">
        <a href="<?= url('bagis') ?>" class="btn btn-primary">+ <?= t('donor.new') ?></a>
    </div>
</div>

<?php if (empty($donations)): ?>
<div class="empty-state">
    <div class="empty-state-icon">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <p class="empty-state-title"><?= t('donor.no_donations') ?></p>
    <a href="<?= url('bagis') ?>" class="link text-sm">
        <?= t('donor.donate_link') ?>
    </a>
</div>
<?php else: ?>
<div class="flex flex-col gap-3">
    <?php foreach ($donations as $d): ?>
    <div class="card p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="icon-chip flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-slate-900"><?= e($d['venue_name']) ?></p>
                <p class="text-xs text-slate-500 mt-0.5"><?= format_date($d['created_at']) ?></p>
                <?php if ($d['notes']): ?>
                <p class="text-xs text-slate-600 mt-0.5 italic"><?= e($d['notes']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="flex items-center justify-between sm:justify-end gap-4">
            <div class="sm:text-right">
                <p class="font-bold text-lg text-slate-900">₺<?= number_format($d['total_amount'], 2, ',', '.') ?></p>
                <?php if ($d['approved_at']): ?>
                <p class="text-xs text-slate-500"><?= t('donor.approved') ?> <?= format_date($d['approved_at'], 'd.m.Y') ?></p>
                <?php endif; ?>
            </div>
            <?= status_badge($d['status']) ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
