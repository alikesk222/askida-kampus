<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url('admin/isletmeler') ?>">← İşletmeler</a>
        </nav>
        <h1 class="page-title">Yeni İşletme</h1>
        <p class="page-desc">İşletme bilgilerini girerek yeni bir işletme oluşturun.</p>
    </div>
</div>

<div class="card max-w-2xl">
    <form method="POST" action="<?= url('admin/isletmeler/yeni') ?>" class="card-body">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label" for="v-name">İşletme Adı *</label>
                <input type="text" name="name" id="v-name" value="<?= old('name') ?>" required class="form-input">
                <?= error_msg($errors, 'name') ?>
            </div>
            <div>
                <label class="form-label" for="v-campus">Kampüs *</label>
                <input type="text" name="campus_name" id="v-campus" value="<?= old('campus_name') ?>" required class="form-input">
                <?= error_msg($errors, 'campus_name') ?>
            </div>
            <div>
                <label class="form-label" for="v-slug">Slug (URL) *</label>
                <input type="text" name="slug" id="v-slug" value="<?= old('slug') ?>" required
                    class="form-input" placeholder="merkez-kafeterya">
                <?= error_msg($errors, 'slug') ?>
            </div>
            <div>
                <label class="form-label" for="v-location">Konum</label>
                <input type="text" name="location" id="v-location" value="<?= old('location') ?>" class="form-input">
            </div>
            <div>
                <label class="form-label" for="v-phone">Telefon</label>
                <input type="text" name="phone" id="v-phone" value="<?= old('phone') ?>" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="form-label" for="v-opens">Açılış</label>
                    <input type="time" name="opens_at" id="v-opens" value="<?= old('opens_at') ?>" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="v-closes">Kapanış</label>
                    <input type="time" name="closes_at" id="v-closes" value="<?= old('closes_at') ?>" class="form-input">
                </div>
            </div>
        </div>

        <div class="mt-4">
            <label class="form-label" for="v-desc">Açıklama</label>
            <textarea name="description" id="v-desc" rows="3" class="form-textarea"><?= old('description') ?></textarea>
        </div>

        <div class="mt-4">
            <label class="form-check" for="is_active">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                <span>Aktif</span>
            </label>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <button type="submit" class="btn btn-primary">
                Kaydet
            </button>
            <a href="<?= url('admin/isletmeler') ?>" class="btn btn-outline">
                İptal
            </a>
        </div>
    </form>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
