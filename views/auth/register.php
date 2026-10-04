<!DOCTYPE html>
<html lang="<?= current_lang() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= t('donor_reg.page_title') ?> — Askıda Kampüs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen relative bg-gray-900">

<div class="fixed inset-0 bg-cover bg-center" style="background-image: url('<?= asset('images/login-bg.jpeg') ?>');"></div>
<div class="fixed inset-0 bg-black/40"></div>

<?php $cl = current_lang(); ?>
<div class="fixed top-4 right-4 z-20 flex items-center border border-white/30 rounded-md overflow-hidden text-xs font-bold">
    <a href="<?= url('lang/tr') ?>" class="px-2.5 py-1.5 <?= $cl === 'tr' ? 'bg-[#00A3B4] text-white' : 'text-white/70 hover:bg-white/10' ?> transition">TR</a>
    <a href="<?= url('lang/en') ?>" class="px-2.5 py-1.5 <?= $cl === 'en' ? 'bg-[#00A3B4] text-white' : 'text-white/70 hover:bg-white/10' ?> transition">EN</a>
</div>

<div class="min-h-screen flex items-center justify-center p-4 relative z-10">
    <div class="w-full max-w-md bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8 lg:p-10 my-6">

        <!-- Logo + Başlık -->
        <div class="text-center mb-7">
            <a href="<?= url() ?>" class="inline-block">
                <img src="<?= asset('aybu.png') ?>" alt="AYBU Logo" class="h-16 w-auto mx-auto mb-4 hover:opacity-80 transition">
            </a>
            <h1 class="text-gray-800 text-lg font-semibold"><?= t('auth.login_univ') ?></h1>
            <!-- Bağışçı rozeti -->
            <div class="inline-flex items-center gap-1.5 mt-2 px-3 py-1 bg-amber-50 border border-amber-200 rounded-full">
                <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <p class="text-amber-700 text-xs font-semibold"><?= t('donor_reg.hero_title') ?></p>
            </div>
            <p class="text-gray-400 text-xs mt-2"><?= t('donor_reg.hero_desc') ?></p>
        </div>

        <?php $flashError = flash('error'); ?>
        <?php if ($flashError): ?>
        <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            <?= e($flashError) ?>
        </div>
        <?php endif; ?>
        <?php $flashInfo = flash('info'); ?>
        <?php if ($flashInfo): ?>
        <div class="mb-5 p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg text-sm">
            <?= e($flashInfo) ?>
        </div>
        <?php endif; ?>

        <?php $suggestLogin = flash('suggest_login'); ?>

        <form method="POST" action="<?= url('bagisci-kayit') ?>" class="space-y-5">
            <?= csrf_field() ?>

            <!-- Ad Soyad -->
            <div>
                <label for="name" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide"><?= t('donor_reg.name') ?></label>
                <input type="text" id="name" name="name" value="<?= e($old['name'] ?? '') ?>"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] text-sm <?= isset($errors['name']) ? 'border-red-400 bg-red-50' : 'border-gray-300' ?>"
                    placeholder="<?= t('auth.name_ph') ?>" autocomplete="name" required>
                <?= error_msg($errors, 'name') ?>
            </div>

            <!-- E-posta -->
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide"><?= t('donor_reg.email') ?></label>
                <input type="email" id="email" name="email" value="<?= e($old['email'] ?? '') ?>"
                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] text-sm <?= isset($errors['email']) ? 'border-red-400 bg-red-50' : 'border-gray-300' ?>"
                    placeholder="ornek@mail.com" autocomplete="email" required>
                <?php if (isset($errors['email'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= e(is_array($errors['email']) ? ($errors['email'][0] ?? '') : $errors['email']) ?></p>
                    <?php if ($suggestLogin): ?>
                        <a href="<?= url('giris') ?>" class="inline-block mt-1 text-sm font-semibold text-[#00A3B4] hover:underline">
                            <?= t('donor_reg.suggest_login') ?>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Şifre -->
            <div>
                <label for="password" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide"><?= t('auth.password') ?></label>
                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-3 pr-12 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] text-sm <?= isset($errors['password']) ? 'border-red-400 bg-red-50' : 'border-gray-300' ?>"
                        placeholder="••••••••" autocomplete="new-password" required
                        oninput="checkStrength(this.value); checkConfirm(document.getElementById('password_confirm').value)">
                    <button type="button" onclick="togglePwd('password','eye1','eyeslash1')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg id="eye1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eyeslash1" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                <?= error_msg($errors, 'password') ?>

                <!-- Şifre gücü listesi -->
                <div id="strength-checklist" class="mt-2.5 p-3 bg-gray-50 border border-gray-200 rounded-lg hidden">
                    <p class="text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">Şifre Gereksinimleri</p>
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2" id="req-len">
                            <span class="req-icon text-gray-300 font-bold text-sm leading-none w-4 text-center">○</span>
                            <span class="req-text text-xs text-gray-500">En az 8 karakter</span>
                        </div>
                        <div class="flex items-center gap-2" id="req-upper">
                            <span class="req-icon text-gray-300 font-bold text-sm leading-none w-4 text-center">○</span>
                            <span class="req-text text-xs text-gray-500">En az bir büyük harf (A-Z)</span>
                        </div>
                        <div class="flex items-center gap-2" id="req-lower">
                            <span class="req-icon text-gray-300 font-bold text-sm leading-none w-4 text-center">○</span>
                            <span class="req-text text-xs text-gray-500">En az bir küçük harf (a-z)</span>
                        </div>
                        <div class="flex items-center gap-2" id="req-num">
                            <span class="req-icon text-gray-300 font-bold text-sm leading-none w-4 text-center">○</span>
                            <span class="req-text text-xs text-gray-500">En az bir rakam (0-9)</span>
                        </div>
                        <div class="flex items-center gap-2" id="req-special">
                            <span class="req-icon text-gray-300 font-bold text-sm leading-none w-4 text-center">○</span>
                            <span class="req-text text-xs text-gray-500">En az bir özel karakter (!@#$...)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Şifre Tekrar -->
            <div>
                <label for="password_confirm" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide"><?= t('donor_reg.password_confirm') ?></label>
                <div class="relative">
                    <input type="password" id="password_confirm" name="password_confirm"
                        class="w-full px-4 py-3 pr-12 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] text-sm <?= isset($errors['password_confirm']) ? 'border-red-400 bg-red-50' : 'border-gray-300' ?>"
                        placeholder="••••••••" autocomplete="new-password" required
                        oninput="checkConfirm(this.value)">
                    <button type="button" onclick="togglePwd('password_confirm','eye2','eyeslash2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg id="eye2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eyeslash2" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                <div id="confirm-status" class="mt-1 hidden">
                    <p id="confirm-match"    class="text-xs text-green-600 font-medium hidden">✓ Şifreler eşleşiyor</p>
                    <p id="confirm-mismatch" class="text-xs text-red-500  font-medium hidden">✗ Şifreler eşleşmiyor</p>
                </div>
                <?= error_msg($errors, 'password_confirm') ?>
            </div>

            <button type="submit"
                class="w-full py-3 bg-[#00A3B4] hover:bg-[#008899] text-white font-medium rounded-lg transition-colors text-sm">
                <?= t('donor_reg.submit') ?>
            </button>
        </form>

        <p class="text-xs text-gray-400 text-center mt-5"><?= t('donor_reg.privacy') ?></p>

        <div class="mt-4 pt-4 border-t border-gray-100 space-y-2 text-center">
            <p class="text-sm text-gray-500">
                <?= t('donor_reg.have_account') ?>
                <a href="<?= url('giris') ?>" class="text-[#00A3B4] font-semibold hover:underline ml-1"><?= t('auth.login_link') ?></a>
            </p>
            <p class="text-xs text-gray-400">
                <?= t('donor_reg.guest_note') ?>
                <a href="<?= url('misafir-bagis') ?>" class="text-gray-500 hover:underline font-medium"><?= t('donor_reg.guest_link') ?></a>.
            </p>
        </div>
    </div>
</div>

<script src="<?= url('assets/js/app.js') ?>"></script>
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
    icon.className   = 'req-icon font-bold text-sm leading-none w-4 text-center ' + (ok ? 'text-green-500' : 'text-gray-300');
    text.className   = 'req-text text-xs ' + (ok ? 'text-green-600' : 'text-gray-500');
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
