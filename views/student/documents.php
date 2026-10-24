<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <h1 class="page-title"><?= t('student_doc.page_title') ?></h1>
        <p class="page-desc"><?= t('student_doc.subtitle') ?></p>
    </div>
</div>

<?php if ($success): ?>
    <div class="flash flash-success mb-4" role="status">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <div class="flash-body"><?= e($success) ?></div>
    </div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="flash flash-error mb-4" role="alert">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <div class="flash-body"><?= e($error) ?></div>
    </div>
<?php endif; ?>

<!-- Üst kartlar: Haftalık hak + Bilgi -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <!-- Kalan hak -->
    <div class="card p-5 flex items-center gap-4">
        <div class="icon-chip icon-chip-gold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
        </div>
        <div>
            <p class="stat-label"><?= t('student_doc.quota_remaining') ?></p>
            <p class="stat-value"><?= $weeklyRemaining ?></p>
            <p class="text-xs text-slate-500"><?= $weeklyUsed ?> / <?= $weeklyLimit ?> <?= t('student_doc.quota_used') ?></p>
        </div>
    </div>

    <!-- Haftalık limit -->
    <div class="card p-5 flex items-center gap-4">
        <div class="icon-chip">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <p class="stat-label"><?= t('student_doc.quota_weekly') ?></p>
            <p class="stat-value"><?= $weeklyLimit ?></p>
            <p class="text-xs text-slate-500"><?= t('student_doc.quota_resets') ?></p>
        </div>
    </div>

    <!-- Belge bonusu -->
    <div class="card p-5 flex items-center gap-4">
        <div class="icon-chip">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </div>
        <div>
            <p class="stat-label"><?= t('student_doc.bonus_per_doc') ?></p>
            <p class="stat-value">+<?= $bonusQuota ?></p>
            <p class="text-xs text-slate-500"><?= t('student_doc.bonus_per_doc_sub') ?></p>
        </div>
    </div>
</div>

<!-- Haftalık ilerleme çubuğu -->
<div class="card p-5 mb-6">
    <div class="flex items-center justify-between mb-2">
        <span class="text-sm font-bold text-slate-900"><?= t('student_doc.quota_bar_label') ?></span>
        <span class="text-sm text-slate-600 tabular-nums"><?= $weeklyUsed ?> / <?= $weeklyLimit ?></span>
    </div>
    <?php $pct = $weeklyLimit > 0 ? min(100, round($weeklyUsed / $weeklyLimit * 100)) : 0; ?>
    <div class="progress">
        <div class="progress-bar" style="width:<?= $pct ?>%"></div>
    </div>
    <p class="text-xs text-slate-500 mt-2"><?= t('student_doc.quota_bar_hint') ?></p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    <!-- Sol: Yükleme formu + Bilgi -->
    <div class="lg:col-span-2 space-y-4">

        <!-- Bilgi kartı -->
        <div class="flash flash-info !block">
            <p class="text-sm font-bold mb-1"><?= t('student_doc.info_title') ?></p>
            <p class="text-sm leading-relaxed"><?= t('student_doc.info_body') ?></p>
        </div>

        <!-- Yükleme formu -->
        <div class="card p-5">
            <h2 class="card-title mb-4"><?= t('student_doc.upload_title') ?></h2>
            <form method="POST" action="<?= url('ogrencim/belgeler/yukle') ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <span class="form-label"><?= t('student_doc.file_label') ?></span>
                <label id="drop-zone" for="doc-input" class="dropzone mb-4">
                    <input type="file" id="doc-input" name="document"
                           accept=".pdf,.jpg,.jpeg,.png,.webp"
                           class="sr-only"
                           onchange="showFileName(this)" required>
                    <svg class="w-10 h-10 mx-auto mb-2 text-navy-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <p id="drop-text" class="text-sm font-semibold text-slate-700"><?= t('student_doc.drop_hint') ?></p>
                    <p class="text-xs text-slate-500 mt-1"><?= t('student_doc.file_hint') ?></p>
                    <p id="file-name" class="hidden mt-3 text-sm font-bold text-navy-800 break-all" aria-live="polite"></p>
                </label>
                <button type="submit" class="btn btn-primary btn-block">
                    <?= t('student_doc.upload_btn') ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Sağ: Belgeler listesi -->
    <div class="lg:col-span-3">
        <div class="card overflow-hidden">
            <div class="card-header">
                <h2 class="card-title"><?= t('student_doc.history_title') ?></h2>
                <span class="badge badge-gold-soft badge-plain"><?= count($documents) ?> <?= t('student_doc.doc_count') ?></span>
            </div>

            <?php if (empty($documents)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="empty-state-title"><?= t('student_doc.no_docs') ?></p>
                </div>
            <?php else: ?>
                <div class="divide-y divide-slate-200">
                    <?php foreach ($documents as $doc): ?>
                        <?php
                            $isPending  = $doc['status'] === 'pending';
                            $isApproved = $doc['status'] === 'approved';
                            $isRejected = $doc['status'] === 'rejected';
                            $badgeCls   = $isApproved ? 'badge-approved' : ($isRejected ? 'badge-rejected' : 'badge-pending');
                        ?>
                        <div class="p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <a href="<?= url('ogrencim/belgeler/' . (int) $doc['id'] . '/indir') ?>" target="_blank"
                                           class="link text-sm font-semibold truncate">
                                            <?= e($doc['file_name']) ?>
                                        </a>
                                        <span class="badge <?= $badgeCls ?>"><?= t('student_doc.status_' . $doc['status']) ?></span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-0.5"><?= format_date($doc['created_at']) ?></p>

                                    <?php if ($isApproved): ?>
                                        <div class="mt-2">
                                            <span class="badge badge-gold-soft">+<?= $bonusQuota ?> <?= t('student_doc.bonus_label') ?></span>
                                        </div>
                                    <?php elseif ($isRejected && $doc['rejection_reason']): ?>
                                        <div class="flash flash-error !block mt-2 !py-2">
                                            <p class="text-xs font-bold"><?= t('student_doc.rejection_reason') ?>:</p>
                                            <p class="text-xs mt-0.5"><?= e($doc['rejection_reason']) ?></p>
                                        </div>
                                    <?php elseif ($isPending): ?>
                                        <p class="text-xs text-slate-600 mt-1"><?= t('student_doc.pending_note') ?></p>
                                    <?php endif; ?>
                                </div>

                                <!-- Dosyayı görüntüle -->
                                <a href="<?= url('ogrencim/belgeler/' . (int) $doc['id'] . '/indir') ?>" target="_blank"
                                   class="btn btn-ghost btn-icon flex-shrink-0"
                                   title="<?= t('student_doc.view_file') ?>" aria-label="<?= t('student_doc.view_file') ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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
    const label = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        label.textContent = <?= json_encode(t('student_doc.selected_file') . ': ', JSON_UNESCAPED_UNICODE) ?> + input.files[0].name;
        label.classList.remove('hidden');
    }
}
(function () {
    const zone = document.getElementById('drop-zone');
    const input = document.getElementById('doc-input');
    if (!zone || !input) return;
    ['dragenter', 'dragover'].forEach(function (ev) {
        zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.add('is-dragover'); });
    });
    ['dragleave', 'drop'].forEach(function (ev) {
        zone.addEventListener(ev, function () { zone.classList.remove('is-dragover'); });
    });
    zone.addEventListener('drop', function (e) {
        e.preventDefault();
        if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length) {
            input.files = e.dataTransfer.files;
            showFileName(input);
        }
    });
})();
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
