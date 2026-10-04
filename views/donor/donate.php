<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <a href="<?= url('bagis') ?>" class="link text-sm">← <?= t('donor.donate_title') ?></a>
        <h1 class="page-title mt-2"><?= e($venue['name']) ?> — <?= t('donor.donate_title') ?></h1>
        <p class="page-desc"><?= e($venue['campus_name']) ?></p>
    </div>
</div>

<div class="mb-6">
    <?php $stepperSteps = [t('stepper.venue'), t('stepper.products'), t('stepper.payment'), t('stepper.complete')]; $stepperCurrent = 1; ?>
    <?php include ROOT . '/views/partials/stepper.php'; ?>
</div>

<?php if (empty($products)): ?>
<div class="empty-state">
    <p><?= t('donor.no_products') ?></p>
</div>
<?php else: ?>
<form method="POST" action="<?= url('bagis/' . $venue['id']) ?>" id="donation-form" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    <?= csrf_field() ?>

    <div class="lg:col-span-2 flex flex-col gap-4 min-w-0">
        <div class="card overflow-hidden">
            <div class="card-header">
                <h2 class="card-title"><?= t('donor.select_products') ?></h2>
                <p class="text-xs text-slate-500 mt-0.5"><?= t('donor.select_sub') ?></p>
            </div>
            <div class="divide-y divide-slate-200">
                <?php foreach ($products as $p): ?>
                <div class="product-row px-5 py-4 flex items-center gap-4 transition-colors" data-price="<?= e($p['price_snapshot']) ?>" data-name="<?= e(pname($p)) ?>">
                    <?php if (!empty($p['image_url'])): ?>
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
                        <?php if ($p['category']): ?>
                        <p class="text-xs text-slate-500"><?= e($p['category']) ?></p>
                        <?php endif; ?>
                        <?php if ($p['description']): ?>
                        <p class="text-xs text-slate-600 mt-0.5"><?= e($p['description']) ?></p>
                        <?php endif; ?>
                        <p class="text-sm text-slate-600 mt-0.5">₺<?= number_format($p['price_snapshot'], 2, ',', '.') ?> <?= t('common.per_unit') ?></p>
                    </div>
                    <div class="qty flex-shrink-0">
                        <button type="button" class="qty-btn" aria-label="<?= t('ui.decrease') ?>" data-qty-dec>−</button>
                        <input type="number" name="qty[<?= e($p['id']) ?>]" value="0" min="0" max="100"
                            data-price="<?= e($p['price_snapshot']) ?>"
                            class="qty-input" aria-label="<?= t('donor.qty_label') ?>">
                        <button type="button" class="qty-btn" aria-label="<?= t('ui.increase') ?>" data-qty-inc>+</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <label class="form-label"><?= t('donor.note_lbl') ?></label>
                <textarea name="notes" rows="2" class="form-textarea"
                    placeholder="<?= t('donor.note_ph') ?>"><?= old('notes') ?></textarea>
            </div>
        </div>
    </div>

    <aside class="flex flex-col gap-4 lg:sticky lg:top-24">
        <div class="card card-elevated">
            <div class="card-body flex flex-col gap-4">
                <h2 class="card-title"><?= t('ui.summary') ?></h2>
                <ul id="summary-lines" class="flex flex-col gap-2 text-sm text-slate-700"></ul>
                <p id="summary-empty" class="text-sm text-slate-500"><?= t('donate.summary_empty') ?></p>
                <div class="border-t border-slate-200 pt-4">
                    <div class="flex items-baseline justify-between">
                        <span class="font-bold text-slate-900"><?= t('ui.total') ?></span>
                        <span id="total-amount" class="text-2xl font-bold text-navy-800">₺0,00</span>
                    </div>
                    <p class="form-help mt-1"><?= t('donor.total_sub') ?></p>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block"><?= t('donor.submit_btn') ?></button>
            </div>
        </div>

        <div class="card">
            <div class="card-body flex flex-col gap-2">
                <h3 class="font-bold text-slate-900 text-sm"><?= t('donor.iban_lbl') ?></h3>
                <p id="iban-text" class="font-mono text-sm font-bold text-slate-900 bg-navy-50 rounded-xl px-3 py-2 break-all"><?= e($iban) ?></p>
                <button type="button" class="btn btn-outline btn-sm btn-block" data-copy-target="#iban-text" data-copied-text="<?= t('ui.copied') ?>">
                    <span data-copy-label><?= t('ui.copy') ?></span>
                </button>
                <p class="form-help"><?= t('donor.iban_after') ?></p>
            </div>
        </div>
    </aside>
</form>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var rows = document.querySelectorAll('.product-row');
    var totalEl = document.getElementById('total-amount');
    var linesEl = document.getElementById('summary-lines');
    var emptyEl = document.getElementById('summary-empty');
    if (!totalEl) return;
    var fmt = function (n) { return '₺' + n.toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}); };

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
});
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
