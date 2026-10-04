<?php include ROOT . '/views/layout/header.php'; ?>

<!-- Sayfa başlığı -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800"><?= t('student_doc.page_title') ?></h1>
    <p class="text-gray-500 text-sm mt-1"><?= t('student_doc.subtitle') ?></p>
</div>

<?php if ($success): ?>
    <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm font-medium">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <?= e($success) ?>
    </div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm font-medium">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <?= e($error) ?>
    </div>
<?php endif; ?>

<!-- Üst kartlar: Haftalık hak + Bilgi -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <!-- Kalan hak -->
    <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 border-l-4 border-[#00A3B4]">
        <div class="w-12 h-12 bg-[#E0F7FA] rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[#00A3B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-medium"><?= t('student_doc.quota_remaining') ?></p>
            <p class="text-2xl font-bold text-[#00A3B4]"><?= $weeklyRemaining ?></p>
            <p class="text-xs text-gray-400"><?= $weeklyUsed ?> / <?= $weeklyLimit ?> <?= t('student_doc.quota_used') ?></p>
        </div>
    </div>

    <!-- Haftalık limit -->
    <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 border-l-4 border-indigo-400">
        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-medium"><?= t('student_doc.quota_weekly') ?></p>
            <p class="text-2xl font-bold text-indigo-500"><?= $weeklyLimit ?></p>
            <p class="text-xs text-gray-400"><?= t('student_doc.quota_resets') ?></p>
        </div>
    </div>

    <!-- Belge bonusu -->
    <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 border-l-4 border-amber-400">
        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-medium"><?= t('student_doc.bonus_per_doc') ?></p>
            <p class="text-2xl font-bold text-amber-500">+<?= $bonusQuota ?></p>
            <p class="text-xs text-gray-400"><?= t('student_doc.bonus_per_doc_sub') ?></p>
        </div>
    </div>
</div>

<!-- Haftalık ilerleme çubuğu -->
<div class="bg-white rounded-xl shadow-sm p-5 mb-6">
    <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-semibold text-gray-700"><?= t('student_doc.quota_bar_label') ?></span>
        <span class="text-sm text-gray-500"><?= $weeklyUsed ?> / <?= $weeklyLimit ?></span>
    </div>
    <?php $pct = $weeklyLimit > 0 ? min(100, round($weeklyUsed / $weeklyLimit * 100)) : 0; ?>
    <div class="w-full bg-gray-100 rounded-full h-3">
        <div class="h-3 rounded-full transition-all <?= $pct >= 100 ? 'bg-red-400' : ($pct >= 70 ? 'bg-amber-400' : 'bg-[#00A3B4]') ?>"
             style="width:<?= $pct ?>%"></div>
    </div>
    <p class="text-xs text-gray-400 mt-2"><?= t('student_doc.quota_bar_hint') ?></p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    <!-- Sol: Yükleme formu + Bilgi -->
    <div class="lg:col-span-2 space-y-4">

        <!-- Bilgi kartı -->
        <div class="bg-[#E0F7FA] rounded-xl p-5">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-[#00A3B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-bold text-[#006064]"><?= t('student_doc.info_title') ?></span>
            </div>
            <p class="text-sm text-[#00838f] leading-relaxed"><?= t('student_doc.info_body') ?></p>
        </div>

        <!-- Yükleme formu -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#00A3B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <?= t('student_doc.upload_title') ?>
            </h2>
            <form method="POST" action="<?= url('ogrencim/belgeler/yukle') ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <label class="block mb-3">
                    <span class="text-xs font-semibold text-gray-600 block mb-1.5"><?= t('student_doc.file_label') ?></span>
                    <div id="drop-zone"
                         class="relative border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-[#00A3B4] hover:bg-[#f0fdfe] transition-all"
                         onclick="document.getElementById('doc-input').click()">
                        <input type="file" id="doc-input" name="document"
                               accept=".pdf,.jpg,.jpeg,.png,.webp"
                               class="absolute inset-0 opacity-0 w-full h-full cursor-pointer"
                               onchange="showFileName(this)" required>
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p id="drop-text" class="text-sm text-gray-400"><?= t('student_doc.drop_hint') ?></p>
                        <p class="text-xs text-gray-300 mt-1"><?= t('student_doc.file_hint') ?></p>
                    </div>
                </label>
                <button type="submit"
                        class="w-full py-2.5 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-semibold transition">
                    <?= t('student_doc.upload_btn') ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Sağ: Belgeler listesi -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-800"><?= t('student_doc.history_title') ?></h2>
                <span class="text-xs text-gray-400"><?= count($documents) ?> <?= t('student_doc.doc_count') ?></span>
            </div>

            <?php if (empty($documents)): ?>
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm"><?= t('student_doc.no_docs') ?></p>
                </div>
            <?php else: ?>
                <div class="divide-y divide-gray-50">
                    <?php foreach ($documents as $doc): ?>
                        <?php
                            $isPending  = $doc['status'] === 'pending';
                            $isApproved = $doc['status'] === 'approved';
                            $isRejected = $doc['status'] === 'rejected';
                        ?>
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex items-start gap-3">

                                <!-- Durum ikonu -->
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5
                                    <?= $isApproved ? 'bg-green-100' : ($isRejected ? 'bg-red-100' : 'bg-amber-100') ?>">
                                    <?php if ($isApproved): ?>
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    <?php elseif ($isRejected): ?>
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    <?php endif; ?>
                                </div>

                                <!-- İçerik -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <a href="<?= asset($doc['file_path']) ?>" target="_blank"
                                           class="text-sm font-semibold text-gray-800 hover:text-[#00A3B4] truncate transition">
                                            <?= e($doc['file_name']) ?>
                                        </a>
                                        <span class="text-xs px-2 py-0.5 rounded-full font-semibold
                                            <?= $isApproved ? 'bg-green-100 text-green-700' : ($isRejected ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700') ?>">
                                            <?= t('student_doc.status_' . $doc['status']) ?>
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-0.5"><?= format_date($doc['created_at']) ?></p>

                                    <?php if ($isApproved): ?>
                                        <div class="mt-1.5 flex items-center gap-1.5">
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-lg px-2.5 py-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                +<?= $bonusQuota ?> <?= t('student_doc.bonus_label') ?>
                                            </span>
                                        </div>
                                    <?php elseif ($isRejected && $doc['rejection_reason']): ?>
                                        <div class="mt-1.5 bg-red-50 border border-red-100 rounded-lg px-3 py-2">
                                            <p class="text-xs text-red-600 font-medium"><?= t('student_doc.rejection_reason') ?>:</p>
                                            <p class="text-xs text-red-500 mt-0.5"><?= e($doc['rejection_reason']) ?></p>
                                        </div>
                                    <?php elseif ($isPending): ?>
                                        <p class="text-xs text-amber-600 mt-1"><?= t('student_doc.pending_note') ?></p>
                                    <?php endif; ?>
                                </div>

                                <!-- Dosyayı görüntüle -->
                                <a href="<?= asset($doc['file_path']) ?>" target="_blank"
                                   class="flex-shrink-0 p-2 text-gray-400 hover:text-[#00A3B4] hover:bg-[#E0F7FA] rounded-lg transition"
                                   title="<?= t('student_doc.view_file') ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function showFileName(input) {
    const text = document.getElementById('drop-text');
    if (input.files && input.files[0]) {
        text.textContent = input.files[0].name;
        text.classList.add('text-[#00A3B4]', 'font-semibold');
        text.classList.remove('text-gray-400');
    }
}
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
