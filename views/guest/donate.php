<?php
$headTitle = $pageTitle ?? 'Askıda Kampüs';
include ROOT . '/views/layout/public-header.php';
?>

<div class="max-w-6xl mx-auto w-full px-4 sm:px-6 py-10 flex flex-col gap-6">

    <div>
        <span class="eyebrow"><?= t('nav.donate') ?></span>
        <h1 class="page-title"><?= e($venue['name']) ?> — <?= t('nav.donate') ?></h1>
        <p class="page-desc"><?= e($venue['campus_name']) ?><?= $venue['location'] ? ' · ' . e($venue['location']) : '' ?></p>
    </div>

    <?php $stepperSteps = [t('stepper.venue'), t('stepper.products'), t('stepper.payment'), t('stepper.complete')]; $stepperCurrent = 1; ?>
    <?php include ROOT . '/views/partials/stepper.php'; ?>

    <?php $flashError = flash('error'); ?>
    <?php if ($flashError): ?>
    <div class="flash flash-error" role="alert"><div class="flash-body"><?= e($flashError) ?></div></div>
    <?php endif; ?>

    <form method="POST" action="<?= url('misafir-bagis/' . $venue['id']) ?>" id="donation-form" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <?= csrf_field() ?>

        <div class="lg:col-span-2 flex flex-col gap-6 min-w-0">

            <div class="card">
                <div class="card-header"><h2 class="card-title"><?= t('guest.donor_info') ?></h2></div>
                <div class="card-body grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label"><?= t('auth.name') ?> <span class="text-red-600">*</span></label>
                        <input type="text" name="donor_name" value="<?= e($old['donor_name'] ?? '') ?>"
                            class="form-input <?= isset($errors['donor_name']) ? 'is-invalid' : '' ?>"
                            placeholder="<?= t('auth.name_ph') ?>" required>
                        <?= error_msg($errors, 'donor_name') ?>
                    </div>
                    <div>
                        <label class="form-label"><?= t('auth.email') ?> <span class="text-red-600">*</span></label>
                        <input type="email" name="donor_email" value="<?= e($old['donor_email'] ?? '') ?>"
                            class="form-input <?= isset($errors['donor_email']) ? 'is-invalid' : '' ?>"
                            placeholder="<?= t('auth.email_ph') ?>" required>
                        <?= error_msg($errors, 'donor_email') ?>
                    </div>
                </div>
            </div>

            <div class="card overflow-hidden">
                <div class="card-header">
                    <h2 class="card-title"><?= t('guest.products_title') ?></h2>
                    <p class="text-sm text-slate-600 mt-1"><?= t('guest.products_sub') ?></p>
                </div>

                <?php if (empty($products)): ?>
                <p class="card-body text-slate-500 text-sm"><?= t('guest.no_products') ?></p>
                <?php else: ?>
                <div class="divide-y divide-slate-200">
                    <?php foreach ($products as $p): ?>
                    <div class="product-row px-5 py-4 flex items-center gap-4 transition-colors" data-price="<?= e($p['price_snapshot']) ?>" data-name="<?= e(pname($p)) ?>">
                        <?php if ($p['image_url']): ?>
                        <img src="<?= url($p['image_url']) ?>" alt="<?= e(pname($p)) ?>"
                             class="w-14 h-14 object-cover rounded-xl flex-shrink-0">
                        <?php else: ?>
                        <div class="icon-chip flex-shrink-0 w-14 h-14">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <?php endif; ?>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-900"><?= e(pname($p)) ?></p>
                            <?php if ($p['description']): ?>
                            <p class="text-xs text-slate-500 mt-0.5 truncate"><?= e($p['description']) ?></p>
                            <?php endif; ?>
                            <p class="text-sm text-slate-600 mt-0.5"><?= number_format($p['price_snapshot'], 2) ?> ₺ <?= t('common.per_unit') ?></p>
                        </div>
                        <div class="qty flex-shrink-0">
                            <button type="button" class="qty-btn" aria-label="<?= t('ui.decrease') ?>" data-qty-dec>−</button>
                            <input type="number" name="qty[<?= $p['id'] ?>]" value="0" min="0" max="50"
                                class="qty-input" aria-label="<?= t('donor.qty') ?>"
                                data-price="<?= $p['price_snapshot'] ?>">
                            <button type="button" class="qty-btn" aria-label="<?= t('ui.increase') ?>" data-qty-inc>+</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="card">
                <div class="card-body">
                    <label class="form-label"><?= t('guest.note') ?></label>
                    <textarea name="notes" rows="2" class="form-textarea"
                        placeholder="<?= t('guest.note_ph') ?>"></textarea>
                </div>
            </div>

            <a href="<?= url('misafir-bagis') ?>" class="link text-sm font-semibold self-start"><?= t('guest.back') ?></a>
        </div>

        <aside class="flex flex-col gap-4 lg:sticky lg:top-24">
            <div class="card card-elevated">
                <div class="card-body flex flex-col gap-4">
                    <h2 class="card-title"><?= t('ui.summary') ?></h2>
                    <ul id="summary-lines" class="flex flex-col gap-2 text-sm text-slate-700"></ul>
                    <p id="summary-empty" class="text-sm text-slate-500"><?= t('donate.summary_empty') ?></p>
                    <div class="border-t border-slate-200 pt-4 flex items-baseline justify-between">
                        <span class="font-bold text-slate-900"><?= t('ui.total') ?></span>
                        <span id="total-amount" class="text-2xl font-bold text-navy-800">0,00 ₺</span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block"><?= t('guest.submit') ?></button>
                </div>
            </div>

            <div class="card">
                <div class="card-body flex flex-col gap-2">
                    <h3 class="font-bold text-slate-900 text-sm"><?= t('guest.iban_title') ?></h3>
                    <p id="iban-text" class="font-mono bg-navy-50 rounded-xl px-3 py-2 text-slate-900 text-xs tracking-wider break-all"><?= e($iban) ?></p>
                    <button type="button" class="btn btn-outline btn-sm btn-block" data-copy-target="#iban-text" data-copied-text="<?= t('ui.copied') ?>">
                        <span data-copy-label><?= t('ui.copy') ?></span>
                    </button>
                    <p class="form-help"><?= t('guest.iban_desc') ?></p>
                </div>
            </div>
        </aside>
    </form>
</div>

<script>
(function () {
    var rows = document.querySelectorAll('.product-row');
    var totalEl = document.getElementById('total-amount');
    var linesEl = document.getElementById('summary-lines');
    var emptyEl = document.getElementById('summary-empty');
    var fmt = function (n) { return n.toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ₺'; };

    function update() {
        var total = 0;
        linesEl.innerHTML = '';
        rows.forEach(function (row) {
            var inp = row.querySelector('.qty-input');
            var qty = parseInt(inp.value) || 0;
            var price = parseFloat(row.dataset.price) || 0;
            var dec = row.querySelector('[data-qty-dec]');
            if (dec) dec.disabled = qty <= 0;
            row.classList.toggle('bg-navy-50', qty > 0);
            if (qty > 0) {
                total += qty * price;
                var li = document.createElement('li');
                li.className = 'flex justify-between gap-3';
                var a = document.createElement('span');
                a.textContent = row.dataset.name + ' × ' + qty;
                var b = document.createElement('span');
                b.className = 'font-bold text-slate-900';
                b.textContent = fmt(qty * price);
                li.appendChild(a); li.appendChild(b);
                linesEl.appendChild(li);
            }
        });
        emptyEl.classList.toggle('hidden', total > 0);
        totalEl.textContent = fmt(total);
    }

    rows.forEach(function (row) {
        var inp = row.querySelector('.qty-input');
        var step = function (d) {
            var min = parseInt(inp.min) || 0;
            var max = inp.max !== '' ? parseInt(inp.max) : Infinity;
            var v = (parseInt(inp.value) || 0) + d;
            inp.value = Math.max(min, Math.min(max, v));
            update();
        };
        row.querySelector('[data-qty-dec]').addEventListener('click', function () { step(-1); });
        row.querySelector('[data-qty-inc]').addEventListener('click', function () { step(1); });
        inp.addEventListener('input', update);
    });
    update();
})();
</script>
<?php include ROOT . '/views/layout/public-footer.php'; ?>
