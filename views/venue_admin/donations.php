<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <a href="<?= url('isletme') ?>" class="text-[#00A3B4] text-sm hover:underline">← Dashboard</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Bağışlar</h1>
    <p class="text-gray-500 text-sm mt-1">Toplam <?= $total ?> bağış</p>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">#</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Bağışçı</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Tutar</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Durum</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Tarih</th>
                <th class="px-5 py-3 text-right font-semibold text-gray-600">İşlem</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($donations)): ?>
            <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">Bağış bulunamadı.</td></tr>
            <?php else: ?>
            <?php foreach ($donations as $d): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 text-gray-400"><?= e($d['id']) ?></td>
                <td class="px-5 py-3">
                    <p class="font-medium text-gray-800"><?= e($d['donor_name']) ?></p>
                    <p class="text-xs text-gray-400"><?= e($d['donor_email']) ?></p>
                </td>
                <td class="px-5 py-3 font-semibold text-gray-800">₺<?= number_format($d['total_amount'], 2, ',', '.') ?></td>
                <td class="px-5 py-3"><?= status_badge($d['status']) ?></td>
                <td class="px-5 py-3 text-xs text-gray-500"><?= format_date($d['created_at']) ?></td>
                <td class="px-5 py-3 text-right">
                    <?php if ($d['status'] === 'waiting_approval'): ?>
                    <form method="POST" action="<?= url('isletme/bagislar/' . $d['id'] . '/onayla') ?>" class="inline">
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

<?php $totalPages = (int)ceil($total / 20); ?>
<?php if ($totalPages > 1): ?>
<div class="flex justify-center gap-2 mt-6">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?sayfa=<?= $i ?>"
       class="px-3 py-1.5 rounded text-sm <?= $i === $page ? 'bg-[#00A3B4] text-white' : 'bg-white border border-gray-300 text-gray-600 hover:bg-gray-50' ?>">
        <?= $i ?>
    </a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
