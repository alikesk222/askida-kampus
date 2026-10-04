<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="<?= url('admin') ?>">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span aria-current="page">Kullanıcılar</span>
        </nav>
        <h1 class="page-title">Kullanıcılar</h1>
        <p class="page-desc">Toplam <?= $total ?> kullanıcı</p>
    </div>
    <div class="page-actions">
        <button type="button" onclick="document.getElementById('modal-add-user').classList.remove('hidden')"
            class="btn btn-primary">
            + Kullanıcı Ekle
        </button>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Ad Soyad</th>
                <th>E-posta</th>
                <th>Rol</th>
                <th>İşletme Ataması</th>
                <th>Hf. Limit</th>
                <th>Durum</th>
                <th>Kayıt</th>
                <th class="text-right">İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr><td colspan="9">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <p class="empty-state-title">Kullanıcı bulunamadı</p>
                        <p>Arama kriterlerinize uygun kullanıcı yok.</p>
                    </div>
                </td></tr>
            <?php else: ?>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="text-slate-500"><?= e($u['id']) ?></td>
                        <td class="cell-strong"><?= e($u['name']) ?></td>
                        <td><?= e($u['email']) ?></td>
                        <td>
                            <?php
                            $roleLabels = [
                                'super-admin' => ['badge-gold', 'Süper Admin'],
                                'university-admin' => ['badge-gold-soft', 'Üniversite Admin'],
                                'venue-admin' => ['badge-info', 'İşletme Yöneticisi'],
                                'student' => ['badge-muted', 'Öğrenci'],
                                'donor' => ['badge-plain', 'Katkı Sağlayan'],
                            ];
                            [$cls, $label] = $roleLabels[$u['role']] ?? ['badge-muted', $u['role']];
                            ?>
                            <span class="badge <?= $cls ?>">
                                <?= $label ?>
                            </span>
                        </td>
                        <td>
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
                                <button type="button"
                                    onclick="openAssignModal(<?= $u['id'] ?>, '<?= e($u['name']) ?>', <?= $assignedVenueId ?? 'null' ?>)"
                                    class="btn btn-sm <?= $assignedVenueName ? 'btn-ghost' : 'btn-outline' ?>">
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
                                <span class="text-slate-400">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($u['role'] === 'student'): ?>
                                <?php $wl = $u['weekly_limit']; ?>
                                <button type="button" onclick="openWeeklyLimitModal(<?= $u['id'] ?>, '<?= e($u['name']) ?>', <?= $wl !== null ? (int)$wl : 'null' ?>)"
                                        class="btn btn-sm <?= $wl !== null ? 'btn-outline' : 'btn-ghost' ?>">
                                    <?php if ($wl !== null): ?>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <?= (int)$wl ?>
                                    <?php else: ?>
                                        Genel (<?= $globalWeeklyLimit ?>)
                                    <?php endif; ?>
                                </button>
                            <?php else: ?>
                                <span class="text-slate-400">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $u['is_active']
                                ? '<span class="badge badge-approved">Aktif</span>'
                                : '<span class="badge badge-expired">Pasif</span>' ?>
                        </td>
                        <td class="text-sm text-slate-500"><?= format_date($u['created_at'], 'd.m.Y') ?></td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" onclick='openEditModal(<?= htmlspecialchars(json_encode([
                                    "id"             => (int)$u["id"],
                                    "name"           => $u["name"],
                                    "email"          => $u["email"],
                                    "role"           => $u["role"],
                                    "weekly_limit"   => $u["weekly_limit"] !== null ? (int)$u["weekly_limit"] : null,
                                    "student_number" => $u["student_number"] ?? "",
                                    "is_active"      => (bool)$u["is_active"],
                                ]), ENT_QUOTES) ?>)'
                                        class="btn btn-sm btn-outline">
                                    Düzenle
                                </button>
                                <form method="POST" action="<?= url('admin/kullanicilar/' . $u['id'] . '/toggle') ?>" class="inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" data-confirm="Kullanıcı durumu değiştirilsin mi?"
                                        class="btn btn-sm <?= $u['is_active'] ? 'btn-danger-ghost' : 'btn-success' ?>">
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
    <div class="flex flex-wrap justify-center gap-2 mt-6">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?sayfa=<?= $i ?>"
                class="btn btn-sm <?= $i === $page ? 'btn-primary' : 'btn-outline' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<!-- Kullanıcı Düzenle Modal -->
<div id="modal-edit-user" class="modal-backdrop hidden flex" role="dialog" aria-modal="true" aria-labelledby="modal-edit-user-title">
    <div class="modal-panel">
        <div class="modal-header">
            <h3 id="modal-edit-user-title" class="modal-title">Kullanıcı Düzenle</h3>
            <button type="button" onclick="document.getElementById('modal-edit-user').classList.add('hidden')"
                class="btn btn-ghost btn-icon btn-sm" aria-label="Kapat">&times;</button>
        </div>
        <form id="edit-user-form" method="POST" action="">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="sm:col-span-2">
                        <label class="form-label" for="edit-name">Ad Soyad *</label>
                        <input type="text" name="name" id="edit-name" required class="form-input">
                    </div>

                    <div>
                        <label class="form-label" for="edit-email">E-posta *</label>
                        <input type="email" name="email" id="edit-email" required class="form-input">
                    </div>

                    <div>
                        <label class="form-label" for="edit-password">Yeni Şifre</label>
                        <input type="password" name="password" id="edit-password" placeholder="Değiştirmek için doldurun" class="form-input">
                    </div>

                    <div>
                        <label class="form-label" for="edit-role">Rol *</label>
                        <select name="role" id="edit-role" required onchange="editToggleStudentFields(this.value)" class="form-select">
                            <option value="student">Öğrenci</option>
                            <option value="donor">Katkı Sağlayan</option>
                            <option value="venue-admin">İşletme Yöneticisi</option>
                            <option value="university-admin">Üniversite Admin</option>
                            <?php if (auth()['role'] === 'super-admin'): ?>
                                <option value="super-admin">Süper Admin</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div id="edit-student-number-field">
                        <label class="form-label" for="edit-student-number">Öğrenci No</label>
                        <input type="text" name="student_number" id="edit-student-number" class="form-input">
                    </div>

                    <div id="edit-weekly-limit-field" class="sm:col-span-2">
                        <label class="form-label" for="edit-weekly-limit">
                            Haftalık Rezervasyon Limiti
                            <span class="optional">(boş = genel ayar: <?= $globalWeeklyLimit ?>)</span>
                        </label>
                        <input type="number" name="weekly_limit" id="edit-weekly-limit" min="1" max="50"
                               placeholder="<?= $globalWeeklyLimit ?>" class="form-input">
                        <p class="form-help">Boş bırakırsanız tüm öğrencilere uygulanan genel limit geçerli olur.</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="form-check">
                            <input type="checkbox" name="is_active" id="edit-is-active" value="1">
                            <span>Hesap Aktif</span>
                        </label>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('modal-edit-user').classList.add('hidden')"
                    class="btn btn-outline">
                    İptal
                </button>
                <button type="submit" class="btn btn-primary">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Kullanıcı Ekle Modal -->
<div id="modal-add-user" class="modal-backdrop hidden flex" role="dialog" aria-modal="true" aria-labelledby="modal-add-user-title">
    <div class="modal-panel">
        <div class="modal-header">
            <h3 id="modal-add-user-title" class="modal-title">Yeni Kullanıcı Ekle</h3>
            <button type="button" onclick="document.getElementById('modal-add-user').classList.add('hidden')"
                class="btn btn-ghost btn-icon btn-sm" aria-label="Kapat">&times;</button>
        </div>
        <form method="POST" action="<?= url('admin/kullanicilar/ekle') ?>">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="form-label" for="add-name">Ad Soyad *</label>
                        <input type="text" name="name" id="add-name" required class="form-input">
                        <?= error_msg($errors, 'name') ?>
                    </div>
                    <div>
                        <label class="form-label" for="add-email">E-posta *</label>
                        <input type="email" name="email" id="add-email" required class="form-input">
                        <?= error_msg($errors, 'email') ?>
                    </div>
                    <div>
                        <label class="form-label" for="add-password">Şifre *</label>
                        <input type="password" name="password" id="add-password" required class="form-input">
                        <?= error_msg($errors, 'password') ?>
                    </div>
                    <div>
                        <label class="form-label" for="role-select">Rol *</label>
                        <select name="role" required id="role-select" onchange="toggleVenueField(this.value)" class="form-select">
                            <option value="student">Öğrenci</option>
                            <option value="donor">Katkı Sağlayan</option>
                            <option value="venue-admin">İşletme Yöneticisi</option>
                            <option value="university-admin">Üniversite Admin</option>
                            <?php if (auth()['role'] === 'super-admin'): ?>
                                <option value="super-admin">Süper Admin</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div id="venue-field" style="display:none">
                        <label class="form-label" for="venue-select">İşletme *</label>
                        <select name="venue_id" id="venue-select" class="form-select">
                            <option value="">Seçiniz...</option>
                            <?php foreach ($venues as $v): ?>
                                <option value="<?= e($v['id']) ?>"><?= e($v['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="add-student-number">Öğrenci No</label>
                        <input type="text" name="student_number" id="add-student-number" class="form-input">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('modal-add-user').classList.add('hidden')"
                    class="btn btn-outline">
                    İptal
                </button>
                <button type="submit" class="btn btn-primary">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Haftalık Limit Modal -->
<div id="modal-weekly-limit" class="modal-backdrop hidden flex" role="dialog" aria-modal="true" aria-labelledby="modal-weekly-limit-title">
    <div class="modal-panel max-w-sm">
        <div class="modal-header">
            <h3 id="modal-weekly-limit-title" class="modal-title">Haftalık Rezervasyon Limiti</h3>
            <button type="button" onclick="document.getElementById('modal-weekly-limit').classList.add('hidden')"
                class="btn btn-ghost btn-icon btn-sm" aria-label="Kapat">&times;</button>
        </div>
        <form id="weekly-limit-form" method="POST" action="">
            <?= csrf_field() ?>
            <div class="modal-body space-y-4">
                <p class="text-sm text-slate-600">
                    <span class="font-semibold text-slate-900" id="wl-user-name"></span> adlı öğrencinin haftalık rezervasyon limiti.
                </p>
                <div>
                    <label class="form-label" for="wl-input">
                        Haftalık Limit
                        <span class="optional">(boş bırakırsanız genel ayar uygulanır: <?= $globalWeeklyLimit ?>)</span>
                    </label>
                    <input type="number" name="weekly_limit" id="wl-input" min="1" max="50" placeholder="<?= $globalWeeklyLimit ?>"
                        class="form-input">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="wl-reset-btn" class="btn btn-ghost" title="Genel ayara döndür">
                    Genel Ayara Dön
                </button>
                <button type="button" onclick="document.getElementById('modal-weekly-limit').classList.add('hidden')"
                    class="btn btn-outline">
                    İptal
                </button>
                <button type="submit" class="btn btn-primary">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<!-- İşletme Ata Modal -->
<div id="modal-assign-venue" class="modal-backdrop hidden flex" role="dialog" aria-modal="true" aria-labelledby="modal-assign-venue-title">
    <div class="modal-panel max-w-md">
        <div class="modal-header">
            <h3 id="modal-assign-venue-title" class="modal-title">İşletme Ata</h3>
            <button type="button" onclick="document.getElementById('modal-assign-venue').classList.add('hidden')"
                class="btn btn-ghost btn-icon btn-sm" aria-label="Kapat">&times;</button>
        </div>
        <form id="assign-venue-form" method="POST" action="">
            <?= csrf_field() ?>
            <div class="modal-body">
                <p class="text-sm text-slate-600 mb-4">
                    <span class="font-semibold text-slate-900" id="assign-user-name"></span> adlı kullanıcıya işletme atayın.
                </p>
                <div>
                    <label class="form-label" for="assign-venue-select">İşletme *</label>
                    <select name="venue_id" id="assign-venue-select" required class="form-select">
                        <option value="">Seçiniz...</option>
                        <?php foreach ($venues as $v): ?>
                            <option value="<?= e($v['id']) ?>"><?= e($v['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('modal-assign-venue').classList.add('hidden')"
                    class="btn btn-outline">
                    İptal
                </button>
                <button type="submit" class="btn btn-primary">
                    Ata
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