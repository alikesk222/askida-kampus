<?php
$headTitle = t('guest.thanks_title');
include ROOT . '/views/layout/public-header.php';
?>

<div class="max-w-2xl mx-auto w-full px-4 sm:px-6 py-10 flex flex-col gap-6">

    <?php $stepperSteps = [t('stepper.venue'), t('stepper.products'), t('stepper.payment'), t('stepper.complete')]; $stepperCurrent = 4; ?>
    <?php include ROOT . '/views/partials/stepper.php'; ?>

    <div class="card card-elevated">
        <div class="card-body flex flex-col items-center text-center gap-4 py-8">
            <div class="w-20 h-20 rounded-full bg-navy-800 text-gold-500 flex items-center justify-center">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="page-title"><?= t('guest.thanks_title') ?></h1>
            <p class="text-slate-600 text-sm"><?= t('guest.thanks_id') ?> <span class="font-bold text-slate-900">#<?= e($donationId) ?></span></p>

            <div class="w-full bg-navy-50 rounded-2xl p-5 text-left">
                <p class="text-sm text-slate-900 font-bold mb-3"><?= t('guest.thanks_iban') ?></p>
                <p id="iban-text" class="font-mono text-sm bg-white rounded-xl px-3 py-2 text-slate-900 tracking-wider break-all"><?= e($iban) ?></p>
                <button type="button" class="btn btn-outline btn-sm mt-3 w-full sm:w-auto" data-copy-target="#iban-text" data-copied-text="<?= t('ui.copied') ?>">
                    <span data-copy-label><?= t('ui.copy') ?></span>
                </button>
                <p class="text-sm text-slate-700 mt-3">
                    <?= t('guest.thanks_total') ?> <span class="font-bold text-navy-800"><?= number_format($totalAmount, 2) ?> ₺</span>
                </p>
                <p class="text-xs text-slate-600 mt-2">
                    <?= t('guest.thanks_desc', ['id' => $donationId]) ?>
                </p>
            </div>

            <div class="w-full text-left">
                <h2 class="card-title mb-3"><?= t('donate.next_title') ?></h2>
                <ol class="flex flex-col gap-3">
                    <?php foreach (['donate.next_1', 'donate.next_2', 'donate.next_3'] as $i => $k): ?>
                    <li class="flex items-start gap-3 text-sm text-slate-700">
                        <span class="flex-shrink-0 w-7 h-7 rounded-full bg-navy-800 text-white text-xs font-bold flex items-center justify-center"><?= $i + 1 ?></span>
                        <span class="pt-1"><?= t($k) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ol>
            </div>

            <div class="w-full border-t border-slate-200 pt-6 flex flex-col sm:flex-row gap-3">
                <a href="<?= url('misafir-bagis') ?>" class="btn btn-primary btn-block"><?= t('guest.donate_again') ?></a>
                <a href="<?= url('bagisci-kayit') ?>" class="btn btn-outline btn-block"><?= t('guest.track') ?></a>
            </div>
            <a href="<?= url() ?>" class="link text-sm"><?= t('guest.back_home') ?></a>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
