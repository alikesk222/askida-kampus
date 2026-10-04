<?php
$headTitle = $pageTitle ?? 'Askıda Kampüs';
include ROOT . '/views/layout/public-header.php';
?>

<div class="max-w-6xl mx-auto w-full px-4 sm:px-6 py-10 flex flex-col gap-6">
    <div>
        <span class="eyebrow"><?= t('nav.donate') ?></span>
        <h1 class="page-title"><?= t('guest.title') ?></h1>
        <p class="page-desc"><?= t('guest.sub') ?></p>
    </div>

    <?php $stepperSteps = [t('stepper.venue'), t('stepper.products'), t('stepper.payment'), t('stepper.complete')]; $stepperCurrent = 0; ?>
    <?php include ROOT . '/views/partials/stepper.php'; ?>

    <div class="card flex items-start gap-3 p-4 bg-gold-50">
        <svg class="w-5 h-5 text-navy-800 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-slate-900"><?= t('guest.account_tip') ?></p>
            <p class="text-sm text-slate-600 mt-0.5"><?= t('guest.account_tip_desc') ?>
                <a href="<?= url('bagisci-kayit') ?>" class="link font-semibold"><?= t('guest.create_free') ?></a>.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($venues as $v): ?>
        <a href="<?= url('misafir-bagis/' . $v['id']) ?>" class="card venue-card p-5 flex flex-col gap-3 hover:shadow-lift transition">
            <div class="flex items-center gap-3">
                <div class="icon-chip icon-chip-dark flex-shrink-0 font-bold">
                    <?= mb_strtoupper(mb_substr(e($v['name']), 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-slate-900 text-base"><?= e($v['name']) ?></p>
                    <p class="text-xs text-slate-500"><?= e($v['campus_name']) ?></p>
                </div>
            </div>
            <div class="flex flex-col gap-0.5">
                <?php if ($v['location']): ?>
                <p class="text-xs text-slate-600 truncate"><?= e($v['location']) ?></p>
                <?php endif; ?>
                <?php if ($v['opens_at'] && $v['closes_at']): ?>
                <p class="text-xs text-slate-500"><?= e($v['opens_at']) ?> – <?= e($v['closes_at']) ?></p>
                <?php endif; ?>
            </div>
            <span class="btn btn-primary btn-block mt-auto"><?= t('guest.donate_cta') ?></span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
