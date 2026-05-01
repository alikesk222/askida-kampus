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
            <div class="flex justify-between">
                <dt class="text-gray-500">Slug</dt>
                <dd class="font-mono text-gray-700"><?= e($venue['slug']) ?></dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Telefon</dt>
                <dd class="text-gray-700"><?= e($venue['phone'] ?? '-') ?></dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Açılış / Kapanış</dt>
                <dd class="text-gray-700"><?= e($venue['opens_at'] ?? '-') ?> – <?= e($venue['closes_at'] ?? '-') ?>
                </dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Durum</dt>
                <dd><?= $venue['is_active'] ? '<span class="text-green-600 font-medium">Aktif</span>' : '<span class="text-gray-400">Pasif</span>' ?>
                </dd>
            </div>
            <?php if ($venue['description']): ?>
                <div>
                    <dt class="text-gray-500 mb-1">Açıklama</dt>
                    <dd class="text-gray-700"><?= e($venue['description']) ?></dd>
                </div>
            <?php endif; ?>
        </dl>
    </div>

    <!-- Ürün Ekle -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-semibold text-gray-700 mb-4">Yeni Ürün Ekle</h2>
        <form method="POST" action="<?= url('admin/isletmeler/' . $venue['id'] . '/urun-ekle') ?>"
            enctype="multipart/form-data">
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
                <div class="col-span-2">
                    <label class="block text-xs text-gray-600 mb-1">Ürün Görseli (JPG, PNG, WEBP — max 2MB)</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp"
                        class="w-full text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:border-0 file:rounded-md file:bg-[#E0F7FA] file:text-[#006B76] file:text-xs file:font-medium hover:file:bg-[#b2ebf2] cursor-pointer">
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
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Görsel</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Ürün</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Kategori</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Fiyat</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Durum</th>
                <th class="px-6 py-3 text-right font-semibold text-gray-600">İşlem</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">Henüz ürün eklenmemiş.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <tr class="hover:bg-gray-50" id="product-row-<?= $p['id'] ?>">
                        <!-- Görsel -->
                        <td class="px-6 py-3">
                            <?php if (!empty($p['image_url'])): ?>
                                <img src="<?= url($p['image_url']) ?>" alt="<?= e($p['name']) ?>"
                                    class="w-14 h-14 object-cover rounded-lg border border-gray-200 shadow-sm cursor-pointer hover:opacity-90 transition"
                                    onclick="openImageModal('<?= url($p['image_url']) ?>', '<?= e($p['name']) ?>')">
                            <?php else: ?>
                                <div
                                    class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center border border-dashed border-gray-300">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-3 font-medium text-gray-800"><?= e($p['name']) ?></td>
                        <td class="px-6 py-3 text-gray-500"><?= e($p['category'] ?? '-') ?></td>
                        <td class="px-6 py-3 text-gray-700">₺<?= number_format($p['price_snapshot'], 2, ',', '.') ?></td>
                        <td class="px-6 py-3">
                            <?= $p['is_active']
                                ? '<span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Aktif</span>'
                                : '<span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Pasif</span>' ?>
                        </td>
                        <td class="px-6 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Görsel Güncelle butonu -->
                                <button
                                    onclick="openEditModal(<?= $p['id'] ?>, '<?= e(addslashes($p['name'])) ?>', '<?= e(addslashes($p['category'] ?? '')) ?>', '<?= $p['price_snapshot'] ?>', '<?= e(addslashes($p['description'] ?? '')) ?>', <?= $p['is_active'] ?>, '<?= $p['image_url'] ? url($p['image_url']) : '' ?>')"
                                    class="px-2 py-1 text-xs bg-blue-50 text-blue-600 hover:bg-blue-100 rounded transition">
                                    Düzenle
                                </button>
                                <form method="POST"
                                    action="<?= url('admin/isletmeler/' . $venue['id'] . '/urun/' . $p['id'] . '/sil') ?>"
                                    class="inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" data-confirm="Bu ürünü silmek istediğinizden emin misiniz?"
                                        class="text-red-500 hover:underline text-xs">Sil</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Görsel Büyütme Modalı -->
<div id="image-modal" class="fixed inset-0 bg-black/70 z-50 hidden flex items-center justify-center p-4"
    onclick="closeImageModal()">
    <div class="relative max-w-2xl w-full">
        <img id="modal-img" src="" alt="" class="w-full rounded-xl shadow-2xl max-h-[80vh] object-contain">
        <p id="modal-caption" class="text-white text-center mt-3 font-medium"></p>
        <button onclick="closeImageModal()"
            class="absolute -top-4 -right-4 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-lg text-gray-700 hover:bg-gray-100">✕</button>
    </div>
</div>

<!-- Ürün Düzenle Modalı -->
<div id="edit-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-auto" onclick="event.stopPropagation()">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800 text-lg">Ürün Düzenle</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
        </div>
        <form id="edit-form" method="POST" action="" enctype="multipart/form-data" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-3">
                <div class="col-span-2">
                    <label class="block text-xs text-gray-600 mb-1">Ürün Adı *</label>
                    <input type="text" name="name" id="edit-name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Kategori</label>
                    <input type="text" name="category" id="edit-category"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Fiyat (₺) *</label>
                    <input type="number" name="price_snapshot" id="edit-price" step="0.01" min="0.01" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>
                <div class="col-span-2">
                    <label class="block text-xs text-gray-600 mb-1">Açıklama</label>
                    <input type="text" name="description" id="edit-description"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>
                <!-- Mevcut görsel -->
                <div class="col-span-2" id="current-image-wrap">
                    <label class="block text-xs text-gray-600 mb-1">Mevcut Görsel</label>
                    <div class="flex items-center gap-3">
                        <img id="edit-current-img" src="" alt=""
                            class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                        <div>
                            <label class="flex items-center gap-2 text-xs text-red-500 cursor-pointer">
                                <input type="checkbox" name="remove_image" value="1" id="remove-image-cb"
                                    class="rounded">
                                Görseli kaldır
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <label class="block text-xs text-gray-600 mb-1">Yeni Görsel Yükle (boş bırakılırsa mevcut
                        kalır)</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp"
                        class="w-full text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:border-0 file:rounded-md file:bg-[#E0F7FA] file:text-[#006B76] file:text-xs file:font-medium hover:file:bg-[#b2ebf2] cursor-pointer">
                </div>
                <div class="col-span-2 flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-active" value="1" class="rounded">
                    <label for="edit-active" class="text-xs text-gray-600">Aktif</label>
                </div>
            </div>
            <button type="submit"
                class="w-full py-2.5 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-semibold transition">
                Güncelle
            </button>
        </form>
    </div>
</div>

<script>
    function openImageModal(src, caption) {
        document.getElementById('modal-img').src = src;
        document.getElementById('modal-caption').textContent = caption;
        document.getElementById('image-modal').classList.remove('hidden');
        document.getElementById('image-modal').classList.add('flex');
    }
    function closeImageModal() {
        document.getElementById('image-modal').classList.add('hidden');
        document.getElementById('image-modal').classList.remove('flex');
    }

    function openEditModal(pid, name, category, price, description, isActive, imgSrc) {
        const venueId = <?= $venue['id'] ?>;
        const baseUrl = <?= json_encode(url('')) ?>;
        document.getElementById('edit-form').action = `${baseUrl}/admin/isletmeler/${venueId}/urun/${pid}/guncelle`;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-category').value = category;
        document.getElementById('edit-price').value = price;
        document.getElementById('edit-description').value = description;
        document.getElementById('edit-active').checked = isActive == 1;
        document.getElementById('remove-image-cb').checked = false;

        const imgWrap = document.getElementById('current-image-wrap');
        const editImg = document.getElementById('edit-current-img');
        if (imgSrc) {
            editImg.src = imgSrc;
            imgWrap.style.display = 'block';
        } else {
            imgWrap.style.display = 'none';
        }

        document.getElementById('edit-modal').classList.remove('hidden');
        document.getElementById('edit-modal').classList.add('flex');
    }
    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
        document.getElementById('edit-modal').classList.remove('flex');
    }

    // Confirm dialog for delete
    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            if (!confirm(this.dataset.confirm)) e.preventDefault();
        });
    });
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>