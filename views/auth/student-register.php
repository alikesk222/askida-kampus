<?php $headTitle = t('student_reg.page_title'); $authWide = true; include ROOT . '/views/layout/auth-start.php'; ?>

                    <?php $stepperSteps = [t('stepper.info'), t('stepper.verify'), t('stepper.documents')]; $stepperCurrent = 0; include ROOT . '/views/partials/stepper.php'; ?>

                    <div class="flex flex-col gap-1.5">
                        <span class="eyebrow"><?= t('auth.login_univ') ?></span>
                        <h2 class="text-3xl font-bold tracking-tight text-navy-950"><?= t('student_reg.hero_title') ?></h2>
                    </div>

                    <?php $flashError = flash('error'); ?>
                    <?php if ($flashError): ?>
                    <div class="flash flash-error" role="alert"><div class="flash-body"><?= e($flashError) ?></div></div>
                    <?php endif; ?>
                    <?php $flashInfo = flash('info'); ?>
                    <?php if ($flashInfo): ?>
                    <div class="flash flash-info" role="status"><div class="flash-body"><?= e($flashInfo) ?></div></div>
                    <?php endif; ?>

                    <?php $suggestLogin = flash('suggest_login'); ?>

                    <form method="POST" action="<?= url('ogrenci-kayit') ?>" class="flex flex-col gap-[18px]">
                        <?= csrf_field() ?>

                        <div>
                            <label for="name" class="form-label"><?= t('student_reg.name') ?></label>
                            <input type="text" id="name" name="name" value="<?= e($old['name'] ?? '') ?>"
                                class="form-input<?= isset($errors['name']) ? ' is-invalid' : '' ?>"
                                placeholder="<?= t('auth.name_ph') ?>" autocomplete="name" required>
                            <?= error_msg($errors, 'name') ?>
                        </div>

                        <div>
                            <label for="email" class="form-label"><?= t('student_reg.email') ?></label>
                            <input type="email" id="email" name="email" value="<?= e($old['email'] ?? '') ?>"
                                class="form-input<?= isset($errors['email']) ? ' is-invalid' : '' ?>"
                                placeholder="2105081101@aybu.edu.tr" autocomplete="email" required>
                            <p class="form-help"><?= t('student_reg.email_hint') ?></p>
                            <?php if (isset($errors['email'])): ?>
                                <p class="form-error"><?= e(is_array($errors['email']) ? ($errors['email'][0] ?? '') : $errors['email']) ?></p>
                                <?php if ($suggestLogin): ?>
                                    <a href="<?= url('giris') ?>" class="link inline-block mt-1 text-sm font-semibold">
                                        <?= t('student_reg.suggest_login') ?>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="phone" class="form-label"><?= t('student_reg.phone') ?></label>
                            <input type="tel" id="phone" name="phone" value="<?= e($old['phone'] ?? '') ?>"
                                class="form-input<?= isset($errors['phone']) ? ' is-invalid' : '' ?>"
                                placeholder="05XX XXX XX XX" autocomplete="tel" required>
                            <?= error_msg($errors, 'phone') ?>
                        </div>

                        <div>
                            <label for="password" class="form-label"><?= t('auth.password') ?></label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="form-input pr-12<?= isset($errors['password']) ? ' is-invalid' : '' ?>"
                                    placeholder="••••••••" autocomplete="new-password" required
                                    oninput="checkStrength(this.value); checkConfirm(document.getElementById('password_confirm').value)">
                                <button type="button" onclick="togglePwd('password','eye1','eyeslash1')"
                                        class="absolute right-1 top-1/2 -translate-y-1/2 w-11 h-11 flex items-center justify-center rounded-xl text-slate-500 hover:text-slate-700">
                                    <svg id="eye1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eyeslash1" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <?= error_msg($errors, 'password') ?>

                            <!-- Şifre gücü listesi -->
                            <div id="strength-checklist" class="mt-2.5 p-3 bg-slate-50 border border-slate-200 rounded-xl hidden">
                                <p class="text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wide">Şifre Gereksinimleri</p>
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2" id="req-len">
                                        <span class="req-icon text-slate-300 font-bold text-sm leading-none w-4 text-center">○</span>
                                        <span class="req-text text-xs text-slate-600">En az 8 karakter</span>
                                    </div>
                                    <div class="flex items-center gap-2" id="req-upper">
                                        <span class="req-icon text-slate-300 font-bold text-sm leading-none w-4 text-center">○</span>
                                        <span class="req-text text-xs text-slate-600">En az bir büyük harf (A-Z)</span>
                                    </div>
                                    <div class="flex items-center gap-2" id="req-lower">
                                        <span class="req-icon text-slate-300 font-bold text-sm leading-none w-4 text-center">○</span>
                                        <span class="req-text text-xs text-slate-600">En az bir küçük harf (a-z)</span>
                                    </div>
                                    <div class="flex items-center gap-2" id="req-num">
                                        <span class="req-icon text-slate-300 font-bold text-sm leading-none w-4 text-center">○</span>
                                        <span class="req-text text-xs text-slate-600">En az bir rakam (0-9)</span>
                                    </div>
                                    <div class="flex items-center gap-2" id="req-special">
                                        <span class="req-icon text-slate-300 font-bold text-sm leading-none w-4 text-center">○</span>
                                        <span class="req-text text-xs text-slate-600">En az bir özel karakter (!@#$...)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirm" class="form-label"><?= t('student_reg.password_confirm') ?></label>
                            <div class="relative">
                                <input type="password" id="password_confirm" name="password_confirm"
                                    class="form-input pr-12<?= isset($errors['password_confirm']) ? ' is-invalid' : '' ?>"
                                    placeholder="••••••••" autocomplete="new-password" required
                                    oninput="checkConfirm(this.value)">
                                <button type="button" onclick="togglePwd('password_confirm','eye2','eyeslash2')"
                                        class="absolute right-1 top-1/2 -translate-y-1/2 w-11 h-11 flex items-center justify-center rounded-xl text-slate-500 hover:text-slate-700">
                                    <svg id="eye2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eyeslash2" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <div id="confirm-status" class="mt-1 hidden">
                                <p id="confirm-match"    class="text-xs text-emerald-700 font-medium hidden">✓ Şifreler eşleşiyor</p>
                                <p id="confirm-mismatch" class="text-xs text-red-700 font-medium hidden">✗ Şifreler eşleşmiyor</p>
                            </div>
                            <?= error_msg($errors, 'password_confirm') ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg"><?= t('student_reg.submit') ?></button>
                    </form>

                    <p class="text-xs text-slate-500 text-center"><?= t('student_reg.privacy') ?></p>

                    <div class="pt-4 border-t border-slate-200 text-center">
                        <p class="text-sm text-slate-600">
                            <?= t('student_reg.have_account') ?>
                            <a href="<?= url('giris') ?>" class="link font-semibold ml-1"><?= t('auth.login_link') ?></a>
                        </p>
                    </div>

<?php include ROOT . '/views/layout/auth-end.php'; ?>
<script>
function togglePwd(id, eyeId, slashId) {
    const inp  = document.getElementById(id);
    const show = inp.type === 'password';
    inp.type   = show ? 'text' : 'password';
    document.getElementById(eyeId).classList.toggle('hidden', show);
    document.getElementById(slashId).classList.toggle('hidden', !show);
}

function setReq(id, ok) {
    const el   = document.getElementById(id);
    const icon = el.querySelector('.req-icon');
    const text = el.querySelector('.req-text');
    icon.textContent = ok ? '✓' : '○';
    icon.className   = 'req-icon font-bold text-sm leading-none w-4 text-center ' + (ok ? 'text-emerald-600' : 'text-slate-300');
    text.className   = 'req-text text-xs ' + (ok ? 'text-emerald-700' : 'text-slate-600');
}

function checkStrength(val) {
    document.getElementById('strength-checklist').classList.toggle('hidden', val.length === 0);
    setReq('req-len',     val.length >= 8);
    setReq('req-upper',   /[A-Z]/.test(val));
    setReq('req-lower',   /[a-z]/.test(val));
    setReq('req-num',     /[0-9]/.test(val));
    setReq('req-special', /[^A-Za-z0-9]/.test(val));
}

function checkConfirm(val) {
    const pwdVal   = document.getElementById('password').value;
    const status   = document.getElementById('confirm-status');
    const match    = document.getElementById('confirm-match');
    const mismatch = document.getElementById('confirm-mismatch');

    if (val.length === 0) { status.classList.add('hidden'); return; }
    status.classList.remove('hidden');
    const ok = pwdVal === val;
    match.classList.toggle('hidden', !ok);
    mismatch.classList.toggle('hidden', ok);
}
</script>
</body>
</html>
