<?php include ROOT . '/views/layout/header.php'; ?>
<?php
$isActive = $reservation['status'] === 'reserved';
$endTs    = $isActive ? (int) strtotime($reservation['expires_at']) : 0;
$startTs  = !empty($reservation['created_at']) ? (int) strtotime($reservation['created_at']) : 0;
// created_at MySQL saatinde, expires_at PHP saatinde yazılıyor; saat dilimi farkı başlangıcı bitişin
// ötesine itebilir. Yalnızca ilerleme çubuğu için tam saatlik farkı geri al (geri sayım metni etkilenmez).
for ($__i = 0; $startTs && $endTs && $startTs >= $endTs && $__i < 14; $__i++) {
    $startTs -= 3600;
}
if ($startTs >= $endTs) {
    $startTs = 0;
}
?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="breadcrumb">
            <a href="<?= url('rezervasyonlarim') ?>">← <?= t('student.reservations') ?></a>
        </nav>
        <h1 class="page-title"><?= t('student.res_code_title') ?></h1>
    </div>
    <div class="page-actions"><?= status_badge($reservation['status']) ?></div>
</div>

<div class="max-w-md mx-auto space-y-4">
    <section class="card p-5 sm:p-6 text-center flex flex-col items-center gap-4"
        <?php if ($isActive && $endTs): ?>
            data-countdown
            data-countdown-end="<?= $endTs ?>"
            <?php if ($startTs): ?>data-countdown-start="<?= $startTs ?>"<?php endif; ?>
            data-countdown-now="<?= time() ?>"
            data-countdown-expired-text="<?= e(t('student.expired_title')) ?>"
        <?php endif; ?>>

        <div class="leading-snug">
            <p class="font-bold text-slate-900 text-base"><?= e($reservation['venue_name']) ?></p>
            <?php if (!empty($items)): ?>
                <p class="text-sm text-slate-600 mt-1">
                    <?php foreach ($items as $i => $item): ?>
                        <?= $i > 0 ? ', ' : '' ?><?= e($item['product_name']) ?> × <?= e($item['quantity']) ?>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if ($isActive): ?>
            <div data-countdown-hide-when-expired class="flex flex-col items-center gap-4 w-full">
                <div class="flex flex-col gap-0.5">
                    <span class="stat-label uppercase tracking-wider font-bold text-xs"><?= t('student.claim_code_title') ?></span>
                    <span class="text-4xl sm:text-5xl font-bold text-navy-800 tabular-nums tracking-[0.14em] pl-[0.14em]"><?= e($reservation['claim_code']) ?></span>
                    <span class="text-xs text-slate-500 mt-1"><?= t('student.tell_staff') ?></span>
                </div>

                <?php if (!empty($qrImgUrl)): ?>
                <div class="p-2.5 border border-slate-200 rounded-2xl bg-white">
                    <img src="<?= e($qrImgUrl) ?>" alt="QR Kod" class="w-36 h-36 block">
                </div>
                <?php endif; ?>
            </div>

            <?php if ($endTs): ?>
            <div class="w-full flex flex-col gap-2">
                <div class="flex justify-between items-center text-sm" data-countdown-hide-when-expired>
                    <span class="text-slate-600"><?= t('student.time_left') ?></span>
                    <span class="font-bold text-navy-800 tabular-nums" data-countdown-text><?= e(format_date($reservation['expires_at'])) ?></span>
                </div>
                <div class="progress" data-countdown-hide-when-expired><div class="progress-bar" data-countdown-bar style="width:100%"></div></div>

                <div data-countdown-show-when-expired class="hidden py-2 text-center space-y-2">
                    <span class="badge badge-expired"><?= t('student.expired_title') ?></span>
                    <p class="text-sm text-slate-600"><?= t('student.expired_note') ?></p>
                </div>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="w-full rounded-2xl bg-navy-50 p-4">
                <p class="stat-label mb-1"><?= t('student.claim_code') ?></p>
                <p class="text-3xl font-bold text-navy-800 tabular-nums tracking-[0.2em] pl-[0.2em]"><?= e($reservation['claim_code']) ?></p>
            </div>
        <?php endif; ?>

        <dl class="w-full text-sm space-y-2 text-left border-t border-slate-200 pt-4">
            <div class="flex justify-between gap-3">
                <dt class="text-slate-600"><?= t('student.venue') ?></dt>
                <dd class="font-semibold text-slate-900 text-right"><?= e($reservation['venue_name']) ?></dd>
            </div>
            <?php if ($isActive): ?>
            <div class="flex justify-between gap-3">
                <dt class="text-slate-600"><?= t('student.expires_at') ?></dt>
                <dd class="font-semibold text-navy-800"><?= format_date($reservation['expires_at']) ?></dd>
            </div>
            <?php endif; ?>
            <div class="flex justify-between gap-3">
                <dt class="text-slate-600"><?= t('student.created_at') ?></dt>
                <dd class="text-slate-700"><?= format_date($reservation['created_at']) ?></dd>
            </div>
        </dl>

        <?php if (!empty($items)): ?>
            <div class="w-full border-t border-slate-200 pt-4 text-left">
                <p class="stat-label uppercase tracking-wider font-bold text-xs mb-2"><?= t('student.items_to_collect') ?></p>
                <div class="space-y-1">
                    <?php foreach ($items as $item): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-700"><?= e($item['product_name']) ?> × <?= e($item['quantity']) ?></span>
                            <?php if (auth()['role'] !== 'student'): ?>
                                <span class="text-slate-500 tabular-nums">₺<?= number_format($item['price_snapshot'] * $item['quantity'], 2, ',', '.') ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <?php if ($isActive): ?>
    <section class="card p-5">
        <h2 class="text-base font-bold text-slate-900 mb-3"><?= t('student.how_title') ?></h2>
        <ol class="space-y-2.5 text-sm text-slate-700 leading-relaxed">
            <?php foreach (['how_1', 'how_2', 'how_3'] as $n => $k): ?>
            <li class="flex gap-3 items-start">
                <span class="flex-none w-6 h-6 rounded-full bg-navy-800 text-white text-xs font-bold flex items-center justify-center"><?= $n + 1 ?></span>
                <span><?= t('student.' . $k) ?></span>
            </li>
            <?php endforeach; ?>
        </ol>
        <p class="text-xs text-slate-500 mt-4"><?= t('student.no_qr') ?></p>
    </section>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
