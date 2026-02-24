<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <a href="<?= url('bagis') ?>" class="text-[#00A3B4] text-sm hover:underline">← İşletmeler</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2"><?= e($venue['name']) ?> — Bağış Yap</h1>
    <p class="text-gray-500 text-sm"><?= e($venue['campus_name']) ?></p>
</div>

<?php if (empty($products)): ?>
<div class="bg-white rounded-xl shadow-sm p-10 text-center text-gray-400">
    Bu işletmede şu an bağış yapılabilecek ürün bulunmamaktadır.
</div>
<?php else: ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Ürün Seçimi -->
    <div class="lg:col-span-2">
        <form method="POST" action="<?= url('bagis/' . $venue['id']) ?>" id="donation-form">
            <?= csrf_field() ?>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-4">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-700">Ürün ve Miktar Seçin</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Bağışladığınız ürünler öğrencilerin kullanımına sunulacaktır.</p>
                </div>
                <div class="divide-y divide-gray-100">
                    <?php foreach ($products as $p): ?>
                    <div class="px-6 py-4 flex items-center justify-between gap-4">
                        <div class="flex-1">
                            <p class="font-medium text-gray-800"><?= e($p['name']) ?></p>
                            <?php if ($p['category']): ?>
                            <p class="text-xs text-gray-400"><?= e($p['category']) ?></p>
                            <?php endif; ?>
                            <?php if ($p['description']): ?>
                            <p class="text-xs text-gray-500 mt-0.5"><?= e($p['description']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-[#00A3B4]">₺<?= number_format($p['price_snapshot'], 2, ',', '.') ?></p>
                            <p class="text-xs text-gray-400">/ adet</p>
                        </div>
                        <div class="w-24">
                            <label class="block text-xs text-gray-500 mb-1 text-center">Miktar</label>
                            <input type="number" name="qty[<?= e($p['id']) ?>]" value="0" min="0" max="100"
                                data-price="<?= e($p['price_snapshot']) ?>"
                                class="qty-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-center
                                       focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Not (opsiyonel)</label>
                <textarea name="notes" rows="2"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]"
                    placeholder="Bağışınızla ilgili not ekleyebilirsiniz..."><?= old('notes') ?></textarea>
            </div>

            <button type="submit"
                class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-[#00A3B4] to-[#007A8A] hover:from-[#007A8A] hover:to-[#005F6B] text-white font-semibold rounded-xl transition">
                Bağış Talebini Gönder
            </button>
        </form>
    </div>

    <!-- Özet ve IBAN -->
    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-3">Toplam Tutar</h3>
            <p id="total-amount" class="text-3xl font-bold text-[#00A3B4]">₺0,00</p>
            <p class="text-xs text-gray-400 mt-1">Seçilen ürünlere göre hesaplanır</p>
        </div>

        <div class="bg-[#E0F7FA] border border-[#00A3B4]/30 rounded-xl p-5">
            <h3 class="font-semibold text-[#007A8A] mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                IBAN Bilgisi
            </h3>
            <p class="font-mono text-sm font-bold text-gray-800 bg-white rounded-lg px-3 py-2 select-all">
                <?= e($iban) ?>
            </p>
            <p class="text-xs text-[#007A8A] mt-3">
                Ödemeyi yaptıktan sonra <strong>"Bağış Talebini Gönder"</strong> butonuna tıklayın.
                Bağışınız admin onayından sonra stoğa eklenecektir.
            </p>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.qty-input');
    const totalEl = document.getElementById('total-amount');

    function updateTotal() {
        let total = 0;
        inputs.forEach(function (inp) {
            const qty   = parseInt(inp.value) || 0;
            const price = parseFloat(inp.dataset.price) || 0;
            total += qty * price;
        });
        totalEl.textContent = '₺' + total.toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    inputs.forEach(function (inp) {
        inp.addEventListener('input', updateTotal);
    });
});
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
