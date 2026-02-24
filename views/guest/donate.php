<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> — Askıda Kampüs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

<!-- Header -->
<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-[72px]">
        <a href="<?= url() ?>" class="flex items-center gap-3">
            <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-12 w-auto">
            <div class="border-l border-gray-300 pl-3">
                <p class="text-[13px] font-semibold text-gray-800 leading-tight">Ankara Yıldırım Beyazıt Üniversitesi</p>
                <p class="text-[12px] text-gray-500 leading-tight">İktisadi İşletmeler Müdürlüğü</p>
            </div>
        </a>
        <div class="flex items-center gap-3 text-sm">
            <a href="<?= url('misafir-bagis') ?>" class="text-gray-500 hover:text-gray-700 transition">← Geri</a>
            <a href="<?= url('giris') ?>" class="text-gray-600 hover:text-[#00A3B4] transition">Giriş Yap</a>
            <a href="<?= url('kayit') ?>" class="px-4 py-1.5 bg-[#00A3B4] text-white rounded-lg hover:bg-[#007A8A] transition">Hesap Oluştur</a>
        </div>
    </div>
</header>

<div class="flex-1 max-w-4xl mx-auto w-full px-4 py-10">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800"><?= e($venue['name']) ?> — Bağış Yap</h1>
        <p class="text-gray-500 text-sm mt-1"><?= e($venue['campus_name']) ?><?= $venue['location'] ? ' · ' . e($venue['location']) : '' ?></p>
    </div>

    <?php $flashError = flash('error'); ?>
    <?php if ($flashError): ?>
    <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm"><?= e($flashError) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= url('misafir-bagis/' . $venue['id']) ?>">
        <?= csrf_field() ?>

        <!-- Kişisel bilgiler -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="font-semibold text-gray-800 mb-4">Bağışçı Bilgileri</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ad Soyad <span class="text-red-500">*</span></label>
                    <input type="text" name="donor_name" value="<?= e($old['donor_name'] ?? '') ?>"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] text-sm <?= isset($errors['donor_name']) ? 'border-red-400' : '' ?>"
                        placeholder="Adınız Soyadınız" required>
                    <?= error_msg($errors, 'donor_name') ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">E-posta <span class="text-red-500">*</span></label>
                    <input type="email" name="donor_email" value="<?= e($old['donor_email'] ?? '') ?>"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] text-sm <?= isset($errors['donor_email']) ? 'border-red-400' : '' ?>"
                        placeholder="ornek@mail.com" required>
                    <?= error_msg($errors, 'donor_email') ?>
                </div>
            </div>
        </div>

        <!-- Ürün seçimi -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <h2 class="font-semibold text-gray-800 mb-1">Bağışlamak İstediğiniz Ürünler</h2>
            <p class="text-sm text-gray-500 mb-5">Ürün başına bağışlamak istediğiniz miktarı girin.</p>

            <?php if (empty($products)): ?>
            <p class="text-gray-400 text-sm">Bu işletmede şu an aktif ürün bulunmuyor.</p>
            <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <?php foreach ($products as $p): ?>
                <div class="border border-gray-200 rounded-xl p-4 flex gap-3 items-start hover:border-[#00A3B4]/40 transition">
                    <?php if ($p['image_url']): ?>
                    <img src="<?= e($p['image_url']) ?>" alt="<?= e($p['name']) ?>"
                         class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                    <?php else: ?>
                    <div class="w-16 h-16 bg-[#E0F7FA] rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">☕</span>
                    </div>
                    <?php endif; ?>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm"><?= e($p['name']) ?></p>
                        <?php if ($p['description']): ?>
                        <p class="text-xs text-gray-400 mt-0.5 truncate"><?= e($p['description']) ?></p>
                        <?php endif; ?>
                        <p class="text-[#00A3B4] font-bold text-sm mt-1"><?= number_format($p['price_snapshot'], 2) ?> ₺</p>
                        <div class="flex items-center gap-2 mt-2">
                            <label class="text-xs text-gray-500">Adet:</label>
                            <input type="number" name="qty[<?= $p['id'] ?>]" value="0" min="0" max="50"
                                class="w-16 px-2 py-1 border border-gray-300 rounded-md text-sm text-center focus:outline-none focus:ring-2 focus:ring-[#00A3B4] qty-input"
                                data-price="<?= $p['price_snapshot'] ?>">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Not -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Not (isteğe bağlı)</label>
            <textarea name="notes" rows="2"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] text-sm resize-none"
                placeholder="Bağışınızla ilgili eklemek istediğiniz not..."></textarea>
        </div>

        <!-- Özet & IBAN -->
        <div class="bg-[#E0F7FA] border border-[#00A3B4]/30 rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-gray-800">Toplam Bağış Tutarı</h3>
                <span id="total-amount" class="text-2xl font-extrabold text-[#00A3B4]">0,00 ₺</span>
            </div>
            <div class="border-t border-[#00A3B4]/20 pt-4 text-sm text-gray-600">
                <p class="font-semibold text-gray-700 mb-1">Ödeme Bilgileri (IBAN)</p>
                <p class="font-mono bg-white/70 rounded-lg px-3 py-2 text-gray-800 text-xs tracking-wider"><?= e($iban) ?></p>
                <p class="mt-2 text-xs text-gray-500">Formu gönderdikten sonra açıklamalı havale/EFT yapmanız gerekmektedir. Ödemeniz onaylandığında bağışınız stoğa eklenir.</p>
            </div>
        </div>

        <button type="submit"
            class="w-full py-3 bg-[#00A3B4] hover:bg-[#007A8A] text-white font-bold rounded-xl transition text-base shadow-md">
            Bağışı Gönder
        </button>
    </form>
</div>

<footer class="bg-[#0d1b3e] text-white/50 text-xs text-center py-4 mt-auto">
    &copy; <?= date('Y') ?> Ankara Yıldırım Beyazıt Üniversitesi — İktisadi İşletmeler Müdürlüğü
</footer>

<script>
function updateTotal() {
    let total = 0;
    document.querySelectorAll('.qty-input').forEach(input => {
        const qty = parseInt(input.value) || 0;
        const price = parseFloat(input.dataset.price) || 0;
        total += qty * price;
    });
    document.getElementById('total-amount').textContent =
        total.toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ₺';
}
document.querySelectorAll('.qty-input').forEach(i => i.addEventListener('input', updateTotal));
</script>
</body>
</html>
