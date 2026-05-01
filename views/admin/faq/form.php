<?php include ROOT . '/views/layout/header.php'; ?>

<?php $isEdit = isset($item); ?>

<div class="mb-6 flex items-center gap-3">
    <a href="<?= url('admin/sss') ?>" class="text-gray-400 hover:text-gray-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= $isEdit ? 'SSS Sorusu Düzenle' : 'Yeni SSS Sorusu' ?></h1>
        <p class="text-gray-500 text-sm mt-0.5">Türkçe ve İngilizce içerik giriniz</p>
    </div>
</div>

<form method="POST"
      action="<?= $isEdit ? url('admin/sss/' . $item['id'] . '/duzenle') : url('admin/sss/yeni') ?>">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Sol: Kategori + Sıra + Durum -->
        <div class="space-y-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Ayarlar</h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] <?= isset($errors['category']) ? 'border-red-400' : '' ?>">
                        <option value="">Seçiniz</option>
                        <?php
                        $cats = ['donors' => 'Bağışçılar', 'students' => 'Öğrenciler', 'general' => 'Genel'];
                        $selCat = $old['category'] ?? '';
                        foreach ($cats as $v => $l): ?>
                        <option value="<?= $v ?>" <?= $selCat === $v ? 'selected' : '' ?>><?= $l ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['category'])): ?>
                    <p class="mt-1 text-xs text-red-500"><?= e($errors['category']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Sıra Numarası</label>
                    <input type="number" name="sort_order" min="0" step="10"
                           value="<?= (int)($old['sort_order'] ?? 0) ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]">
                    <p class="mt-1 text-xs text-gray-400">Küçük sayı = önce gösterilir</p>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           <?= ($old['is_active'] ?? 1) ? 'checked' : '' ?>
                           class="w-4 h-4 rounded border-gray-300 text-[#00A3B4] focus:ring-[#00A3B4]">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Aktif (SSS sayfasında görünsün)</label>
                </div>
            </div>
        </div>

        <!-- Sağ: İçerik -->
        <div class="lg:col-span-2 space-y-5">

            <!-- Türkçe -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-bold rounded">TR</span>
                    <h2 class="text-sm font-semibold text-gray-700">Türkçe İçerik</h2>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Soru <span class="text-red-500">*</span></label>
                    <input type="text" name="question_tr"
                           value="<?= e($old['question_tr'] ?? '') ?>"
                           placeholder="Örn: Bağış yapmak için üye olmam gerekiyor mu?"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] <?= isset($errors['question_tr']) ? 'border-red-400' : '' ?>">
                    <?php if (isset($errors['question_tr'])): ?>
                    <p class="mt-1 text-xs text-red-500"><?= e($errors['question_tr']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Cevap <span class="text-red-500">*</span></label>
                    <textarea name="answer_tr" rows="5"
                              placeholder="Cevap metnini girin. HTML kullanabilirsiniz (örn: <strong>kalın</strong>, <a href='...'>bağlantı</a>)"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] resize-y font-mono <?= isset($errors['answer_tr']) ? 'border-red-400' : '' ?>"><?= e($old['answer_tr'] ?? '') ?></textarea>
                    <?php if (isset($errors['answer_tr'])): ?>
                    <p class="mt-1 text-xs text-red-500"><?= e($errors['answer_tr']) ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-xs text-gray-400">HTML etiketleri desteklenir: &lt;strong&gt;, &lt;a href="..."&gt;, &lt;br&gt;</p>
                </div>
            </div>

            <!-- İngilizce -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded">EN</span>
                    <h2 class="text-sm font-semibold text-gray-700">English Content</h2>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Question <span class="text-red-500">*</span></label>
                    <input type="text" name="question_en"
                           value="<?= e($old['question_en'] ?? '') ?>"
                           placeholder="e.g. Do I need to register to make a donation?"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] <?= isset($errors['question_en']) ? 'border-red-400' : '' ?>">
                    <?php if (isset($errors['question_en'])): ?>
                    <p class="mt-1 text-xs text-red-500"><?= e($errors['question_en']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Answer <span class="text-red-500">*</span></label>
                    <textarea name="answer_en" rows="5"
                              placeholder="Enter the answer. HTML is supported (e.g. <strong>bold</strong>, <a href='...'>link</a>)"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] resize-y font-mono <?= isset($errors['answer_en']) ? 'border-red-400' : '' ?>"><?= e($old['answer_en'] ?? '') ?></textarea>
                    <?php if (isset($errors['answer_en'])): ?>
                    <p class="mt-1 text-xs text-red-500"><?= e($errors['answer_en']) ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-xs text-gray-400">HTML tags supported: &lt;strong&gt;, &lt;a href="..."&gt;, &lt;br&gt;</p>
                </div>
            </div>

            <!-- Butonlar -->
            <div class="flex items-center justify-end gap-3">
                <a href="<?= url('admin/sss') ?>"
                   class="px-5 py-2 text-sm font-semibold text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    İptal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-[#00A3B4] text-white text-sm font-semibold rounded-lg hover:bg-[#007A8A] transition">
                    <?= $isEdit ? 'Güncelle' : 'Kaydet' ?>
                </button>
            </div>
        </div>

    </div>
</form>

<?php include ROOT . '/views/layout/footer.php'; ?>
