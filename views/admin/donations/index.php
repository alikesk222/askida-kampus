<?php include ROOT . '/views/layout/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-2">
            <a href="<?= url('admin') ?>" class="hover:text-[#00A3B4] transition">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium">Bağışlar</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-800">Bağışlar</h1>
        <p class="text-gray-500 text-sm mt-1">Toplam <?= $total ?> kayıt</p>
    </div>
    <!-- Filtre -->
    <form method="GET" action="<?= url('admin/bagislar') ?>" class="flex gap-2">
        <select name="durum" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
            <option value="">Tümü</option>
            <option value="waiting_approval" <?= ($status ?? '') === 'waiting_approval' ? 'selected' : '' ?>>Onay Bekliyor</option>
            <option value="paid"             <?= ($status ?? '') === 'paid'             ? 'selected' : '' ?>>Ödendi</option>
            <option value="failed"           <?= ($status ?? '') === 'failed'           ? 'selected' : '' ?>>Başarısız</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm transition">Filtrele</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">#</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Bağışçı</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">İşletme</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Tutar</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Durum</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Tarih</th>
                <th class="px-5 py-3 text-right font-semibold text-gray-600">İşlem</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($donations)): ?>
            <tr><td colspan="7" class="px-5 py-16 text-center">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium text-sm">Henüz bağış yok</p>
                    <p class="text-gray-400 text-xs">Sisteme kayıtlı bağış bulunmamaktadır.</p>
                </div>
            </td></tr>
            <?php else: ?>
            <?php foreach ($donations as $d): ?>
            <tr class="even:bg-gray-50/50 hover:bg-[#E0F7FA]/50 transition-colors">
                <td class="px-5 py-3 text-gray-400"><?= e($d['id']) ?></td>
                <td class="px-5 py-3">
                    <p class="font-medium text-gray-800"><?= e($d['donor_name']) ?></p>
                    <p class="text-xs text-gray-400"><?= e($d['donor_email']) ?></p>
                </td>
                <td class="px-5 py-3 text-gray-600"><?= e($d['venue_name']) ?></td>
                <td class="px-5 py-3 font-semibold text-gray-800">₺<?= number_format($d['total_amount'], 2, ',', '.') ?></td>
                <td class="px-5 py-3"><?= status_badge($d['status']) ?></td>
                <td class="px-5 py-3 text-gray-500 text-xs"><?= format_date($d['created_at']) ?></td>
                <td class="px-5 py-3 text-right">
                    <?php if ($d['status'] === 'waiting_approval'): ?>
                    <form method="POST" action="<?= url('admin/bagislar/' . $d['id'] . '/onayla') ?>" class="inline">
                        <?= csrf_field() ?>
                        <button type="submit" data-confirm="Bu bağışı onaylamak istiyor musunuz?"
                            class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-medium transition">
                            Onayla
                        </button>
                    </form>
                    <?php else: ?>
                    <span class="text-gray-300 text-xs">—</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Sayfalama -->
<?php $totalPages = (int)ceil($total / 20); ?>
<?php if ($totalPages > 1): ?>
<div class="flex justify-center gap-2 mt-6">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?sayfa=<?= $i ?><?= $status ? '&durum=' . urlencode($status) : '' ?>"
       class="px-3 py-1.5 rounded text-sm <?= $i === $page ? 'bg-[#00A3B4] text-white' : 'bg-white border border-gray-300 text-gray-600 hover:bg-gray-50' ?>">
        <?= $i ?>
    </a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
