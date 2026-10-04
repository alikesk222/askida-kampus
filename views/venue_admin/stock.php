<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Sayfa yolu">
            <a href="<?= url('isletme') ?>">Dashboard</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">Stok Durumu</span>
        </nav>
        <h1 class="page-title">Stok Durumu</h1>
        <p class="page-desc"><?= e($venue['name'] ?? '') ?></p>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Ürün</th>
                    <th>Kategori</th>
                    <th>Fiyat</th>
                    <th class="text-center">Toplam Stok</th>
                    <th class="text-center">Rezerve</th>
                    <th class="text-center">Serbest</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($stocks)): ?>
                <tr><td colspan="6">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <p class="empty-state-title">Stok bulunamadı</p>
                        <p>Bu işletmede henüz stok kaydı oluşturulmamış.</p>
                    </div>
                </td></tr>
                <?php else: ?>
                <?php foreach ($stocks as $s): ?>
                <tr>
                    <td class="cell-strong"><?= e($s['product_name']) ?></td>
                    <td class="text-slate-500"><?= e($s['category'] ?? '-') ?></td>
                    <td class="text-slate-700">₺<?= number_format($s['price_snapshot'], 2, ',', '.') ?></td>
                    <td class="text-center font-semibold text-slate-700"><?= e($s['available_quantity']) ?></td>
                    <td class="text-center text-slate-600 font-medium"><?= e($s['reserved_quantity']) ?></td>
                    <td class="text-center">
                        <span class="badge <?= (int)$s['free_quantity'] > 0 ? 'badge-approved' : 'badge-rejected' ?>">
                            <?= e($s['free_quantity']) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
