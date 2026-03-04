<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Rezervasyonlar</h1>
    <p class="text-gray-500 text-sm mt-1">Toplam <?= $total ?> rezervasyon</p>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">#</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Öğrenci</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">İşletme</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Alınacak Ürünler</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Kod</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Durum</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Son Kullanma</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Oluşturulma</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($reservations)): ?>
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-gray-400">Rezervasyon bulunamadı.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($reservations as $r): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-400"><?= e($r['id']) ?></td>
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-800"><?= e($r['student_name']) ?></p>
                            <p class="text-xs text-gray-400"><?= e($r['student_email']) ?></p>
                        </td>
                        <td class="px-5 py-3 text-gray-600"><?= e($r['venue_name']) ?></td>
                        <td class="px-5 py-3">
                            <?php if (!empty($r['items_summary'])): ?>
                                <div class="flex flex-wrap gap-1">
                                    <?php foreach (explode(', ', $r['items_summary']) as $item): ?>
                                        <span
                                            class="inline-block bg-[#E0F7FA] text-[#006B76] text-xs px-2 py-0.5 rounded-full font-medium"><?= e($item) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-400 text-xs">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3 font-mono font-bold text-gray-700 tracking-wider"><?= e($r['claim_code']) ?></td>
                        <td class="px-5 py-3"><?= status_badge($r['status']) ?></td>
                        <td class="px-5 py-3 text-xs text-gray-500"><?= format_date($r['expires_at']) ?></td>
                        <td class="px-5 py-3 text-xs text-gray-500"><?= format_date($r['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Sayfalama -->
<?php $totalPages = (int) ceil($total / 20); ?>
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