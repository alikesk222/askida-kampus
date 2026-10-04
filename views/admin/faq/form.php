<?php include ROOT . '/views/layout/header.php'; ?>

<?php $isEdit = isset($item); ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Sayfa yolu">
            <a href="<?= url('admin') ?>">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="<?= url('admin/sss') ?>">SSS</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span><?= $isEdit ? 'Düzenle' : 'Yeni' ?></span>
        </nav>
        <h1 class="page-title"><?= $isEdit ? 'SSS Sorusu Düzenle' : 'Yeni SSS Sorusu' ?></h1>
        <p class="page-desc">Türkçe ve İngilizce içerik giriniz</p>
    </div>
</div>

<form method="POST"
      action="<?= $isEdit ? url('admin/sss/' . $item['id'] . '/duzenle') : url('admin/sss/yeni') ?>">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Sol: Kategori + Sıra + Durum -->
        <div class="space-y-5">
            <div class="card">
                <div class="card-header"><h2 class="card-title">Ayarlar</h2></div>
                <div class="card-body space-y-4">

                    <div>
                        <label class="form-label">Kategori <span class="text-red-600">*</span></label>
                        <select name="category" required
                                class="form-select <?= isset($errors['category']) ? 'is-invalid' : '' ?>">
                            <option value="">Seçiniz</option>
                            <?php
                            $cats = ['donors' => 'Katkı Sağlayanlar', 'students' => 'Öğrenciler', 'general' => 'Genel'];
                            $selCat = $old['category'] ?? '';
                            foreach ($cats as $v => $l): ?>
                            <option value="<?= $v ?>" <?= $selCat === $v ? 'selected' : '' ?>><?= $l ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['category'])): ?>
                        <p class="form-error"><?= e($errors['category']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="form-label">Sıra Numarası</label>
                        <input type="number" name="sort_order" min="0" step="10"
                               value="<?= (int)($old['sort_order'] ?? 0) ?>"
                               class="form-input">
                        <p class="form-help">Küçük sayı = önce gösterilir</p>
                    </div>

                    <div>
                        <label for="is_active" class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                   <?= ($old['is_active'] ?? 1) ? 'checked' : '' ?>>
                            <span>Aktif (SSS sayfasında görünsün)</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sağ: İçerik -->
        <div class="lg:col-span-2 space-y-5">

            <!-- Türkçe -->
            <div class="card">
                <div class="card-header">
                    <span class="badge badge-plain bg-navy-100 text-navy-800">TR</span>
                    <h2 class="card-title">Türkçe İçerik</h2>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="form-label">Soru <span class="text-red-600">*</span></label>
                        <input type="text" name="question_tr"
                               value="<?= e($old['question_tr'] ?? '') ?>"
                               placeholder="Örn: Katkı sağlamak için üye olmam gerekiyor mu?"
                               class="form-input <?= isset($errors['question_tr']) ? 'is-invalid' : '' ?>">
                        <?php if (isset($errors['question_tr'])): ?>
                        <p class="form-error"><?= e($errors['question_tr']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="form-label">Cevap <span class="text-red-600">*</span></label>
                        <textarea name="answer_tr" rows="5"
                                  placeholder="Cevap metnini girin. HTML kullanabilirsiniz (örn: <strong>kalın</strong>, <a href='...'>bağlantı</a>)"
                                  class="form-textarea resize-y font-mono <?= isset($errors['answer_tr']) ? 'is-invalid' : '' ?>"><?= e($old['answer_tr'] ?? '') ?></textarea>
                        <?php if (isset($errors['answer_tr'])): ?>
                        <p class="form-error"><?= e($errors['answer_tr']) ?></p>
                        <?php endif; ?>
                        <p class="form-help">HTML etiketleri desteklenir: &lt;strong&gt;, &lt;a href="..."&gt;, &lt;br&gt;</p>
                    </div>
                </div>
            </div>

            <!-- İngilizce -->
            <div class="card">
                <div class="card-header">
                    <span class="badge badge-plain bg-navy-100 text-navy-800">EN</span>
                    <h2 class="card-title">English Content</h2>
                </div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="form-label">Question <span class="text-red-600">*</span></label>
                        <input type="text" name="question_en"
                               value="<?= e($old['question_en'] ?? '') ?>"
                               placeholder="e.g. Do I need to register to make a donation?"
                               class="form-input <?= isset($errors['question_en']) ? 'is-invalid' : '' ?>">
                        <?php if (isset($errors['question_en'])): ?>
                        <p class="form-error"><?= e($errors['question_en']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="form-label">Answer <span class="text-red-600">*</span></label>
                        <textarea name="answer_en" rows="5"
                                  placeholder="Enter the answer. HTML is supported (e.g. <strong>bold</strong>, <a href='...'>link</a>)"
                                  class="form-textarea resize-y font-mono <?= isset($errors['answer_en']) ? 'is-invalid' : '' ?>"><?= e($old['answer_en'] ?? '') ?></textarea>
                        <?php if (isset($errors['answer_en'])): ?>
                        <p class="form-error"><?= e($errors['answer_en']) ?></p>
                        <?php endif; ?>
                        <p class="form-help">HTML tags supported: &lt;strong&gt;, &lt;a href="..."&gt;, &lt;br&gt;</p>
                    </div>
                </div>
            </div>

            <!-- Butonlar -->
            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="<?= url('admin/sss') ?>" class="btn btn-outline">
                    İptal
                </a>
                <button type="submit" class="btn btn-primary">
                    <?= $isEdit ? 'Güncelle' : 'Kaydet' ?>
                </button>
            </div>
        </div>

    </div>
</form>

<?php include ROOT . '/views/layout/footer.php'; ?>
