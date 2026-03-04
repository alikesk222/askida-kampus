<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Teslim Al</h1>
    <p class="text-gray-500 text-sm mt-1"><?= e($venue['name'] ?? 'İşletme atanmadı') ?></p>
</div>

<?php if (!$venue): ?>
    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-5 mb-6">
        <strong>Uyarı:</strong> Henüz bir işletmeye atanmamışsınız. Yöneticinizle iletişime geçin.
    </div>
<?php else: ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

        <!-- SOL: Kod Giriş Kartı -->
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <div class="flex items-center justify-center mb-6">
                <div id="icon-wrap"
                    class="w-16 h-16 bg-[#E0F7FA] rounded-full flex items-center justify-center transition-all duration-300">
                    <!-- default icon -->
                    <svg id="icon-default" class="w-8 h-8 text-[#00A3B4]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <!-- loading spinner (hidden) -->
                    <svg id="icon-loading" class="w-8 h-8 text-[#00A3B4] animate-spin hidden" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-center text-lg font-semibold text-gray-700 mb-6">
                Teslim Kodunu Girin
            </h2>

            <form method="POST" action="<?= url('isletme/teslim') ?>" id="claim-form">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">8 Haneli Teslim Kodu</label>
                    <input type="text" name="claim_code" id="claim_code" maxlength="8" minlength="8" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl text-center text-2xl font-mono font-bold tracking-[0.4em] uppercase
                           focus:outline-none focus:border-[#00A3B4] transition" placeholder="XXXXXXXX" autofocus
                        autocomplete="off">
                    <?= error_msg($errors, 'claim_code') ?>
                </div>

                <!-- İpucu mesajı -->
                <div id="lookup-msg" class="hidden mb-4 text-sm text-center rounded-lg px-4 py-2 font-medium"></div>

                <button type="submit" id="submit-btn" disabled
                    class="w-full py-3 bg-gray-300 text-gray-500 font-semibold rounded-xl transition text-base cursor-not-allowed"
                    style="pointer-events:none">
                    Teslim Al
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-4">
                Öğrenci kodu söyledikçe sağ tarafta ürünler görünür.
            </p>
        </div>

        <!-- SAĞ: Rezervasyon / Ürün Önizleme -->
        <div id="preview-panel">
            <!-- Boş durum -->
            <div id="preview-empty"
                class="bg-white rounded-2xl shadow-sm p-8 flex flex-col items-center justify-center text-center min-h-[280px]">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <p class="text-gray-400 text-sm font-medium">Kodu girin, ürünler burada görünecek</p>
            </div>

            <!-- Hata durumu (hidden) -->
            <div id="preview-error"
                class="hidden bg-red-50 border border-red-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center min-h-[280px]">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p id="preview-error-msg" class="text-red-600 font-semibold text-base"></p>
            </div>

            <!-- Başarılı önizleme (hidden) -->
            <div id="preview-success"
                class="hidden bg-white rounded-2xl shadow-sm overflow-hidden border-2 border-[#00A3B4]">
                <!-- Başlık -->
                <div class="bg-gradient-to-r from-[#003a6e] to-[#00A3B4] px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-base" id="preview-student"></p>
                            <p class="text-white/70 text-xs" id="preview-expires"></p>
                        </div>
                    </div>
                </div>

                <!-- Ürünler -->
                <div class="px-6 py-5">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Verilecek Ürünler</p>
                    <div id="preview-items" class="space-y-3"></div>

                    <!-- Toplam -->
                    <div id="preview-total-row"
                        class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-600">Toplam Tutar</span>
                        <span id="preview-total" class="text-lg font-black text-[#003a6e]"></span>
                    </div>
                </div>

                <!-- Onay notu -->
                <div class="px-6 pb-5">
                    <div class="bg-green-50 border border-green-200 rounded-xl p-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-green-700 text-xs font-medium">Ürünleri teslim et ve sol taraftaki <strong>"Teslim
                                Al"</strong> butonuna bas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const input = document.getElementById('claim_code');
        const submitBtn = document.getElementById('submit-btn');
        const lookupMsg = document.getElementById('lookup-msg');
        const iconDefault = document.getElementById('icon-default');
        const iconLoading = document.getElementById('icon-loading');
        const iconWrap = document.getElementById('icon-wrap');

        const panelEmpty = document.getElementById('preview-empty');
        const panelError = document.getElementById('preview-error');
        const panelSuccess = document.getElementById('preview-success');

        // PHP BASE_URL'yi JS'e göm (subdirectory kurulumlarında doğru çalışır)
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

        function setLoading(on) {
            iconDefault.classList.toggle('hidden', on);
            iconLoading.classList.toggle('hidden', !on);
            iconWrap.classList.toggle('bg-[#E0F7FA]', !on);
            iconWrap.classList.toggle('bg-gray-100', on);
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
            if (code.length < 8) {
                showPanel('empty');
                resetButton();
                setLoading(false);
                return;
            }

            setLoading(true);
            showPanel('empty');

            try {
                const res = await fetch(`${LOOKUP_URL}?kod=${encodeURIComponent(code)}`, {
                    credentials: 'include',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!res.ok) {
                    throw new Error('HTTP ' + res.status + ' — ' + res.statusText);
                }
                const data = await res.json();

                setLoading(false);

                if (data.found) {
                    // Öğrenci adı
                    document.getElementById('preview-student').textContent = '👤 ' + data.student_name;
                    document.getElementById('preview-expires').textContent = 'Son kullanma: ' + formatDate(data.expires_at);

                    // Ürünler
                    const itemsEl = document.getElementById('preview-items');
                    itemsEl.innerHTML = '';
                    let total = 0;
                    data.items.forEach(item => {
                        const subtotal = item.price_snapshot * item.quantity;
                        total += subtotal;
                        const div = document.createElement('div');
                        div.className = 'flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3';
                        div.innerHTML = `
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 bg-[#003a6e] text-white rounded-lg flex items-center justify-center text-sm font-bold flex-shrink-0">${item.quantity}</span>
                        <span class="font-semibold text-gray-800 text-sm">${item.product_name}</span>
                    </div>
                    <span class="text-gray-500 text-sm font-medium">${formatPrice(subtotal)}</span>
                `;
                        itemsEl.appendChild(div);
                    });

                    document.getElementById('preview-total').textContent = formatPrice(total);

                    showPanel('success');
                    enableButton();

                    // İkon yeşil yap
                    iconWrap.className = 'w-16 h-16 bg-green-100 rounded-full flex items-center justify-center transition-all duration-300';
                    iconDefault.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>`;
                    iconDefault.classList.remove('hidden');
                    iconDefault.className = 'w-8 h-8 text-green-600';

                } else {
                    // Hata mesajı
                    document.getElementById('preview-error-msg').textContent = data.message || 'Rezervasyon bulunamadı.';
                    showPanel('error');
                    resetButton();

                    iconWrap.className = 'w-16 h-16 bg-red-100 rounded-full flex items-center justify-center transition-all duration-300';
                    iconDefault.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>`;
                    iconDefault.classList.remove('hidden');
                    iconDefault.className = 'w-8 h-8 text-red-500';
                }
            } catch (err) {
                setLoading(false);
                document.getElementById('preview-error-msg').textContent = 'Sunucu hatası: ' + err.message;
                showPanel('error');
                resetButton();
            }
        }

        input.addEventListener('input', function () {
            const code = this.value.trim().toUpperCase();
            this.value = code;

            // İkonu sıfırla
            iconWrap.className = 'w-16 h-16 bg-[#E0F7FA] rounded-full flex items-center justify-center transition-all duration-300';
            iconDefault.className = 'w-8 h-8 text-[#00A3B4]';
            iconDefault.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>`;

            clearTimeout(debounceTimer);
            resetButton();

            if (code.length === 0) {
                showPanel('empty');
                return;
            }

            // 300ms debounce — tam 8 karakter girince hemen sorgula
            const delay = code.length === 8 ? 0 : 400;
            debounceTimer = setTimeout(() => lookupCode(code), delay);
        });
    </script>

<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>