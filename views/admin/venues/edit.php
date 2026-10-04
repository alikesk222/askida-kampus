<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url('admin/isletmeler/' . $venue['id']) ?>">← <?= e($venue['name']) ?></a>
        </nav>
        <h1 class="page-title">İşletme Düzenle</h1>
        <p class="page-desc">İşletme bilgilerini güncelleyin.</p>
    </div>
</div>

<div class="card max-w-2xl">
    <form method="POST" action="<?= url('admin/isletmeler/' . $venue['id'] . '/duzenle') ?>" class="card-body">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="v-name">İşletme Adı *</label>
                <input type="text" name="name" id="v-name" value="<?= e($venue['name']) ?>" required class="form-input">
                <?= error_msg($errors, 'name') ?>
            </div>
            <div>
                <label class="form-label" for="v-campus">Kampüs *</label>
                <input type="text" name="campus_name" id="v-campus" value="<?= e($venue['campus_name']) ?>" required class="form-input">
                <?= error_msg($errors, 'campus_name') ?>
            </div>
            <div>
                <label class="form-label" for="v-slug">Slug (URL) *</label>
                <input type="text" name="slug" id="v-slug" value="<?= e($venue['slug']) ?>" required class="form-input">
                <?= error_msg($errors, 'slug') ?>
            </div>
            <div>
                <label class="form-label" for="v-location">Konum</label>
                <input type="text" name="location" id="v-location" value="<?= e($venue['location'] ?? '') ?>" class="form-input">
            </div>
            <div>
                <label class="form-label" for="v-phone">Telefon</label>
                <input type="text" name="phone" id="v-phone" value="<?= e($venue['phone'] ?? '') ?>" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="form-label" for="v-opens">Açılış</label>
                    <input type="time" name="opens_at" id="v-opens" value="<?= e($venue['opens_at'] ?? '') ?>" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="v-closes">Kapanış</label>
                    <input type="time" name="closes_at" id="v-closes" value="<?= e($venue['closes_at'] ?? '') ?>" class="form-input">
                </div>
            </div>
        </div>

        <div class="mt-4">
            <label class="form-label" for="v-desc">Açıklama</label>
            <textarea name="description" id="v-desc" rows="3" class="form-textarea"><?= e($venue['description'] ?? '') ?></textarea>
        </div>

        <div class="mt-4">
            <label class="form-check" for="is_active">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    <?= $venue['is_active'] ? 'checked' : '' ?>>
                <span>Aktif</span>
            </label>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <button type="submit" class="btn btn-primary">
                Güncelle
            </button>
            <a href="<?= url('admin/isletmeler/' . $venue['id']) ?>" class="btn btn-outline">
                İptal
            </a>
        </div>
    </form>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
