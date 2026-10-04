<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <h1 class="page-title">Teslimat</h1>
        <p class="page-desc"><?= e($venue['name'] ?? '') ?> — <?= e($venue['campus_name'] ?? '') ?></p>
    </div>
</div>

<div class="va-cashier">
    <!-- Sol kolon: kasa -->
    <div class="va-cashier-main">

        <section class="card card-body va-entry" aria-labelledby="entry-title">
            <div>
                <h2 id="entry-title" class="card-title">Teslim kodunu girin</h2>
                <p class="page-desc">Öğrencinin söylediği 6 haneli kodu yazın ya da QR kodunu barkod okuyucuyla okutun. Barkod okuyucu Enter ile otomatik teslim alır.</p>
            </div>

            <form method="POST" action="<?= url('isletme/teslim') ?>" id="claim-form" class="va-entry-form">
                <?= csrf_field() ?>
                <label for="claim_code" class="sr-only">6 Haneli Teslim Kodu</label>
                <input type="text" name="claim_code" id="claim_code" maxlength="6" minlength="6"
                       inputmode="numeric" pattern="[0-9]*"
                       class="code-input"
                       placeholder="000000" autofocus autocomplete="off">
            </form>

            <div id="lookup-msg" class="hidden text-sm font-medium" role="status"></div>

            <div class="flex flex-wrap gap-2">
                <button type="button" id="clear-btn" class="btn btn-ghost">Temizle</button>
            </div>
        </section>

        <!-- Sonuç alanı -->
        <div id="preview-panel" aria-live="polite">
            <!-- Boş durum -->
            <div id="preview-empty" class="empty-state card">
                <div class="empty-state-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="empty-state-title">Kodu girin</p>
                <p>Ürünler burada görünecek.</p>
            </div>

            <!-- Hata durumu (hidden) -->
            <div id="preview-error" class="hidden flash flash-error" role="alert">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flash-body">
                    <p id="preview-error-msg" class="font-semibold"></p>
                </div>
            </div>

            <!-- Başarılı önizleme (hidden) -->
            <div id="preview-success" class="hidden card va-result-ok">
                <div class="flash flash-success va-result-head">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="flash-body font-bold">Kod geçerli — teslim edilebilir</span>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="stat-label uppercase">Öğrenci</p>
                            <p class="text-lg font-bold text-navy-800" id="preview-student"></p>
                        </div>
                        <div>
                            <p class="stat-label uppercase">Son kullanma</p>
                            <p class="text-lg font-bold text-slate-900" id="preview-expires"></p>
                        </div>
                    </div>

                    <p class="stat-label uppercase mt-5 mb-2">Verilecek Ürünler</p>
                    <div id="preview-items" class="space-y-2"></div>
                    <div id="preview-total-row" class="mt-4 pt-4 border-t border-slate-200 flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-600">Toplam Tutar</span>
                        <span id="preview-total" class="text-lg font-bold text-navy-800"></span>
                    </div>

                    <div class="flex flex-wrap gap-3 mt-6">
                        <button type="submit" form="claim-form" id="submit-btn" disabled
                                class="btn btn-primary btn-lg flex-1">
                            Teslimatı onayla
                        </button>
                        <button type="button" id="cancel-btn" class="btn btn-ghost btn-lg">Vazgeç</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sağ kolon: özet -->
    <aside class="va-cashier-side">
        <section class="card-navy relative overflow-hidden p-6">
            <div class="arch-lines arch-lines-sm" aria-hidden="true"></div>
            <p class="eyebrow eyebrow-light">Bugün</p>
            <div class="grid grid-cols-2 gap-3 mt-4 relative">
                <div>
                    <p class="text-3xl font-bold text-white"><?= e($activeCount) ?></p>
                    <p class="text-sm text-navy-200">Teslim bekleyen</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gold-400"><?= e($freeStock) ?></p>
                    <p class="text-sm text-navy-200">Askıda (serbest stok)</p>
                </div>
            </div>
            <p class="mt-4 text-sm text-navy-200 relative"><?= e($waitingCount) ?> katkı onay bekliyor</p>
        </section>

        <section class="card card-body">
            <h2 class="card-title mb-3">Hızlı bağlantılar</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="<?= url('isletme/rezervasyonlar') ?>" class="link font-semibold">Tüm rezervasyonlar →</a></li>
                <li><a href="<?= url('isletme/bagislar') ?>" class="link font-semibold">Katkılar →</a></li>
                <li><a href="<?= url('isletme/stok') ?>" class="link font-semibold">Stok durumu →</a></li>
            </ul>
        </section>
    </aside>
</div>

<!-- Bekleyen Katkılar -->
<section class="card mb-6">
    <div class="card-header flex items-center justify-between gap-3">
        <h2 class="card-title">Bekleyen Katkılar <?php if ((int)$waitingCount > 0): ?><span class="badge-count"><?= e($waitingCount) ?></span><?php endif; ?></h2>
        <a href="<?= url('isletme/bagislar') ?>" class="link text-sm font-semibold">Tümünü Gör →</a>
    </div>
    <?php if (empty($waitingDonations)): ?>
        <div class="empty-state">
            <p class="empty-state-title">Bekleyen katkı yok</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Katkı Sağlayan</th>
                        <th>Ürünler</th>
                        <th>Tarih</th>
                        <th class="text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($waitingDonations as $d): ?>
                    <tr>
                        <td>
                            <p class="cell-strong"><?= e($d['donor_name']) ?></p>
                            <p class="text-xs text-slate-500"><?= e($d['donor_email']) ?></p>
                        </td>
                        <td class="text-xs text-slate-600 max-w-xs truncate" title="<?= e($d['items_summary'] ?? '') ?>">
                            <?= e($d['items_summary'] ?? '-') ?>
                        </td>
                        <td class="text-xs text-slate-500 whitespace-nowrap"><?= format_date($d['created_at']) ?></td>
                        <td class="text-right">
                            <form method="POST" action="<?= url('isletme/bagislar/' . ($d['id']) . '/onayla') ?>" class="inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-success btn-sm">
                                    Onayla
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<!-- Aktif Rezervasyonlar -->
<section class="card mb-6">
    <div class="card-header flex items-center justify-between gap-3">
        <h2 class="card-title">Aktif Rezervasyonlar</h2>
        <a href="<?= url('isletme/rezervasyonlar') ?>" class="link text-sm font-semibold">Tümünü Gör →</a>
    </div>
    <?php if (empty($activeReservations)): ?>
        <div class="empty-state">
            <p class="empty-state-title">Aktif rezervasyon yok</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Öğrenci</th>
                        <th>Kod</th>
                        <th>Ürünler</th>
                        <th>Son Kullanma</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activeReservations as $r): ?>
                    <tr>
                        <td class="cell-strong"><?= e($r['student_name']) ?></td>
                        <td class="font-mono font-bold text-slate-700"><?= e($r['claim_code']) ?></td>
                        <td class="text-xs text-slate-600 max-w-xs truncate" title="<?= e($r['items_summary'] ?? '') ?>">
                            <?= e($r['items_summary'] ?? '-') ?>
                        </td>
                        <td class="text-xs text-slate-500 whitespace-nowrap"><?= format_date($r['expires_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<!-- Askıda Stok Özeti -->
<section class="card">
    <div class="card-header flex items-center justify-between gap-3">
        <h2 class="card-title">Askıda Stok</h2>
        <a href="<?= url('isletme/stok') ?>" class="link text-sm font-semibold">Stok Yönetimi →</a>
    </div>
    <?php if (empty($stocks)): ?>
        <div class="empty-state">
            <p class="empty-state-title">Stok kaydı yok</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ürün</th>
                        <th>Kategori</th>
                        <th class="text-right">Toplam</th>
                        <th class="text-right">Rezerve</th>
                        <th class="text-right">Serbest</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stocks as $s): ?>
                    <tr>
                        <td class="cell-strong"><?= e($s['product_name']) ?></td>
                        <td class="text-xs text-slate-500"><?= e($s['category'] ?? '-') ?></td>
                        <td class="text-right text-slate-700"><?= e($s['available_quantity']) ?></td>
                        <td class="text-right text-slate-500"><?= e($s['reserved_quantity']) ?></td>
                        <td class="text-right font-bold <?= ($s['free_quantity'] > 0) ? 'text-emerald-700' : 'text-red-600' ?>">
                            <?= e($s['free_quantity']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<script>
const input = document.getElementById('claim_code');
const submitBtn = document.getElementById('submit-btn');
const lookupMsg = document.getElementById('lookup-msg');

const panelEmpty = document.getElementById('preview-empty');
const panelError = document.getElementById('preview-error');
const panelSuccess = document.getElementById('preview-success');

const LOOKUP_URL = <?= json_encode(url('isletme/kod-sorgula')) ?>;
let debounceTimer = null;
let pendingEnterSubmit = false; // barkod okuyucu Enter'ı için bekle

function showPanel(which) {
    panelEmpty.classList.add('hidden');
    panelError.classList.add('hidden');
    panelSuccess.classList.add('hidden');
    if (which === 'empty') panelEmpty.classList.remove('hidden');
    if (which === 'error') panelError.classList.remove('hidden');
    if (which === 'success') panelSuccess.classList.remove('hidden');
}

function resetButton() {
    pendingEnterSubmit = false;
    submitBtn.disabled = true;
}

function enableButton() {
    submitBtn.disabled = false;
    // Barkod okuyucu Enter tuşu daha önce basıldıysa hemen gönder
    if (pendingEnterSubmit) {
        pendingEnterSubmit = false;
        document.getElementById('claim-form').submit();
    }
}

function clearAll() {
    clearTimeout(debounceTimer);
    input.value = '';
    showPanel('empty');
    resetButton();
    input.focus();
}

function formatPrice(num) {
    return '₺' + num.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function formatDate(str) {
    const d = new Date(str.replace(' ', 'T'));
    return d.toLocaleString('tr-TR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}

async function lookupCode(code) {
    if (code.length < 6) {
        showPanel('empty');
        resetButton();
        return;
    }
    try {
        const res = await fetch(`${LOOKUP_URL}?kod=${encodeURIComponent(code)}`, {
            credentials: 'include',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const data = await res.json();

        if (data.found) {
            document.getElementById('preview-student').textContent = data.student_name;
            document.getElementById('preview-expires').textContent = formatDate(data.expires_at);

            const itemsEl = document.getElementById('preview-items');
            itemsEl.innerHTML = '';
            let total = 0;
            data.items.forEach(item => {
                const subtotal = item.price_snapshot * item.quantity;
                total += subtotal;
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between bg-navy-50 rounded-xl px-3 py-2';
                div.innerHTML = `
                    <div class="flex items-center gap-3">
                        <span class="badge-count">${item.quantity}</span>
                        <span class="font-semibold text-slate-900 text-sm">${item.product_name}</span>
                    </div>
                    <span class="text-slate-600 text-sm">${formatPrice(subtotal)}</span>
                `;
                itemsEl.appendChild(div);
            });
            document.getElementById('preview-total').textContent = formatPrice(total);
            showPanel('success');
            enableButton();
        } else {
            document.getElementById('preview-error-msg').textContent = data.message || 'Rezervasyon bulunamadı.';
            showPanel('error');
            resetButton();
        }
    } catch (err) {
        document.getElementById('preview-error-msg').textContent = 'Sunucu hatası: ' + err.message;
        showPanel('error');
        resetButton();
    }
}

input.addEventListener('input', function () {
    const code = this.value.replace(/\D/g, '').slice(0, 6); // sadece rakam, max 6
    this.value = code;
    clearTimeout(debounceTimer);
    resetButton();
    if (code.length === 0) {
        showPanel('empty');
        return;
    }
    // 6 haneye ulaşınca anında sorgula (barkod okuyucu anında 6 karakter yollar)
    const delay = code.length === 6 ? 0 : 400;
    debounceTimer = setTimeout(() => lookupCode(code), delay);
});

// Barkod okuyucu Enter gönderince: lookup bitmişse hemen gönder, yoksa sonuç gelince gönder
input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        if (!submitBtn.disabled) {
            document.getElementById('claim-form').submit();
        } else if (this.value.length === 6) {
            pendingEnterSubmit = true; // lookup devam ediyor, gelince gönder
        }
    }
});

document.getElementById('clear-btn').addEventListener('click', clearAll);
document.getElementById('cancel-btn').addEventListener('click', clearAll);
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
