<?php include ROOT . '/views/layout/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kullanıcılar</h1>
        <p class="text-gray-500 text-sm mt-1">Toplam <?= $total ?> kullanıcı</p>
    </div>
    <button onclick="document.getElementById('modal-add-user').classList.remove('hidden')"
        class="px-4 py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
        + Kullanıcı Ekle
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">#</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Ad Soyad</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">E-posta</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Rol</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Öğrenci No</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Durum</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Kayıt</th>
                <th class="px-5 py-3 text-right font-semibold text-gray-600">İşlem</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($users)): ?>
            <tr><td colspan="8" class="px-5 py-10 text-center text-gray-400">Kullanıcı bulunamadı.</td></tr>
            <?php else: ?>
            <?php foreach ($users as $u): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 text-gray-400"><?= e($u['id']) ?></td>
                <td class="px-5 py-3 font-medium text-gray-800"><?= e($u['name']) ?></td>
                <td class="px-5 py-3 text-gray-500"><?= e($u['email']) ?></td>
                <td class="px-5 py-3">
                    <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium capitalize">
                        <?= e($u['role']) ?>
                    </span>
                </td>
                <td class="px-5 py-3 text-gray-500"><?= e($u['student_number'] ?? '-') ?></td>
                <td class="px-5 py-3">
                    <?= $u['is_active']
                        ? '<span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Aktif</span>'
                        : '<span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">Pasif</span>' ?>
                </td>
                <td class="px-5 py-3 text-gray-400 text-xs"><?= format_date($u['created_at'], 'd.m.Y') ?></td>
                <td class="px-5 py-3 text-right">
                    <form method="POST" action="<?= url('admin/kullanicilar/' . $u['id'] . '/toggle') ?>" class="inline">
                        <?= csrf_field() ?>
                        <button type="submit" data-confirm="Kullanıcı durumu değiştirilsin mi?"
                            class="text-xs <?= $u['is_active'] ? 'text-red-500 hover:underline' : 'text-green-500 hover:underline' ?>">
                            <?= $u['is_active'] ? 'Pasif Yap' : 'Aktif Yap' ?>
                        </button>
                    </form>
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
    <a href="?sayfa=<?= $i ?>"
       class="px-3 py-1.5 rounded text-sm <?= $i === $page ? 'bg-[#00A3B4] text-white' : 'bg-white border border-gray-300 text-gray-600 hover:bg-gray-50' ?>">
        <?= $i ?>
    </a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<!-- Kullanıcı Ekle Modal -->
<div id="modal-add-user" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Yeni Kullanıcı Ekle</h3>
            <button onclick="document.getElementById('modal-add-user').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>
        <form method="POST" action="<?= url('admin/kullanicilar/ekle') ?>" class="p-6">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Ad Soyad *</label>
                    <input type="text" name="name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                    <?= error_msg($errors, 'name') ?>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">E-posta *</label>
                    <input type="email" name="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                    <?= error_msg($errors, 'email') ?>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Şifre *</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                    <?= error_msg($errors, 'password') ?>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Rol *</label>
                    <select name="role" required id="role-select"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                        <option value="student">Öğrenci</option>
                        <option value="donor">Bağışçı</option>
                        <option value="venue-admin">İşletme Admin</option>
                        <option value="cashier">Kasiyer</option>
                        <option value="university-admin">Üniversite Admin</option>
                        <?php if (auth()['role'] === 'super-admin'): ?>
                        <option value="super-admin">Süper Admin</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div id="venue-field">
                    <label class="block text-xs font-medium text-gray-700 mb-1">İşletme</label>
                    <select name="venue_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                        <option value="">Seçiniz...</option>
                        <?php foreach ($venues as $v): ?>
                        <option value="<?= e($v['id']) ?>"><?= e($v['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Öğrenci No</label>
                    <input type="text" name="student_number"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Günlük Limit</label>
                    <input type="number" name="daily_limit" value="3" min="1" max="10"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>
            </div>
            <div class="mt-5 flex gap-3">
                <button type="submit"
                    class="flex-1 py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
                    Kaydet
                </button>
                <button type="button" onclick="document.getElementById('modal-add-user').classList.add('hidden')"
                    class="flex-1 py-2 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    İptal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal hata varsa otomatik aç
<?php if (!empty($errors)): ?>
document.getElementById('modal-add-user').classList.remove('hidden');
<?php endif; ?>
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
