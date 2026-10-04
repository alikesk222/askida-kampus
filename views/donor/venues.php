<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <h1 class="page-title"><?= t('donor.donate_title') ?></h1>
        <p class="page-desc"><?= t('donor.venues_sub') ?></p>
    </div>
</div>

<div class="mb-6">
    <?php $stepperSteps = [t('stepper.venue'), t('stepper.products'), t('stepper.payment'), t('stepper.complete')]; $stepperCurrent = 0; ?>
    <?php include ROOT . '/views/partials/stepper.php'; ?>
</div>

<?php if (empty($venues)): ?>
<div class="empty-state">
    <p><?= t('student.no_venues') ?></p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php foreach ($venues as $venue): ?>
    <div class="card venue-card hover:shadow-lift transition">
        <div class="card-body flex flex-col gap-3 h-full">
            <div>
                <h2 class="font-bold text-slate-900 text-base"><?= e($venue['name']) ?></h2>
                <p class="text-xs text-slate-500 mt-0.5"><?= e($venue['campus_name']) ?></p>
            </div>

            <?php if ($venue['location']): ?>
            <p class="text-xs text-slate-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <?= e($venue['location']) ?>
            </p>
            <?php endif; ?>

            <?php if ($venue['description']): ?>
            <p class="text-xs text-slate-600 line-clamp-2"><?= e($venue['description']) ?></p>
            <?php endif; ?>

            <a href="<?= url('bagis/' . $venue['id']) ?>" class="btn btn-primary btn-block mt-auto">
                <?= t('nav.donate') ?>
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
