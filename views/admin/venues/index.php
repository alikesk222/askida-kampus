<?php include ROOT . '/views/layout/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">İşletmeler</h1>
        <p class="text-gray-500 text-sm mt-1">Toplam <?= count($venues) ?> işletme</p>
    </div>
    <a href="<?= url('admin/isletmeler/yeni') ?>"
       class="px-4 py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
        + Yeni İşletme
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">#</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">İşletme Adı</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Kampüs</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Konum</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Durum</th>
                <th class="px-6 py-3 text-right font-semibold text-gray-600">İşlem</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($venues)): ?>
            <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-400">Henüz işletme eklenmemiş.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($venues as $venue): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-gray-400"><?= e($venue['id']) ?></td>
                <td class="px-6 py-4 font-medium text-gray-800"><?= e($venue['name']) ?></td>
                <td class="px-6 py-4 text-gray-500"><?= e($venue['campus_name']) ?></td>
                <td class="px-6 py-4 text-gray-500"><?= e($venue['location'] ?? '-') ?></td>
                <td class="px-6 py-4">
                    <?php if ($venue['is_active']): ?>
                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Aktif</span>
                    <?php else: ?>
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs font-medium">Pasif</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="<?= url('admin/isletmeler/' . $venue['id']) ?>"
                       class="text-[#00A3B4] hover:underline text-xs mr-3">Detay</a>
                    <a href="<?= url('admin/isletmeler/' . $venue['id'] . '/duzenle') ?>"
                       class="text-indigo-500 hover:underline text-xs">Düzenle</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
