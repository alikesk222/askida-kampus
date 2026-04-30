<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-2">
        <a href="<?= url('isletme') ?>" class="hover:text-[#00A3B4] transition">Dashboard</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-600 font-medium">Stok Durumu</span>
    </nav>
    <h1 class="text-2xl font-bold text-gray-800">Stok Durumu</h1>
    <p class="text-gray-500 text-sm mt-1"><?= e($venue['name'] ?? '') ?></p>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Ürün</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Kategori</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Fiyat</th>
                <th class="px-6 py-3 text-center font-semibold text-gray-600">Toplam Stok</th>
                <th class="px-6 py-3 text-center font-semibold text-gray-600">Rezerve</th>
                <th class="px-6 py-3 text-center font-semibold text-gray-600">Serbest</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($stocks)): ?>
            <tr><td colspan="6" class="px-6 py-16 text-center">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <p class="text-gray-500 font-medium text-sm">Stok bulunamadı</p>
                    <p class="text-gray-400 text-xs">Bu işletmede henüz stok kaydı oluşturulmamış.</p>
                </div>
            </td></tr>
            <?php else: ?>
            <?php foreach ($stocks as $s): ?>
            <tr class="even:bg-gray-50/50 hover:bg-[#E0F7FA]/50 transition-colors">
                <td class="px-6 py-3 font-medium text-gray-800"><?= e($s['product_name']) ?></td>
                <td class="px-6 py-3 text-gray-500"><?= e($s['category'] ?? '-') ?></td>
                <td class="px-6 py-3 text-gray-700">₺<?= number_format($s['price_snapshot'], 2, ',', '.') ?></td>
                <td class="px-6 py-3 text-center font-semibold text-gray-700"><?= e($s['available_quantity']) ?></td>
                <td class="px-6 py-3 text-center text-yellow-600 font-medium"><?= e($s['reserved_quantity']) ?></td>
                <td class="px-6 py-3 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        <?= (int)$s['free_quantity'] > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' ?>">
                        <?= e($s['free_quantity']) ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
