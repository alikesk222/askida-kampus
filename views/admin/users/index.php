<?php include ROOT . '/views/layout/header.php'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-2">
            <a href="<?= url('admin') ?>" class="hover:text-[#00A3B4] transition">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium">Kullanıcılar</span>
        </nav>
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
                <th class="px-5 py-3 text-left font-semibold text-gray-600">İşletme Ataması</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Hf. Limit</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Durum</th>
                <th class="px-5 py-3 text-left font-semibold text-gray-600">Kayıt</th>
                <th class="px-5 py-3 text-right font-semibold text-gray-600">İşlem</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($users)): ?>
                <tr><td colspan="9" class="px-5 py-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium text-sm">Kullanıcı bulunamadı</p>
                        <p class="text-gray-400 text-xs">Arama kriterlerinize uygun kullanıcı yok.</p>
                    </div>
                </td></tr>
            <?php else: ?>
                <?php foreach ($users as $u): ?>
                    <tr class="even:bg-gray-50/50 hover:bg-[#E0F7FA]/50 transition-colors">
                        <td class="px-5 py-3 text-gray-400"><?= e($u['id']) ?></td>
                        <td class="px-5 py-3 font-medium text-gray-800"><?= e($u['name']) ?></td>
                        <td class="px-5 py-3 text-gray-500"><?= e($u['email']) ?></td>
                        <td class="px-5 py-3">
                            <?php
                            $roleLabels = [
                                'super-admin' => ['bg-purple-100 text-purple-700', 'Süper Admin'],
                                'university-admin' => ['bg-blue-100 text-blue-700', 'Üniversite Admin'],
                                'venue-admin' => ['bg-teal-100 text-teal-700', 'İşletme Yöneticisi'],
                                'student' => ['bg-green-100 text-green-700', 'Öğrenci'],
                                'donor' => ['bg-orange-100 text-orange-700', 'Bağışçı'],
                            ];
                            [$cls, $label] = $roleLabels[$u['role']] ?? ['bg-gray-100 text-gray-600', $u['role']];
                            ?>
                            <span class="px-2 py-0.5 <?= $cls ?> rounded-full text-xs font-medium">
                                <?= $label ?>
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <?php if ($u['role'] === 'venue-admin'): ?>
                                <?php
                                $assignedVenueId = $venueAssignments[$u['id']] ?? null;
                                $assignedVenueName = '';
                                if ($assignedVenueId) {
                                    foreach ($venues as $v) {
                                        if ((int) $v['id'] === $assignedVenueId) {
                                            $assignedVenueName = $v['name'];
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <button
                                    onclick="openAssignModal(<?= $u['id'] ?>, '<?= e($u['name']) ?>', <?= $assignedVenueId ?? 'null' ?>)"
                                    class="flex items-center gap-1 text-xs <?= $assignedVenueName ? 'text-teal-600 font-medium' : 'text-yellow-600' ?> hover:underline">
                                    <?php if ($assignedVenueName): ?>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <?= e($assignedVenueName) ?>
                                    <?php else: ?>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        İşletme Ata
                                    <?php endif; ?>
                                </button>
                            <?php else: ?>
                                <span class="text-xs text-gray-400">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3">
                            <?php if ($u['role'] === 'student'): ?>
                                <?php $wl = $u['weekly_limit']; ?>
                                <button onclick="openWeeklyLimitModal(<?= $u['id'] ?>, '<?= e($u['name']) ?>', <?= $wl !== null ? (int)$wl : 'null' ?>)"
                                        class="flex items-center gap-1 text-xs hover:underline <?= $wl !== null ? 'text-[#00A3B4] font-semibold' : 'text-gray-400' ?>">
                                    <?php if ($wl !== null): ?>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <?= (int)$wl ?>
                                    <?php else: ?>
                                        Genel (<?= $globalWeeklyLimit ?>)
                                    <?php endif; ?>
                                </button>
                            <?php else: ?>
                                <span class="text-xs text-gray-300">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3">
                            <?= $u['is_active']
                                ? '<span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Aktif</span>'
                                : '<span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">Pasif</span>' ?>
                        </td>
                        <td class="px-5 py-3 text-gray-400 text-xs"><?= format_date($u['created_at'], 'd.m.Y') ?></td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <button onclick='openEditModal(<?= htmlspecialchars(json_encode([
                                    "id"             => (int)$u["id"],
                                    "name"           => $u["name"],
                                    "email"          => $u["email"],
                                    "role"           => $u["role"],
                                    "weekly_limit"   => $u["weekly_limit"] !== null ? (int)$u["weekly_limit"] : null,
                                    "student_number" => $u["student_number"] ?? "",
                                    "is_active"      => (bool)$u["is_active"],
                                ]), ENT_QUOTES) ?>)'
                                        class="text-xs text-[#00A3B4] hover:underline font-medium">
                                    Düzenle
                                </button>
                                <form method="POST" action="<?= url('admin/kullanicilar/' . $u['id'] . '/toggle') ?>" class="inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" data-confirm="Kullanıcı durumu değiştirilsin mi?"
                                        class="text-xs <?= $u['is_active'] ? 'text-red-500 hover:underline' : 'text-green-500 hover:underline' ?>">
                                        <?= $u['is_active'] ? 'Pasif Yap' : 'Aktif Yap' ?>
                                    </button>
                                </form>
                            </div>
                        </td>
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

<!-- Kullanıcı Düzenle Modal -->
<div id="modal-edit-user" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white z-10">
            <h3 class="font-semibold text-gray-800">Kullanıcı Düzenle</h3>
            <button onclick="document.getElementById('modal-edit-user').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>
        <form id="edit-user-form" method="POST" action="" class="p-6">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-4">

                <div class="col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Ad Soyad *</label>
                    <input type="text" name="name" id="edit-name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">E-posta *</label>
                    <input type="email" name="email" id="edit-email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Yeni Şifre</label>
                    <input type="password" name="password" id="edit-password" placeholder="Değiştirmek için doldurun"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Rol *</label>
                    <select name="role" id="edit-role" required onchange="editToggleStudentFields(this.value)"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                        <option value="student">Öğrenci</option>
                        <option value="donor">Bağışçı</option>
                        <option value="venue-admin">İşletme Yöneticisi</option>
                        <option value="university-admin">Üniversite Admin</option>
                        <?php if (auth()['role'] === 'super-admin'): ?>
                            <option value="super-admin">Süper Admin</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div id="edit-student-number-field">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Öğrenci No</label>
                    <input type="text" name="student_number" id="edit-student-number"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                </div>

                <div id="edit-weekly-limit-field" class="col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        Haftalık Rezervasyon Limiti
                        <span class="text-gray-400 font-normal">(boş = genel ayar: <?= $globalWeeklyLimit ?>)</span>
                    </label>
                    <input type="number" name="weekly_limit" id="edit-weekly-limit" min="1" max="50"
                           placeholder="<?= $globalWeeklyLimit ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                    <p class="text-xs text-gray-400 mt-1">Boş bırakırsanız tüm öğrencilere uygulanan genel limit geçerli olur.</p>
                </div>

                <div class="col-span-2 flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_active" id="edit-is-active" value="1"
                        class="w-4 h-4 rounded border-gray-300 text-[#00A3B4] focus:ring-[#00A3B4]">
                    <label for="edit-is-active" class="text-sm font-medium text-gray-700">Hesap Aktif</label>
                </div>

            </div>
            <div class="mt-5 flex gap-3">
                <button type="submit"
                    class="flex-1 py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
                    Kaydet
                </button>
                <button type="button" onclick="document.getElementById('modal-edit-user').classList.add('hidden')"
                    class="flex-1 py-2 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    İptal
                </button>
            </div>
        </form>
    </div>
</div>

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
                    <select name="role" required id="role-select" onchange="toggleVenueField(this.value)"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                        <option value="student">Öğrenci</option>
                        <option value="donor">Bağışçı</option>
                        <option value="venue-admin">İşletme Yöneticisi</option>
                        <option value="university-admin">Üniversite Admin</option>
                        <?php if (auth()['role'] === 'super-admin'): ?>
                            <option value="super-admin">Süper Admin</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div id="venue-field" style="display:none">
                    <label class="block text-xs font-medium text-gray-700 mb-1">İşletme <span
                            class="text-red-500">*</span></label>
                    <select name="venue_id" id="venue-select"
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

<!-- Haftalık Limit Modal -->
<div id="modal-weekly-limit" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Haftalık Rezervasyon Limiti</h3>
            <button onclick="document.getElementById('modal-weekly-limit').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>
        <form id="weekly-limit-form" method="POST" action="" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <p class="text-sm text-gray-600">
                <span class="font-semibold" id="wl-user-name"></span> adlı öğrencinin haftalık rezervasyon limiti.
            </p>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">
                    Haftalık Limit
                    <span class="text-gray-400 font-normal">(boş bırakırsanız genel ayar uygulanır: <?= $globalWeeklyLimit ?>)</span>
                </label>
                <input type="number" name="weekly_limit" id="wl-input" min="1" max="50" placeholder="<?= $globalWeeklyLimit ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
            </div>
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
                    Kaydet
                </button>
                <button type="button" id="wl-reset-btn"
                    class="py-2 px-3 border border-gray-300 text-gray-500 hover:bg-gray-50 rounded-lg text-sm transition"
                    title="Genel ayara döndür">
                    Genel Ayara Dön
                </button>
                <button type="button" onclick="document.getElementById('modal-weekly-limit').classList.add('hidden')"
                    class="py-2 px-3 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    İptal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- İşletme Ata Modal -->
<div id="modal-assign-venue" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">İşletme Ata</h3>
            <button onclick="document.getElementById('modal-assign-venue').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>
        <form id="assign-venue-form" method="POST" action="" class="p-6">
            <?= csrf_field() ?>
            <p class="text-sm text-gray-600 mb-4">
                <span class="font-semibold" id="assign-user-name"></span> adlı kullanıcıya işletme atayın.
            </p>
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-700 mb-1">İşletme *</label>
                <select name="venue_id" id="assign-venue-select" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#00A3B4]">
                    <option value="">Seçiniz...</option>
                    <?php foreach ($venues as $v): ?>
                        <option value="<?= e($v['id']) ?>"><?= e($v['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 py-2 bg-[#00A3B4] hover:bg-[#007A8A] text-white rounded-lg text-sm font-medium transition">
                    Ata
                </button>
                <button type="button" onclick="document.getElementById('modal-assign-venue').classList.add('hidden')"
                    class="flex-1 py-2 border border-gray-300 text-gray-600 hover:bg-gray-50 rounded-lg text-sm transition">
                    İptal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleVenueField(role) {
        const field = document.getElementById('venue-field');
        const select = document.getElementById('venue-select');
        if (role === 'venue-admin') {
            field.style.display = 'block';
            select.required = true;
        } else {
            field.style.display = 'none';
            select.required = false;
        }
    }

    function editToggleStudentFields(role) {
        const isStudent = role === 'student';
        document.getElementById('edit-student-number-field').style.display = isStudent ? 'block' : 'none';
        document.getElementById('edit-weekly-limit-field').style.display   = isStudent ? 'block' : 'none';
    }

    function openEditModal(u) {
        document.getElementById('edit-user-form').action =
            '<?= url('admin/kullanicilar') ?>/' + u.id + '/duzenle';

        document.getElementById('edit-name').value           = u.name;
        document.getElementById('edit-email').value          = u.email;
        document.getElementById('edit-password').value       = '';
        document.getElementById('edit-role').value           = u.role;
        document.getElementById('edit-student-number').value = u.student_number || '';
        document.getElementById('edit-weekly-limit').value   = u.weekly_limit !== null ? u.weekly_limit : '';
        document.getElementById('edit-is-active').checked    = u.is_active;

        editToggleStudentFields(u.role);
        document.getElementById('modal-edit-user').classList.remove('hidden');
    }

    function openWeeklyLimitModal(userId, userName, currentLimit) {
        document.getElementById('wl-user-name').textContent = userName;
        document.getElementById('weekly-limit-form').action = '<?= url('admin/kullanicilar') ?>/' + userId + '/haftalik-limit';
        const input = document.getElementById('wl-input');
        input.value = (currentLimit !== null && currentLimit !== undefined) ? currentLimit : '';

        document.getElementById('wl-reset-btn').onclick = function() {
            input.value = '';
        };

        document.getElementById('modal-weekly-limit').classList.remove('hidden');
    }

    function openAssignModal(userId, userName, currentVenueId) {
        document.getElementById('assign-user-name').textContent = userName;
        document.getElementById('assign-venue-form').action = '<?= url('admin/kullanicilar') ?>/' + userId + '/ata';
        const sel = document.getElementById('assign-venue-select');
        if (currentVenueId) {
            sel.value = currentVenueId;
        } else {
            sel.value = '';
        }
        document.getElementById('modal-assign-venue').classList.remove('hidden');
    }

    // Modal hata varsa otomatik aç
    <?php if (!empty($errors)): ?>
        document.getElementById('modal-add-user').classList.remove('hidden');
    <?php endif; ?>
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>