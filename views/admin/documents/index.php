<?php include ROOT . '/views/layout/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-2">
            <a href="<?= url('admin') ?>" class="hover:text-[#00A3B4] transition">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 font-medium">Belge Doğrulama</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-800">Belge Doğrulama</h1>
        <p class="text-gray-500 text-sm mt-1">Toplam <?= count($documents) ?> belge</p>
    </div>
    <?php if ($pending > 0): ?>
        <div class="flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl px-4 py-2.5">
            <div class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></div>
            <span class="text-sm font-semibold"><?= $pending ?> belge inceleme bekliyor</span>
        </div>
    <?php endif; ?>
</div>

<?php if ($msg = flash('success')): ?>
    <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm font-medium">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <?= e($msg) ?>
    </div>
<?php endif; ?>
<?php if ($msg = flash('error')): ?>
    <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm font-medium">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <?= e($msg) ?>
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
           class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-semibold transition
               <?= $filter === $key
                   ? 'bg-[#00A3B4] text-white shadow-sm'
                   : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' ?>">
            <?= $f['label'] ?>
            <span class="text-xs px-1.5 py-0.5 rounded-full
                <?= $filter === $key ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' ?>">
                <?= $f['count'] ?>
            </span>
        </a>
    <?php endforeach; ?>
</div>

<?php
$filtered = array_values(array_filter($documents, fn($d) =>
    $filter === 'all' || $d['status'] === $filter
));
?>

<?php if (empty($filtered)): ?>
    <div class="bg-white rounded-xl shadow-sm p-14 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <p class="text-gray-400 text-sm">Bu filtrede belge yok.</p>
    </div>
<?php else: ?>
    <div class="space-y-3">
        <?php foreach ($filtered as $doc): ?>
            <?php
                $isPending  = $doc['status'] === 'pending';
                $isApproved = $doc['status'] === 'approved';
                $isRejected = $doc['status'] === 'rejected';
                $borderColor = $isPending ? 'border-amber-300' : ($isApproved ? 'border-green-300' : 'border-red-300');
            ?>
            <div class="bg-white rounded-xl shadow-sm border-l-4 <?= $borderColor ?> overflow-hidden">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-4">

                        <!-- Öğrenci bilgisi -->
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0
                                text-sm font-bold text-gray-500">
                                <?= mb_strtoupper(mb_substr($doc['student_name'], 0, 1)) ?>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 text-sm"><?= e($doc['student_name']) ?></p>
                                <p class="text-xs text-gray-400 truncate"><?= e($doc['student_email']) ?></p>
                                <p class="text-xs text-gray-400 mt-0.5"><?= format_date($doc['created_at']) ?></p>
                            </div>
                        </div>

                        <!-- Dosya -->
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <div class="w-9 h-9 bg-[#E0F7FA] rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#00A3B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <a href="<?= asset($doc['file_path']) ?>" target="_blank"
                                   class="text-sm font-medium text-[#00A3B4] hover:underline max-w-[180px] truncate block">
                                    <?= e($doc['file_name']) ?>
                                </a>
                                <a href="<?= asset($doc['file_path']) ?>" target="_blank"
                                   class="text-xs text-gray-400 hover:text-[#00A3B4] transition">
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
                                    <button type="submit"
                                            class="flex items-center gap-1.5 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-semibold transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Onayla
                                    </button>
                                </form>
                                <!-- Reddet -->
                                <button type="button"
                                        onclick="toggleRejectForm(<?= $doc['id'] ?>)"
                                        class="flex items-center gap-1.5 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg text-xs font-semibold transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Reddet
                                </button>

                            <?php elseif ($isApproved): ?>
                                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-green-50 border border-green-200 rounded-lg">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-semibold text-green-700">Onaylandı</p>
                                        <p class="text-xs text-green-500"><?= e($doc['reviewer_name'] ?? '') ?></p>
                                    </div>
                                </div>

                            <?php else: ?>
                                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 border border-red-200 rounded-lg">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-semibold text-red-600">Reddedildi</p>
                                        <p class="text-xs text-red-400"><?= e($doc['reviewer_name'] ?? '') ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Red formu (açılır) -->
                    <?php if ($isPending): ?>
                        <div id="reject-form-<?= $doc['id'] ?>" style="display:none;" class="mt-4 pt-4 border-t border-gray-100">
                            <form method="POST" action="<?= url('admin/belgeler/' . $doc['id'] . '/incele') ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="reject">
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Red Sebebi</label>
                                <div class="flex gap-2">
                                    <textarea name="rejection_reason" rows="2" required
                                              placeholder="Öğrenciye iletilecek red sebebini yazın..."
                                              class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-300 resize-none"></textarea>
                                    <button type="submit"
                                            class="flex-shrink-0 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-semibold transition self-end">
                                        Gönder
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <!-- Red sebebi gösterimi -->
                    <?php if ($isRejected && $doc['rejection_reason']): ?>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs font-semibold text-red-600 mb-0.5">Red sebebi:</p>
                            <p class="text-xs text-red-500"><?= e($doc['rejection_reason']) ?></p>
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
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
