<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <h1 class="page-title"><?= t('student.reservations') ?></h1>
        <p class="page-desc"><?= t('student.my_res_sub') ?> · <?= count($reservations) ?></p>
    </div>
    <div class="page-actions">
        <a href="<?= url('isletmeler') ?>" class="btn btn-primary">+ <?= t('student.new_reservation') ?></a>
    </div>
</div>

<?php if (empty($reservations)): ?>
<div class="empty-state card">
    <div class="empty-state-icon">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
    </div>
    <p class="empty-state-title"><?= t('student.no_res') ?></p>
    <a href="<?= url('isletmeler') ?>" class="link text-sm"><?= t('student.browse_venues') ?></a>
</div>
<?php else: ?>
<div class="space-y-3">
    <?php foreach ($reservations as $r): ?>
    <div class="card p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4 min-w-0">
            <div class="w-12 h-12 bg-navy-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="text-navy-800 font-bold text-xs tabular-nums"><?= mb_substr(e($r['claim_code']), 0, 4) ?></span>
            </div>
            <div class="min-w-0">
                <p class="font-bold text-slate-900"><?= e($r['venue_name']) ?></p>
                <p class="text-xs text-slate-500 mt-0.5">
                    <?= t('student.claim_code') ?>: <span class="font-bold tracking-widest tabular-nums text-navy-800"><?= e($r['claim_code']) ?></span>
                </p>
                <p class="text-xs text-slate-500">
                    <?= t('student.created_at') ?>: <?= format_date($r['created_at']) ?>
                </p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <?= status_badge($r['status']) ?>
            <?php if ($r['status'] === 'reserved'): ?>
            <span class="text-xs text-slate-600">
                <?= t('student.expires') ?>: <?= format_date($r['expires_at']) ?>
            </span>
            <a href="<?= url('rezervasyonlarim/' . $r['id'] . '/qr') ?>" class="btn btn-primary btn-sm">
                <?= t('student.show_code') ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
