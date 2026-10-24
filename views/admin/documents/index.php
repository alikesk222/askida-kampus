<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Sayfa yolu">
            <a href="<?= url('admin') ?>">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span>Belge Doğrulama</span>
        </nav>
        <h1 class="page-title">Belge Doğrulama</h1>
        <p class="page-desc">Toplam <?= count($documents) ?> belge</p>
    </div>
    <?php if ($pending > 0): ?>
        <div class="page-actions">
            <span class="badge badge-pending"><?= $pending ?> belge inceleme bekliyor</span>
        </div>
    <?php endif; ?>
</div>

<?php if ($msg = flash('success')): ?>
    <div class="flash flash-success mb-4" role="status">
        <div class="flash-body"><?= e($msg) ?></div>
    </div>
<?php endif; ?>
<?php if ($msg = flash('error')): ?>
    <div class="flash flash-error mb-4" role="alert">
        <div class="flash-body"><?= e($msg) ?></div>
    </div>
<?php endif; ?>

<!-- Filtre tabları -->
<?php
$filter  = $_GET['durum'] ?? 'pending';
$filters = [
    'pending'  => ['label' => 'Bekleyen',    'count' => 0],
    'approved' => ['label' => 'Onaylanan',   'count' => 0],
    'rejected' => ['label' => 'Reddedilen',  'count' => 0],
    'all'      => ['label' => 'Tümü',        'count' => count($documents)],
];
foreach ($documents as $d) {
    if (isset($filters[$d['status']])) $filters[$d['status']]['count']++;
}
?>
<div class="flex gap-2 mb-5 flex-wrap">
    <?php foreach ($filters as $key => $f): ?>
        <a href="?durum=<?= $key ?>"
           class="btn btn-sm <?= $filter === $key ? 'btn-primary' : 'btn-outline' ?>"<?= $filter === $key ? ' aria-current="page"' : '' ?>>
            <?= $f['label'] ?>
            <span class="badge-count"><?= $f['count'] ?></span>
        </a>
    <?php endforeach; ?>
</div>

<?php
$filtered = array_values(array_filter($documents, fn($d) =>
    $filter === 'all' || $d['status'] === $filter
));
?>

<?php if (empty($filtered)): ?>
    <div class="card card-body">
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="empty-state-title">Bu filtrede belge yok.</p>
        </div>
    </div>
<?php else: ?>
    <div class="space-y-3">
        <?php foreach ($filtered as $doc): ?>
            <?php
                $isPending  = $doc['status'] === 'pending';
                $isApproved = $doc['status'] === 'approved';
                $isRejected = $doc['status'] === 'rejected';
            ?>
            <div class="card overflow-hidden">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-4">

                        <!-- Öğrenci bilgisi -->
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="icon-chip text-sm font-bold" aria-hidden="true">
                                <?= mb_strtoupper(mb_substr($doc['student_name'], 0, 1)) ?>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-slate-900 text-sm"><?= e($doc['student_name']) ?></p>
                                <p class="text-xs text-slate-500 truncate"><?= e($doc['student_email']) ?></p>
                                <p class="text-xs text-slate-500 mt-0.5"><?= format_date($doc['created_at']) ?></p>
                            </div>
                        </div>

                        <!-- Dosya -->
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <div class="icon-chip" aria-hidden="true">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <a href="<?= url('admin/belgeler/' . (int) $doc['id'] . '/indir') ?>" target="_blank" rel="noopener"
                                   class="link text-sm font-medium max-w-[180px] truncate block">
                                    <?= e($doc['file_name']) ?>
                                </a>
                                <a href="<?= url('admin/belgeler/' . (int) $doc['id'] . '/indir') ?>" target="_blank" rel="noopener"
                                   class="link text-xs">
                                    Görüntüle →
                                </a>
                            </div>
                        </div>

                        <!-- Durum / İşlem -->
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <?php if ($isPending): ?>
                                <!-- Onayla -->
                                <form method="POST" action="<?= url('admin/belgeler/' . $doc['id'] . '/incele') ?>"
                                      onsubmit="return confirm('Bu belgeyi onaylamak istiyor musunuz?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Onayla
                                    </button>
                                </form>
                                <!-- Reddet -->
                                <button type="button"
                                        onclick="toggleRejectForm(<?= $doc['id'] ?>)"
                                        class="btn btn-sm btn-danger-ghost">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Reddet
                                </button>

                            <?php elseif ($isApproved): ?>
                                <div>
                                    <?= status_badge('approved') ?>
                                    <p class="text-xs text-slate-500 mt-1"><?= e($doc['reviewer_name'] ?? '') ?></p>
                                </div>

                            <?php else: ?>
                                <div>
                                    <?= status_badge('rejected') ?>
                                    <p class="text-xs text-slate-500 mt-1"><?= e($doc['reviewer_name'] ?? '') ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Red formu (açılır) -->
                    <?php if ($isPending): ?>
                        <div id="reject-form-<?= $doc['id'] ?>" class="hidden mt-4 pt-4 border-t border-slate-200">
                            <form method="POST" action="<?= url('admin/belgeler/' . $doc['id'] . '/incele') ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="reject">
                                <label class="form-label">Red Sebebi</label>
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <textarea name="rejection_reason" rows="2" required
                                              placeholder="Öğrenciye iletilecek red sebebini yazın..."
                                              class="form-textarea flex-1 resize-none"></textarea>
                                    <button type="submit" class="btn btn-danger self-end">
                                        Gönder
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <!-- Red sebebi gösterimi -->
                    <?php if ($isRejected && $doc['rejection_reason']): ?>
                        <div class="mt-3 pt-3 border-t border-slate-200">
                            <p class="text-xs font-semibold text-slate-700 mb-0.5">Red sebebi:</p>
                            <p class="text-xs text-slate-600"><?= e($doc['rejection_reason']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
function toggleRejectForm(id) {
    const el = document.getElementById('reject-form-' + id);
    if (el) el.classList.toggle('hidden');
}
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
