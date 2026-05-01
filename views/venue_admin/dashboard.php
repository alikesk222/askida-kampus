<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">İşletme Paneli</h1>
    <p class="text-gray-500 text-sm mt-1"><?= e($venue['name'] ?? '') ?> — <?= e($venue['campus_name'] ?? '') ?></p>
</div>

<!-- KPI Kartlar -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#00A3B4]">
        <p class="text-sm text-gray-500">Serbest Stok</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?= e($freeStock) ?></p>
        <p class="text-xs text-gray-400 mt-1">Rezerve edilebilir ürün</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-400">
        <p class="text-sm text-gray-500">Bekleyen Bağış</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?= e($waitingCount) ?></p>
        <p class="text-xs text-gray-400 mt-1">Onay bekliyor</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-400">
        <p class="text-sm text-gray-500">Aktif Rezervasyon</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?= e($activeCount) ?></p>
        <p class="text-xs text-gray-400 mt-1">Teslim bekleyen</p>
    </div>
</div>

<!-- Teslim Al Widget -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
        <svg class="w-5 h-5 text-[#00A3B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h2 class="font-semibold text-gray-700 text-sm">Teslim Kodu ile Rezervasyon Al</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            <!-- Sol: Kod giriş -->
            <div>
                <form method="POST" action="<?= url('isletme/teslim') ?>" id="claim-form">
                    <?= csrf_field() ?>
                    <label class="block text-sm font-medium text-gray-700 mb-2">8 Haneli Teslim Kodu</label>
                    <input type="text" name="claim_code" id="claim_code" maxlength="8" minlength="8"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl text-center text-2xl font-mono font-bold tracking-[0.4em] uppercase
                                  focus:outline-none focus:border-[#00A3B4] transition mb-3"
                           placeholder="XXXXXXXX" autofocus autocomplete="off">
                    <div id="lookup-msg" class="hidden mb-3 text-sm text-center rounded-lg px-4 py-2 font-medium"></div>
                    <button type="submit" id="submit-btn" disabled
                            class="w-full py-3 bg-gray-300 text-gray-500 font-semibold rounded-xl transition text-base cursor-not-allowed">
                        Teslim Al
                    </button>
                </form>
                <p class="text-center text-xs text-gray-400 mt-3">Kodu girdikçe sağ tarafta ürünler görünecektir.</p>
            </div>

            <!-- Sağ: Önizleme -->
            <div id="preview-panel" class="min-h-[200px]">
                <!-- Boş durum -->
                <div id="preview-empty" class="flex flex-col items-center justify-center text-center h-full py-8">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Kodu girin, ürünler burada görünecek</p>
                </div>
                <!-- Hata durumu (hidden) -->
                <div id="preview-error" class="hidden bg-red-50 border border-red-200 rounded-xl p-5 text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p id="preview-error-msg" class="text-red-600 font-semibold text-sm"></p>
                </div>
                <!-- Başarılı önizleme (hidden) -->
                <div id="preview-success" class="hidden bg-white rounded-xl border-2 border-[#00A3B4] overflow-hidden">
                    <div class="bg-gradient-to-r from-[#003a6e] to-[#00A3B4] px-5 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm" id="preview-student"></p>
                            <p class="text-white/70 text-xs" id="preview-expires"></p>
                        </div>
                    </div>
                    <div class="px-5 py-4">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Verilecek Ürünler</p>
                        <div id="preview-items" class="space-y-2"></div>
                        <div id="preview-total-row" class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-600">Toplam Tutar</span>
                            <span id="preview-total" class="text-base font-black text-[#003a6e]"></span>
                        </div>
                    </div>
                    <div class="px-5 pb-4">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-green-700 text-xs font-medium">Ürünleri kontrol edin ve <strong>"Teslim Al"</strong> butonuna basın.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bekleyen Bağışlar -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
            </svg>
            <h2 class="font-semibold text-gray-700 text-sm">Bekleyen Bağışlar</h2>
        </div>
        <a href="<?= url('isletme/bagislar') ?>" class="text-xs text-[#00A3B4] hover:underline font-medium">Tümünü Gör →</a>
    </div>
    <?php if (empty($waitingDonations)): ?>
        <div class="px-6 py-8 text-center text-gray-400 text-sm">Bekleyen bağış yok.</div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Bağışçı</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Ürünler</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Tarih</th>
                        <th class="px-5 py-3 text-right font-semibold text-gray-600">İşlem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($waitingDonations as $d): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-800"><?= e($d['donor_name']) ?></p>
                            <p class="text-xs text-gray-400"><?= e($d['donor_email']) ?></p>
                        </td>
                        <td class="px-5 py-3 text-gray-600 text-xs max-w-xs truncate" title="<?= e($d['items_summary'] ?? '') ?>">
                            <?= e($d['items_summary'] ?? '-') ?>
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-500 whitespace-nowrap"><?= format_date($d['created_at']) ?></td>
                        <td class="px-5 py-3 text-right">
                            <form method="POST" action="<?= url('isletme/bagislar/' . ($d['id']) . '/onayla') ?>" class="inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition">
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
</div>

<!-- Aktif Rezervasyonlar -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <h2 class="font-semibold text-gray-700 text-sm">Aktif Rezervasyonlar</h2>
        </div>
        <a href="<?= url('isletme/rezervasyonlar') ?>" class="text-xs text-[#00A3B4] hover:underline font-medium">Tümünü Gör →</a>
    </div>
    <?php if (empty($activeReservations)): ?>
        <div class="px-6 py-8 text-center text-gray-400 text-sm">Aktif rezervasyon yok.</div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Öğrenci</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Kod</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Ürünler</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Son Kullanma</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($activeReservations as $r): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-800"><?= e($r['student_name']) ?></td>
                        <td class="px-5 py-3 font-mono font-bold text-gray-700"><?= e($r['claim_code']) ?></td>
                        <td class="px-5 py-3 text-gray-600 text-xs max-w-xs truncate" title="<?= e($r['items_summary'] ?? '') ?>">
                            <?= e($r['items_summary'] ?? '-') ?>
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-500 whitespace-nowrap"><?= format_date($r['expires_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Askıda Stok Özeti -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-[#00A3B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <h2 class="font-semibold text-gray-700 text-sm">Askıda Stok</h2>
        </div>
        <a href="<?= url('isletme/stok') ?>" class="text-xs text-[#00A3B4] hover:underline font-medium">Stok Yönetimi →</a>
    </div>
    <?php if (empty($stocks)): ?>
        <div class="px-6 py-8 text-center text-gray-400 text-sm">Stok kaydı yok.</div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Ürün</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Kategori</th>
                        <th class="px-5 py-3 text-right font-semibold text-gray-600">Toplam</th>
                        <th class="px-5 py-3 text-right font-semibold text-gray-600">Rezerve</th>
                        <th class="px-5 py-3 text-right font-semibold text-gray-600">Serbest</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($stocks as $s): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-800"><?= e($s['product_name']) ?></td>
                        <td class="px-5 py-3 text-xs text-gray-500"><?= e($s['category'] ?? '-') ?></td>
                        <td class="px-5 py-3 text-right text-gray-700"><?= e($s['available_quantity']) ?></td>
                        <td class="px-5 py-3 text-right text-gray-500"><?= e($s['reserved_quantity']) ?></td>
                        <td class="px-5 py-3 text-right font-bold <?= ($s['free_quantity'] > 0) ? 'text-green-600' : 'text-red-500' ?>">
                            <?= e($s['free_quantity']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
const input = document.getElementById('claim_code');
const submitBtn = document.getElementById('submit-btn');
const lookupMsg = document.getElementById('lookup-msg');

const panelEmpty = document.getElementById('preview-empty');
const panelError = document.getElementById('preview-error');
const panelSuccess = document.getElementById('preview-success');

const LOOKUP_URL = <?= json_encode(url('isletme/kod-sorgula')) ?>;
let debounceTimer = null;

function showPanel(which) {
    panelEmpty.classList.add('hidden');
    panelError.classList.add('hidden');
    panelSuccess.classList.add('hidden');
    if (which === 'empty') panelEmpty.classList.remove('hidden');
    if (which === 'error') panelError.classList.remove('hidden');
    if (which === 'success') panelSuccess.classList.remove('hidden');
}

function resetButton() {
    submitBtn.disabled = true;
    submitBtn.className = 'w-full py-3 bg-gray-300 text-gray-500 font-semibold rounded-xl transition text-base cursor-not-allowed';
    submitBtn.style.pointerEvents = 'none';
}

function enableButton() {
    submitBtn.disabled = false;
    submitBtn.className = 'w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition text-base shadow-lg';
    submitBtn.style.pointerEvents = '';
}

function formatPrice(num) {
    return '₺' + num.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function formatDate(str) {
    const d = new Date(str.replace(' ', 'T'));
    return d.toLocaleString('tr-TR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}

async function lookupCode(code) {
    if (code.length < 4) {
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
            document.getElementById('preview-expires').textContent = 'Son kullanma: ' + formatDate(data.expires_at);

            const itemsEl = document.getElementById('preview-items');
            itemsEl.innerHTML = '';
            let total = 0;
            data.items.forEach(item => {
                const subtotal = item.price_snapshot * item.quantity;
                total += subtotal;
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between bg-gray-50 rounded-lg px-3 py-2';
                div.innerHTML = `
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 bg-[#003a6e] text-white rounded flex items-center justify-center text-xs font-bold">${item.quantity}</span>
                        <span class="font-medium text-gray-800 text-xs">${item.product_name}</span>
                    </div>
                    <span class="text-gray-500 text-xs">${formatPrice(subtotal)}</span>
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
    const code = this.value.trim().toUpperCase();
    this.value = code;
    clearTimeout(debounceTimer);
    resetButton();
    if (code.length === 0) {
        showPanel('empty');
        return;
    }
    const delay = code.length >= 4 ? 300 : 600;
    debounceTimer = setTimeout(() => lookupCode(code), delay);
});
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
