<!DOCTYPE html>
<html lang="<?= current_lang() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= t('student_verify.page_title') ?> — Askıda Kampüs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen overflow-hidden relative">

<div class="fixed inset-0 bg-cover bg-center" style="background-image: url('<?= asset('images/login-bg.jpeg') ?>');"></div>
<div class="fixed inset-0 bg-black/50"></div>

<?php $cl = current_lang(); ?>
<div class="fixed top-4 right-4 z-20 flex items-center border border-white/30 rounded-md overflow-hidden text-xs font-bold">
    <a href="<?= url('lang/tr') ?>" class="px-2.5 py-1.5 <?= $cl === 'tr' ? 'bg-[#00A3B4] text-white' : 'text-white/70 hover:bg-white/10' ?> transition">TR</a>
    <a href="<?= url('lang/en') ?>" class="px-2.5 py-1.5 <?= $cl === 'en' ? 'bg-[#00A3B4] text-white' : 'text-white/70 hover:bg-white/10' ?> transition">EN</a>
</div>

<div class="min-h-screen flex items-center justify-center p-4 relative z-10">
    <div class="w-full max-w-sm bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-[#e0f7fa] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[#00A3B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-gray-800 text-xl font-bold"><?= t('student_verify.title') ?></h1>
            <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                <?= str_replace(':email', '<strong class="text-gray-700">' . e($email) . '</strong>', t('student_verify.desc')) ?>
            </p>
        </div>

        <?php $flashError = flash('error'); ?>
        <?php if ($flashError): ?>
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"><?= e($flashError) ?></div>
        <?php endif; ?>
        <?php $flashSuccess = flash('success'); ?>
        <?php if ($flashSuccess): ?>
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm"><?= e($flashSuccess) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= url('ogrenci-kayit/dogrula') ?>" class="space-y-5">
            <?= csrf_field() ?>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wide"><?= t('student_verify.code_label') ?></label>
                <input type="text" name="code" id="code"
                    maxlength="6" minlength="6" inputmode="numeric" pattern="[0-9]*"
                    class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl text-center text-3xl font-mono font-bold tracking-[0.5em]
                           focus:outline-none focus:border-[#00A3B4] transition <?= isset($errors['code']) ? 'border-red-400 bg-red-50' : '' ?>"
                    placeholder="000000" autocomplete="one-time-code" autofocus required>
                <?= error_msg($errors, 'code') ?>
                <p class="text-xs text-gray-400 text-center mt-2"><?= t('student_verify.expires_note') ?></p>
            </div>

            <button type="submit"
                class="w-full py-3 bg-[#00A3B4] hover:bg-[#008899] text-white font-semibold rounded-lg transition-colors text-sm">
                <?= t('student_verify.submit') ?>
            </button>
        </form>

        <div class="mt-5 pt-4 border-t border-gray-100 text-center">
            <form method="POST" action="<?= url('ogrenci-kayit/tekrar-gonder') ?>" class="inline">
                <?= csrf_field() ?>
                <button type="submit" class="text-sm text-[#00A3B4] hover:underline">
                    <?= t('student_verify.resend') ?>
                </button>
            </form>
            <span class="text-gray-300 mx-2">|</span>
            <a href="<?= url('ogrenci-kayit') ?>" class="text-sm text-gray-400 hover:underline">
                <?= t('student_verify.back_reg') ?>
            </a>
        </div>
    </div>
</div>

<script>
// Auto-format: sadece rakam, 6 hane dolunca otomatik submit
document.getElementById('code').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '').slice(0, 6);
    if (this.value.length === 6) this.closest('form').submit();
});
</script>
</body>
</html>
