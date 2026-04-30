<?php require ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <a href="<?= url('isletmeler') ?>" class="text-sm text-[#00A3B4] hover:underline">← <?= t('student.back_venues') ?></a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2"><?= e($venue['name']) ?></h1>
    <p class="text-gray-500 text-sm"><?= e($venue['campus_name']) ?><?= $venue['location'] ? ' · ' . e($venue['location']) : '' ?></p>
</div>

<?php $flashError = flash('error'); ?>
<?php if ($flashError): ?>
<div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm"><?= e($flashError) ?></div>
<?php endif; ?>

<form method="POST" action="<?= url('isletmeler/' . $venue['id'] . '/rezerve') ?>">
    <?= csrf_field() ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="font-semibold text-gray-800 mb-1"><?= t('student.select_products') ?></h2>
        <p class="text-sm text-gray-500 mb-5"><?= t('student.only_in_stock') ?></p>

        <?php if (empty($products)): ?>
        <p class="text-gray-400 text-sm"><?= t('student.no_reservable') ?></p>
        <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($products as $p): ?>
            <?php $free = $stocks[$p['id']] ?? 0; ?>
            <div class="border <?= $free > 0 ? 'border-gray-200 hover:border-[#00A3B4]/40' : 'border-gray-100 bg-gray-50 opacity-60' ?> rounded-xl p-4 transition">
                <?php if (!empty($p['image_url'])): ?>
                <img src="<?= e($p['image_url']) ?>" alt="<?= e(pname($p)) ?>"
                     class="w-full h-36 object-cover rounded-lg mb-3">
                <?php else: ?>
                <div class="w-full h-36 bg-gray-50 border border-gray-100 rounded-lg mb-3 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <?php endif; ?>

                <p class="font-semibold text-gray-800 text-sm"><?= e(pname($p)) ?></p>
                <?php if ($p['description']): ?>
                <p class="text-xs text-gray-400 mt-0.5 line-clamp-1"><?= e($p['description']) ?></p>
                <?php endif; ?>
                <?php if ($p['category']): ?>
                <span class="inline-block mt-1 text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full"><?= e($p['category']) ?></span>
                <?php endif; ?>

                <?php
                $maxShow = max($free, 1);
                $pct = min(100, round($free / max($maxShow, 10) * 100));
                $barColor = $free > 5 ? 'bg-green-400' : ($free > 0 ? 'bg-yellow-400' : 'bg-red-300');
                ?>
                <div class="mt-3">
                    <div class="flex justify-between text-[11px] text-gray-400 mb-1">
                        <span><?= t('student.stock') ?></span>
                        <span class="<?= $free > 0 ? 'text-green-600' : 'text-red-500' ?> font-medium">
                            <?= $free > 0 ? $free . ' ' . t('common.items') : t('student.out_of_stock') ?>
                        </span>
                    </div>
                    <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full <?= $barColor ?> rounded-full transition-all" style="width:<?= $pct ?>%"></div>
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-2">
                    <label class="text-xs text-gray-500"><?= t('student.qty') ?>:</label>
                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                        <button type="button" onclick="changeQty(this,-1)"
                            class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-bold transition">−</button>
                        <input type="number" name="qty[<?= $p['id'] ?>]"
                            value="0" min="0" max="<?= $free ?>"
                            <?= $free <= 0 ? 'disabled' : '' ?>
                            class="w-12 text-center text-sm border-x border-gray-300 py-1 focus:outline-none qty-input"
                            data-price="0">
                        <button type="button" onclick="changeQty(this,1)"
                            class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-bold transition">+</button>
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
    <div class="border border-yellow-300 bg-yellow-50 rounded-lg p-4 mb-6 text-sm text-yellow-800 flex items-start gap-3">
        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p><?= t('student.expire_warn', ['min' => $expireMin]) ?></p>
    </div>

    <button type="submit"
        class="w-full py-3 bg-[#00A3B4] hover:bg-[#007A8A] text-white font-bold rounded-xl transition text-base shadow-md">
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
