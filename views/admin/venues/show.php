<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url('admin/isletmeler') ?>">← İşletmeler</a>
        </nav>
        <h1 class="page-title"><?= e($venue['name']) ?></h1>
        <p class="page-desc"><?= e($venue['campus_name']) ?> · <?= e($venue['location'] ?? '') ?></p>
    </div>
    <div class="page-actions">
        <a href="<?= url('admin/isletmeler/' . $venue['id'] . '/duzenle') ?>" class="btn btn-outline">
            Düzenle
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Bilgiler -->
    <div class="card">
        <div class="card-header"><h2 class="card-title">İşletme Bilgileri</h2></div>
        <div class="card-body">
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">Slug</dt>
                    <dd class="font-mono text-slate-700"><?= e($venue['slug']) ?></dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">Telefon</dt>
                    <dd class="text-slate-700"><?= e($venue['phone'] ?? '-') ?></dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">Açılış / Kapanış</dt>
                    <dd class="text-slate-700"><?= e($venue['opens_at'] ?? '-') ?> – <?= e($venue['closes_at'] ?? '-') ?>
                    </dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-slate-500">Durum</dt>
                    <dd><?= $venue['is_active'] ? '<span class="badge badge-approved">Aktif</span>' : '<span class="badge badge-expired">Pasif</span>' ?>
                    </dd>
                </div>
                <?php if ($venue['description']): ?>
                    <div>
                        <dt class="text-slate-500 mb-1">Açıklama</dt>
                        <dd class="text-slate-700"><?= e($venue['description']) ?></dd>
                    </div>
                <?php endif; ?>
            </dl>
        </div>
    </div>

    <!-- Ürün Ekle -->
    <div class="card">
        <div class="card-header"><h2 class="card-title">Yeni Ürün Ekle</h2></div>
        <form method="POST" action="<?= url('admin/isletmeler/' . $venue['id'] . '/urun-ekle') ?>"
            enctype="multipart/form-data" class="card-body">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-3">
                <div class="col-span-2">
                    <label class="form-label" for="prod_name">Ürün Adı *</label>
                    <input type="text" name="name" id="prod_name" required class="form-input">
                    <?= error_msg($errors, 'name') ?>
                </div>
                <div>
                    <label class="form-label" for="prod_category">Kategori</label>
                    <input type="text" name="category" id="prod_category" class="form-input"
                        placeholder="İçecek, Yiyecek...">
                </div>
                <div>
                    <label class="form-label" for="prod_price">Fiyat (₺) *</label>
                    <input type="number" name="price_snapshot" id="prod_price" step="0.01" min="0.01" required class="form-input">
                    <?= error_msg($errors, 'price_snapshot') ?>
                </div>
                <div class="col-span-2">
                    <label class="form-label" for="prod_desc">Açıklama</label>
                    <input type="text" name="description" id="prod_desc" class="form-input">
                </div>
                <div class="col-span-2">
                    <label class="form-label" for="prod_image">Ürün Görseli <span class="optional">(JPG, PNG, WEBP — max 5MB)</span></label>
                    <input type="file" name="image" id="prod_image" accept="image/jpeg,image/png,image/gif,image/webp"
                        class="form-input">
                </div>
                <div class="col-span-2">
                    <label class="form-check" for="prod_active">
                        <input type="checkbox" name="is_active" id="prod_active" value="1" checked>
                        <span>Aktif</span>
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-4">
                Ürün Ekle
            </button>
        </form>
    </div>
</div>

<!-- Ürün Listesi -->
<div class="mt-6">
    <div class="page-header !mb-3">
        <h2 class="card-title">Ürünler (<?= count($products) ?>)</h2>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Görsel</th>
                    <th>Ürün</th>
                    <th>Kategori</th>
                    <th>Fiyat</th>
                    <th>Durum</th>
                    <th class="text-right">İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="empty-state-title">Henüz ürün eklenmemiş.</p>
                                <p>Yukarıdaki formu kullanarak ilk ürünü ekleyin.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $p): ?>
                        <tr id="product-row-<?= $p['id'] ?>">
                            <!-- Görsel -->
                            <td>
                                <?php if (!empty($p['image_url'])): ?>
                                    <img src="<?= url($p['image_url']) ?>" alt="<?= e($p['name']) ?>"
                                        class="w-14 h-14 object-cover rounded-xl border border-slate-200 shadow-soft cursor-pointer hover:opacity-90 transition"
                                        onclick="openImageModal('<?= url($p['image_url']) ?>', '<?= e($p['name']) ?>')">
                                <?php else: ?>
                                    <div
                                        class="w-14 h-14 bg-navy-50 rounded-xl flex items-center justify-center border border-dashed border-slate-300 text-navy-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="cell-strong"><?= e($p['name']) ?></td>
                            <td><?= e($p['category'] ?? '-') ?></td>
                            <td class="text-slate-700">₺<?= number_format($p['price_snapshot'], 2, ',', '.') ?></td>
                            <td>
                                <?= $p['is_active']
                                    ? '<span class="badge badge-approved">Aktif</span>'
                                    : '<span class="badge badge-expired">Pasif</span>' ?>
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Görsel Güncelle butonu -->
                                    <button type="button"
                                        onclick="openEditModal(<?= $p['id'] ?>, '<?= e(addslashes($p['name'])) ?>', '<?= e(addslashes($p['category'] ?? '')) ?>', '<?= $p['price_snapshot'] ?>', '<?= e(addslashes($p['description'] ?? '')) ?>', <?= $p['is_active'] ?>, '<?= $p['image_url'] ? e(url($p['image_url'])) : '' ?>')"
                                        class="btn btn-sm btn-outline">
                                        Düzenle
                                    </button>
                                    <form method="POST"
                                        action="<?= url('admin/isletmeler/' . $venue['id'] . '/urun/' . $p['id'] . '/sil') ?>"
                                        class="inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" data-confirm="Bu ürünü silmek istediğinizden emin misiniz?"
                                            class="btn btn-sm btn-danger-ghost">Sil</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Görsel Büyütme Modalı -->
<div id="image-modal" class="modal-backdrop hidden flex" role="dialog" aria-modal="true" aria-label="Ürün görseli"
    onclick="closeImageModal()">
    <div class="relative max-w-2xl w-full">
        <img id="modal-img" src="" alt="" class="w-full rounded-2xl shadow-lift max-h-[80vh] object-contain bg-white">
        <p id="modal-caption" class="text-white text-center mt-3 font-medium"></p>
        <button type="button" onclick="closeImageModal()" aria-label="Kapat"
            class="btn btn-icon absolute -top-4 -right-4 bg-white text-slate-700 hover:bg-slate-100 rounded-full shadow-lift">&#10005;</button>
    </div>
</div>

<!-- Ürün Düzenle Modalı -->
<div id="edit-modal" class="modal-backdrop hidden flex" role="dialog" aria-modal="true" aria-labelledby="edit-modal-title">
    <div class="modal-panel" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 id="edit-modal-title" class="modal-title">Ürün Düzenle</h3>
            <button type="button" onclick="closeEditModal()" class="btn btn-ghost btn-icon btn-sm" aria-label="Kapat">&#10005;</button>
        </div>
        <form id="edit-form" method="POST" action="" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="grid grid-cols-2 gap-3">
                    <div class="col-span-2">
                        <label class="form-label" for="edit-name">Ürün Adı *</label>
                        <input type="text" name="name" id="edit-name" required class="form-input">
                    </div>
                    <div>
                        <label class="form-label" for="edit-category">Kategori</label>
                        <input type="text" name="category" id="edit-category" class="form-input">
                    </div>
                    <div>
                        <label class="form-label" for="edit-price">Fiyat (₺) *</label>
                        <input type="number" name="price_snapshot" id="edit-price" step="0.01" min="0.01" required class="form-input">
                    </div>
                    <div class="col-span-2">
                        <label class="form-label" for="edit-description">Açıklama</label>
                        <input type="text" name="description" id="edit-description" class="form-input">
                    </div>
                    <!-- Mevcut görsel -->
                    <div class="col-span-2" id="current-image-wrap">
                        <span class="form-label">Mevcut Görsel</span>
                        <div class="flex items-center gap-3">
                            <img id="edit-current-img" src="" alt=""
                                class="w-20 h-20 object-cover rounded-xl border border-slate-200">
                            <div>
                                <label class="form-check text-sm text-red-700" for="remove-image-cb">
                                    <input type="checkbox" name="remove_image" value="1" id="remove-image-cb">
                                    <span>Görseli kaldır</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <label class="form-label" for="edit-image">Yeni Görsel Yükle <span class="optional">(boş bırakılırsa mevcut kalır)</span></label>
                        <input type="file" name="image" id="edit-image" accept="image/jpeg,image/png,image/gif,image/webp"
                            class="form-input">
                    </div>
                    <div class="col-span-2">
                        <label class="form-check" for="edit-active">
                            <input type="checkbox" name="is_active" id="edit-active" value="1">
                            <span>Aktif</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeEditModal()" class="btn btn-outline">İptal</button>
                <button type="submit" class="btn btn-primary">
                    Güncelle
                </button>
            </div>
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