<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <a href="<?= url('isletme') ?>" class="text-[#00A3B4] text-sm hover:underline">← Dashboard</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Stok Durumu</h1>
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
            <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">Stok kaydı bulunamadı.</td></tr>
            <?php else: ?>
            <?php foreach ($stocks as $s): ?>
            <tr class="hover:bg-gray-50">
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
