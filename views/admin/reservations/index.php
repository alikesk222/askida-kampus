<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-2">
        <a href="<?= url('admin') ?>" class="hover:text-[#00A3B4] transition">Dashboard</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-600 font-medium">Rezervasyonlar</span>
    </nav>
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
                <tr><td colspan="8" class="px-5 py-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium text-sm">Rezervasyon bulunamadı</p>
                        <p class="text-gray-400 text-xs">Henüz sistemde rezervasyon kaydı bulunmamaktadır.</p>
                    </div>
                </td></tr>
            <?php else: ?>
                <?php foreach ($reservations as $r): ?>
                    <tr class="even:bg-gray-50/50 hover:bg-[#E0F7FA]/50 transition-colors">
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