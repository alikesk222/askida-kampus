<?php include ROOT . '/views/layout/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <a href="<?= url('admin/isletmeler') ?>" class="text-[#00A3B4] text-sm hover:underline">← İşletmeler</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2"><?= e($venue['name']) ?></h1>
        <p class="text-gray-500 text-sm"><?= e($venue['campus_name']) ?> · <?= e($venue['location'] ?? '') ?></p>
    </div>
    <a href="<?= url('admin/isletmeler/' . $venue['id'] . '/duzenle') ?>"
       class="px-4 py-2 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
        Düzenle
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Bilgiler -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-semibold text-gray-700 mb-4">İşletme Bilgileri</h2>
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between"><dt class="text-gray-500">Slug</dt><dd class="font-mono text-gray-700"><?= e($venue['slug']) ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Telefon</dt><dd class="text-gray-700"><?= e($venue['phone'] ?? '-') ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Açılış / Kapanış</dt><dd class="text-gray-700"><?= e($venue['opens_at'] ?? '-') ?> – <?= e($venue['closes_at'] ?? '-') ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Durum</dt>
                <dd><?= $venue['is_active'] ? '<span class="text-green-600 font-medium">Aktif</span>' : '<span class="text-gray-400">Pasif</span>' ?></dd>
            </div>
            <?php if ($venue['description']): ?>
            <div><dt class="text-gray-500 mb-1">Açıklama</dt><dd class="text-gray-700"><?= e($venue['description']) ?></dd></div>
            <?php endif; ?>
        </dl>
    </div>

    <!-- Ürün Ekle -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-semibold text-gray-700 mb-4">Yeni Ürün Ekle</h2>
        <form method="POST" action="<?= url('admin/isletmeler/' . $venue['id'] . '/urun-ekle') ?>">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-3">
                <div class="col-span-2">
                    <label class="block text-xs text-gray-600 mb-1">Ürün Adı *</label>
                    <input type="text" name="name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                    <?= error_msg($errors, 'name') ?>
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Kategori</label>
                    <input type="text" name="category"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]"
                        placeholder="İçecek, Yiyecek...">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Fiyat (₺) *</label>
                    <input type="number" name="price_snapshot" step="0.01" min="0.01" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                    <?= error_msg($errors, 'price_snapshot') ?>
                </div>
                <div class="col-span-2">
                    <label class="block text-xs text-gray-600 mb-1">Açıklama</label>
                    <input type="text" name="description"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>
                <div class="col-span-2 flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="prod_active" value="1" checked class="rounded">
                    <label for="prod_active" class="text-xs text-gray-600">Aktif</label>
                </div>
            </div>
            <button type="submit"
                class="mt-3 w-full py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
                Ürün Ekle
            </button>
        </form>
    </div>
</div>

<!-- Ürün Listesi -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-semibold text-gray-700">Ürünler (<?= count($products) ?>)</h2>
    </div>
    <table class="min-w-full divide-y divide-gray-100 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Ürün</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Kategori</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Fiyat</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Durum</th>
                <th class="px-6 py-3 text-right font-semibold text-gray-600">İşlem</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($products)): ?>
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Henüz ürün eklenmemiş.</td></tr>
            <?php else: ?>
            <?php foreach ($products as $p): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium text-gray-800"><?= e($p['name']) ?></td>
                <td class="px-6 py-3 text-gray-500"><?= e($p['category'] ?? '-') ?></td>
                <td class="px-6 py-3 text-gray-700">₺<?= number_format($p['price_snapshot'], 2, ',', '.') ?></td>
                <td class="px-6 py-3">
                    <?= $p['is_active']
                        ? '<span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Aktif</span>'
                        : '<span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Pasif</span>' ?>
                </td>
                <td class="px-6 py-3 text-right">
                    <form method="POST" action="<?= url('admin/isletmeler/' . $venue['id'] . '/urun/' . $p['id'] . '/sil') ?>" class="inline">
                        <?= csrf_field() ?>
                        <button type="submit" data-confirm="Bu ürünü silmek istediğinizden emin misiniz?"
                            class="text-red-500 hover:underline text-xs">Sil</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
