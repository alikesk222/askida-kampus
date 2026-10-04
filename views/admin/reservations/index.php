<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Sayfa yolu">
            <a href="<?= url('admin') ?>">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span>Rezervasyonlar</span>
        </nav>
        <h1 class="page-title">Rezervasyonlar</h1>
        <p class="page-desc">Toplam <?= $total ?> rezervasyon</p>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Öğrenci</th>
                <th>İşletme</th>
                <th>Alınacak Ürünler</th>
                <th>Kod</th>
                <th>Durum</th>
                <th>Son Kullanma</th>
                <th>Oluşturulma</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reservations)): ?>
                <tr><td colspan="8">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <p class="empty-state-title">Rezervasyon bulunamadı</p>
                        <p>Henüz sistemde rezervasyon kaydı bulunmamaktadır.</p>
                    </div>
                </td></tr>
            <?php else: ?>
                <?php foreach ($reservations as $r): ?>
                    <tr>
                        <td class="text-slate-500"><?= e($r['id']) ?></td>
                        <td>
                            <p class="cell-strong"><?= e($r['student_name']) ?></p>
                            <p class="text-xs text-slate-500"><?= e($r['student_email']) ?></p>
                        </td>
                        <td><?= e($r['venue_name']) ?></td>
                        <td>
                            <?php if (!empty($r['items_summary'])): ?>
                                <div class="flex flex-wrap gap-1">
                                    <?php foreach (explode(', ', $r['items_summary']) as $item): ?>
                                        <span class="badge badge-plain bg-navy-50 text-navy-800"><?= e($item) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-slate-400 text-xs">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="font-mono font-bold text-slate-700 tracking-wider"><?= e($r['claim_code']) ?></td>
                        <td><?= status_badge($r['status']) ?></td>
                        <td class="text-xs text-slate-500"><?= format_date($r['expires_at']) ?></td>
                        <td class="text-xs text-slate-500"><?= format_date($r['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Sayfalama -->
<?php $totalPages = (int) ceil($total / 20); ?>
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
