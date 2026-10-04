<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Sayfa yolu">
            <a href="<?= url('isletme') ?>">Dashboard</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">Katkılar</span>
        </nav>
        <h1 class="page-title">Katkılar</h1>
        <p class="page-desc">Toplam <?= $total ?> katkı</p>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Katkı Sağlayan</th>
                    <th>Tutar</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th class="text-right">İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($donations)): ?>
                <tr><td colspan="6">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="empty-state-title">Henüz katkı yok</p>
                        <p>Bu işletmeye ait katkı kaydı bulunmamaktadır.</p>
                    </div>
                </td></tr>
                <?php else: ?>
                <?php foreach ($donations as $d): ?>
                <tr>
                    <td class="text-slate-500"><?= e($d['id']) ?></td>
                    <td>
                        <p class="cell-strong"><?= e($d['donor_name']) ?></p>
                        <p class="text-xs text-slate-500"><?= e($d['donor_email']) ?></p>
                    </td>
                    <td class="cell-strong">₺<?= number_format($d['total_amount'], 2, ',', '.') ?></td>
                    <td><?= status_badge($d['status']) ?></td>
                    <td class="text-xs text-slate-500"><?= format_date($d['created_at']) ?></td>
                    <td class="text-right">
                        <?php if ($d['status'] === 'waiting_approval'): ?>
                        <form method="POST" action="<?= url('isletme/bagislar/' . $d['id'] . '/onayla') ?>" class="inline">
                            <?= csrf_field() ?>
                            <button type="submit" data-confirm="Bu katkıyı onaylamak istiyor musunuz?"
                                class="btn btn-success btn-sm">
                                Onayla
                            </button>
                        </form>
                        <?php else: ?>
                        <span class="text-slate-400 text-xs">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $totalPages = (int)ceil($total / 20); ?>
<?php if ($totalPages > 1): ?>
<div class="flex flex-wrap justify-center gap-2 mt-6">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?sayfa=<?= $i ?>"
       class="btn btn-sm <?= $i === $page ? 'btn-primary' : 'btn-outline' ?>"<?= $i === $page ? ' aria-current="page"' : '' ?>>
        <?= $i ?>
    </a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
