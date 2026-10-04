<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url('admin') ?>">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span aria-current="page">İşletmeler</span>
        </nav>
        <h1 class="page-title">İşletmeler</h1>
        <p class="page-desc">Toplam <?= count($venues) ?> işletme</p>
    </div>
    <div class="page-actions">
        <a href="<?= url('admin/isletmeler/yeni') ?>" class="btn btn-primary">
            + Yeni İşletme
        </a>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>İşletme Adı</th>
                <th>Kampüs</th>
                <th>Konum</th>
                <th>Durum</th>
                <th class="text-right">İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($venues)): ?>
            <tr><td colspan="6">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <p class="empty-state-title">Henüz işletme yok</p>
                    <p>Yeni işletme eklemek için aşağıdaki butonu kullanın.</p>
                    <a href="<?= url('admin/isletmeler/yeni') ?>" class="btn btn-primary btn-sm">+ Yeni İşletme Ekle</a>
                </div>
            </td></tr>
            <?php else: ?>
            <?php foreach ($venues as $venue): ?>
            <tr>
                <td class="text-slate-500"><?= e($venue['id']) ?></td>
                <td class="cell-strong"><?= e($venue['name']) ?></td>
                <td><?= e($venue['campus_name']) ?></td>
                <td><?= e($venue['location'] ?? '-') ?></td>
                <td>
                    <?php if ($venue['is_active']): ?>
                        <span class="badge badge-approved">Aktif</span>
                    <?php else: ?>
                        <span class="badge badge-expired">Pasif</span>
                    <?php endif; ?>
                </td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="<?= url('admin/isletmeler/' . $venue['id']) ?>"
                           class="btn btn-sm btn-outline">Detay</a>
                        <a href="<?= url('admin/isletmeler/' . $venue['id'] . '/duzenle') ?>"
                           class="btn btn-sm btn-ghost">Düzenle</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
