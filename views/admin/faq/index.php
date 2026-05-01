<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">SSS Yönetimi</h1>
        <p class="text-gray-500 text-sm mt-1">Sık sorulan soruları yönetin</p>
    </div>
    <a href="<?= url('admin/sss/yeni') ?>"
       class="inline-flex items-center gap-2 px-4 py-2 bg-[#00A3B4] text-white text-sm font-semibold rounded-lg hover:bg-[#007A8A] transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Yeni Soru Ekle
    </a>
</div>

<?php
$cats = [
    'donors'   => ['label' => 'Bağışçılar',  'color' => 'bg-teal-100 text-teal-800'],
    'students' => ['label' => 'Öğrenciler',  'color' => 'bg-blue-100 text-blue-800'],
    'general'  => ['label' => 'Genel',        'color' => 'bg-gray-100 text-gray-700'],
];
$grouped = [];
foreach ($items as $it) { $grouped[$it['category']][] = $it; }
?>

<?php foreach ($cats as $catKey => $catInfo): ?>
<?php if (empty($grouped[$catKey])): continue; endif; ?>
<div class="mb-8">
    <div class="flex items-center gap-3 mb-3">
        <span class="px-3 py-1 rounded-full text-xs font-bold <?= $catInfo['color'] ?>"><?= $catInfo['label'] ?></span>
        <span class="text-xs text-gray-400"><?= count($grouped[$catKey]) ?> soru</span>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Soru (TR)</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide w-20">Sıra</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide w-24">Durum</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide w-36">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($grouped[$catKey] as $item): ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-800 font-medium"><?= e($item['question_tr']) ?></td>
                    <td class="px-4 py-3 text-center text-gray-500"><?= (int)$item['sort_order'] ?></td>
                    <td class="px-4 py-3 text-center">
                        <form method="POST" action="<?= url('admin/sss/' . $item['id'] . '/toggle') ?>">
                            <?= csrf_field() ?>
                            <button type="submit"
                                    class="px-2 py-1 rounded-full text-xs font-semibold <?= $item['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
                                <?= $item['is_active'] ? 'Aktif' : 'Pasif' ?>
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= url('admin/sss/' . $item['id'] . '/duzenle') ?>"
                               class="px-3 py-1.5 text-xs font-semibold text-[#00A3B4] border border-[#00A3B4] rounded-lg hover:bg-[#e0f7fa] transition">
                                Düzenle
                            </a>
                            <form method="POST" action="<?= url('admin/sss/' . $item['id'] . '/sil') ?>"
                                  onsubmit="return confirm('Bu soruyu silmek istediğinizden emin misiniz?')">
                                <?= csrf_field() ?>
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-300 rounded-lg hover:bg-red-50 transition">
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
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <p class="text-gray-500 text-sm">Henüz SSS sorusu eklenmemiş.</p>
    <a href="<?= url('admin/sss/yeni') ?>" class="mt-4 inline-block text-sm text-[#00A3B4] font-semibold hover:underline">İlk soruyu ekle →</a>
</div>
<?php endif; ?>

<?php include ROOT . '/views/layout/footer.php'; ?>
