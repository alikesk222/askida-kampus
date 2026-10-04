<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Sayfa yolu">
            <a href="<?= url('admin') ?>">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span>SSS</span>
        </nav>
        <h1 class="page-title">SSS Yönetimi</h1>
        <p class="page-desc">Sık sorulan soruları yönetin</p>
    </div>
    <div class="page-actions">
        <a href="<?= url('admin/sss/yeni') ?>" class="btn btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Yeni Soru Ekle
        </a>
    </div>
</div>

<?php
$cats = [
    'donors'   => ['label' => 'Katkı Sağlayanlar', 'color' => 'badge-gold-soft'],
    'students' => ['label' => 'Öğrenciler',  'color' => 'bg-navy-100 text-navy-800'],
    'general'  => ['label' => 'Genel',        'color' => 'bg-slate-100 text-slate-700'],
];
$grouped = [];
foreach ($items as $it) { $grouped[$it['category']][] = $it; }
?>

<?php foreach ($cats as $catKey => $catInfo): ?>
<?php if (empty($grouped[$catKey])): continue; endif; ?>
<div class="mb-8">
    <div class="flex items-center gap-3 mb-3">
        <span class="badge badge-plain <?= $catInfo['color'] ?>"><?= $catInfo['label'] ?></span>
        <span class="text-xs text-slate-500"><?= count($grouped[$catKey]) ?> soru</span>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Soru (TR)</th>
                    <th class="text-center w-20">Sıra</th>
                    <th class="text-center w-24">Durum</th>
                    <th class="text-right w-36">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grouped[$catKey] as $item): ?>
                <tr>
                    <td class="cell-strong"><?= e($item['question_tr']) ?></td>
                    <td class="text-center text-slate-500"><?= (int)$item['sort_order'] ?></td>
                    <td class="text-center">
                        <form method="POST" action="<?= url('admin/sss/' . $item['id'] . '/toggle') ?>">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-ghost" title="Durumu değiştir">
                                <span class="badge <?= $item['is_active'] ? 'badge-active' : 'badge-muted' ?>"><?= $item['is_active'] ? 'Aktif' : 'Pasif' ?></span>
                            </button>
                        </form>
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= url('admin/sss/' . $item['id'] . '/duzenle') ?>"
                               class="btn btn-sm btn-outline">
                                Düzenle
                            </a>
                            <form method="POST" action="<?= url('admin/sss/' . $item['id'] . '/sil') ?>"
                                  onsubmit="return confirm('Bu soruyu silmek istediğinizden emin misiniz?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger-ghost">
                                    Sil
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endforeach; ?>

<?php if (empty($items)): ?>
<div class="card card-body">
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="empty-state-title">Henüz SSS sorusu eklenmemiş.</p>
        <a href="<?= url('admin/sss/yeni') ?>" class="link font-semibold">İlk soruyu ekle →</a>
    </div>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
