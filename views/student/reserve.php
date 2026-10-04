<?php require ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="breadcrumb">
            <a href="<?= url('isletmeler') ?>">← <?= t('student.back_venues') ?></a>
        </nav>
        <h1 class="page-title"><?= e($venue['name']) ?></h1>
        <p class="page-desc"><?= e($venue['campus_name']) ?><?= $venue['location'] ? ' · ' . e($venue['location']) : '' ?></p>
    </div>
</div>

<?php $flashError = flash('error'); ?>
<?php if ($flashError): ?>
<div class="flash flash-error mb-4" role="alert" data-flash>
    <div class="flash-body"><?= e($flashError) ?></div>
</div>
<?php endif; ?>

<!-- Haftalık kota göstergesi -->
<?php
$pct = $weeklyLimit > 0 ? round($weeklyUsed / $weeklyLimit * 100) : 100;
$quotaCls = $weeklyRemaining > 1 ? 'flash-success' : ($weeklyRemaining === 1 ? 'flash-warning' : 'flash-error');
?>
<div class="flash <?= $quotaCls ?> mb-5 !block">
    <div class="flex items-center justify-between gap-3 mb-2">
        <span class="text-sm font-bold">Haftalık Ürün Hakkı</span>
        <span class="text-sm font-bold tabular-nums"><?= $weeklyUsed ?> / <?= $weeklyLimit ?> ürün kullanıldı</span>
    </div>
    <div class="progress">
        <div class="progress-bar" style="width:<?= min(100, $pct) ?>%"></div>
    </div>
    <p class="text-xs mt-2">
        <?php if ($weeklyRemaining === 0): ?>
            Bu haftaki ürün limitinize ulaştınız. Limit her Pazartesi sıfırlanır.
        <?php elseif ($weeklyRemaining === 1): ?>
            Bu hafta yalnızca 1 ürün hakkınız kaldı.
        <?php else: ?>
            Bu hafta <?= $weeklyRemaining ?> ürün hakkınız kaldı.
        <?php endif; ?>
    </p>
</div>

<form method="POST" action="<?= url('isletmeler/' . $venue['id'] . '/rezerve') ?>">
    <?= csrf_field() ?>

    <div class="card p-5 sm:p-6 mb-6">
        <h2 class="card-title mb-1"><?= t('student.select_products') ?></h2>
        <p class="text-sm text-slate-600 mb-5"><?= t('student.only_in_stock') ?></p>

        <?php if (empty($products)): ?>
        <p class="text-slate-500 text-sm"><?= t('student.no_reservable') ?></p>
        <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($products as $p): ?>
            <?php $free = $stocks[$p['id']] ?? 0; ?>
            <div class="border rounded-2xl p-4 transition <?= $free > 0 ? 'border-slate-200 hover:border-navy-400' : 'border-slate-200 bg-slate-50 opacity-70' ?>">
                <?php if (!empty($p['image_url'])): ?>
                <img src="<?= url($p['image_url']) ?>" alt="<?= e(pname($p)) ?>"
                     class="w-full h-36 object-cover rounded-xl mb-3">
                <?php else: ?>
                <div class="w-full h-36 bg-navy-100 text-navy-400 rounded-xl mb-3 flex items-center justify-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <?php endif; ?>

                <p class="font-bold text-slate-900 text-sm"><?= e(pname($p)) ?></p>
                <?php if ($p['description']): ?>
                <p class="text-xs text-slate-500 mt-0.5 line-clamp-1"><?= e($p['description']) ?></p>
                <?php endif; ?>
                <?php if ($p['category']): ?>
                <span class="badge badge-plain badge-gold-soft mt-1.5"><?= e($p['category']) ?></span>
                <?php endif; ?>

                <?php
                $maxShow = max($free, 1);
                $pct = min(100, round($free / max($maxShow, 10) * 100));
                ?>
                <div class="mt-3">
                    <div class="flex justify-between text-[11px] text-slate-500 mb-1">
                        <span><?= t('student.stock') ?></span>
                        <span class="font-semibold <?= $free > 0 ? 'text-navy-800' : 'text-slate-500' ?>">
                            <?= $free > 0 ? "{$free} " . t('common.items') : t('student.out_of_stock') ?>
                        </span>
                    </div>
                    <div class="progress !h-1.5">
                        <div class="progress-bar" style="width:<?= $pct ?>%"></div>
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-2">
                    <span class="text-xs text-slate-600"><?= t('student.qty') ?>:</span>
                    <div class="qty">
                        <button type="button" onclick="changeQty(this,-1)" class="qty-btn" aria-label="<?= e(t('ui.decrease')) ?>">−</button>
                        <input type="number" name="qty[<?= $p['id'] ?>]"
                            value="0" min="0" max="<?= $free ?>"
                            <?= $free <= 0 ? 'disabled' : '' ?>
                            class="qty-input"
                            data-price="0">
                        <button type="button" onclick="changeQty(this,1)" class="qty-btn" aria-label="<?= e(t('ui.increase')) ?>">+</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <?php
    $appCfg = require ROOT . '/src/config/app.php';
    $expireMin = $appCfg['reservation_expire_min'] ?? 30;
    ?>
    <div class="flash flash-info mb-6">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="flash-body text-sm"><?= t('student.expire_warn', ['min' => $expireMin]) ?></p>
    </div>

    <button type="submit" class="btn btn-primary btn-lg btn-block">
        <?= t('student.create_res') ?>
    </button>
</form>

<script>
function changeQty(btn, delta) {
    const input = btn.parentElement.querySelector('input[type=number]');
    const max = parseInt(input.max) || 0;
    let val = (parseInt(input.value) || 0) + delta;
    input.value = Math.max(0, Math.min(max, val));
}
</script>

<?php require ROOT . '/views/layout/footer.php'; ?>
