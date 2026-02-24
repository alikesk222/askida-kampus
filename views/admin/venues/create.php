<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <a href="<?= url('admin/isletmeler') ?>" class="text-[#00A3B4] text-sm hover:underline">← İşletmeler</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Yeni İşletme</h1>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
    <form method="POST" action="<?= url('admin/isletmeler/yeni') ?>">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">İşletme Adı *</label>
                <input type="text" name="name" value="<?= old('name') ?>" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                <?= error_msg($errors, 'name') ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kampüs *</label>
                <input type="text" name="campus_name" value="<?= old('campus_name') ?>" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                <?= error_msg($errors, 'campus_name') ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug (URL) *</label>
                <input type="text" name="slug" value="<?= old('slug') ?>" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]"
                    placeholder="merkez-kafeterya">
                <?= error_msg($errors, 'slug') ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konum</label>
                <input type="text" name="location" value="<?= old('location') ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telefon</label>
                <input type="text" name="phone" value="<?= old('phone') ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Açılış</label>
                    <input type="time" name="opens_at" value="<?= old('opens_at') ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kapanış</label>
                    <input type="time" name="closes_at" value="<?= old('closes_at') ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
            <textarea name="description" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]"><?= old('description') ?></textarea>
        </div>

        <div class="mt-4 flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded">
            <label for="is_active" class="text-sm text-gray-700">Aktif</label>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="px-6 py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
                Kaydet
            </button>
            <a href="<?= url('admin/isletmeler') ?>"
               class="px-6 py-2 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition">
                İptal
            </a>
        </div>
    </form>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
