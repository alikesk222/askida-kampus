<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">İşletme Paneli</h1>
    <p class="text-gray-500 text-sm mt-1"><?= e($venue['name'] ?? '') ?> — <?= e($venue['campus_name'] ?? '') ?></p>
</div>

<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#00A3B4]">
        <p class="text-sm text-gray-500">Serbest Stok</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?= e($freeStock) ?></p>
        <p class="text-xs text-gray-400 mt-1">Toplam rezerve edilebilir</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-400">
        <p class="text-sm text-gray-500">Bekleyen Bağış</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?= e($waiting) ?></p>
        <p class="text-xs text-gray-400 mt-1">Onay bekliyor</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-400">
        <p class="text-sm text-gray-500">Aktif Rezervasyon</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?= count($active) ?></p>
        <p class="text-xs text-gray-400 mt-1">Son 5 kayıt gösteriliyor</p>
    </div>
</div>

<!-- Hızlı Erişim -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <a href="<?= url('isletme/stok') ?>" class="flex items-center gap-4 bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
        <div class="w-10 h-10 bg-[#E0F7FA] rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-[#00A3B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-800 text-sm">Stok Durumu</p>
            <p class="text-xs text-gray-400">Ürün bazlı stok göster</p>
        </div>
    </a>
    <a href="<?= url('isletme/bagislar') ?>" class="flex items-center gap-4 bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
        <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-800 text-sm">Bağışlar</p>
            <p class="text-xs text-gray-400">Onayla, listele</p>
        </div>
    </a>
    <a href="<?= url('isletme/rezervasyonlar') ?>" class="flex items-center gap-4 bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition">
        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-800 text-sm">Rezervasyonlar</p>
            <p class="text-xs text-gray-400">Tüm rezervasyonlar</p>
        </div>
    </a>
</div>

<!-- Son Rezervasyonlar -->
<?php if (!empty($active)): ?>
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-semibold text-gray-700">Son Rezervasyonlar</h2>
    </div>
    <table class="min-w-full divide-y divide-gray-100 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Öğrenci</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Kod</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Durum</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Son Kullanma</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach ($active as $r): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-medium text-gray-800"><?= e($r['student_name']) ?></td>
                <td class="px-5 py-3 font-mono font-bold text-gray-700"><?= e($r['claim_code']) ?></td>
                <td class="px-5 py-3"><?= status_badge($r['status']) ?></td>
                <td class="px-5 py-3 text-xs text-gray-500"><?= format_date($r['expires_at']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
