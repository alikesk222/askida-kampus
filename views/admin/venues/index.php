<?php include ROOT . '/views/layout/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-2">
            <a href="<?= url('admin') ?>" class="hover:text-[#00A3B4] transition">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium">İşletmeler</span>
        </nav>
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
            <tr><td colspan="6" class="px-6 py-16 text-center">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium text-sm">Henüz işletme yok</p>
                    <p class="text-gray-400 text-xs">Yeni işletme eklemek için sağ üstteki butonu kullanın.</p>
                    <a href="<?= url('admin/isletmeler/yeni') ?>" class="mt-1 px-4 py-2 bg-[#00A3B4] text-white text-xs font-medium rounded-lg hover:bg-[#007A8A] transition">+ Yeni İşletme Ekle</a>
                </div>
            </td></tr>
            <?php else: ?>
            <?php foreach ($venues as $venue): ?>
            <tr class="even:bg-gray-50/50 hover:bg-[#E0F7FA]/50 transition-colors">
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
