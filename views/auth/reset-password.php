<?php $headTitle = t('auth.reset_title'); include ROOT . '/views/layout/auth-start.php'; ?>

                    <div class="flex flex-col gap-1.5">
                        <h2 class="text-3xl font-bold tracking-tight text-navy-950"><?= t('auth.reset_title') ?></h2>
                        <p class="text-[15px] text-slate-600"><?= t('auth.reset_sub') ?></p>
                    </div>

                    <?php $flashError = flash('error'); ?>
                    <?php if ($flashError): ?>
                    <div class="flash flash-error" role="alert"><div class="flash-body"><?= e($flashError) ?></div></div>
                    <?php endif; ?>

                    <form method="POST" action="<?= url('sifre-sifirla') ?>" class="flex flex-col gap-[18px]">
                        <?= csrf_field() ?>
                        <input type="hidden" name="token" value="<?= e($token) ?>">
                        <input type="hidden" name="email" value="<?= e($email) ?>">

                        <div>
                            <label class="form-label" for="password"><?= t('auth.new_pass') ?></label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="form-input pr-12<?= isset($errors['password']) ? ' is-invalid' : '' ?>"
                                    placeholder="<?= t('auth.new_pass_ph') ?>" autocomplete="new-password" required>
                                <button type="button" onclick="togglePassword('password')" class="absolute right-1 top-1/2 -translate-y-1/2 w-11 h-11 flex items-center justify-center rounded-xl text-slate-500 hover:text-slate-700">
                                    <svg id="eye-icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eye-slash-icon-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <?= error_msg($errors, 'password') ?>
                        </div>

                        <div>
                            <label class="form-label" for="password_confirmation"><?= t('auth.new_pass_confirm') ?></label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-input pr-12<?= isset($errors['password_confirmation']) ? ' is-invalid' : '' ?>"
                                    placeholder="<?= t('auth.pass_confirm_ph') ?>" autocomplete="new-password" required>
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-1 top-1/2 -translate-y-1/2 w-11 h-11 flex items-center justify-center rounded-xl text-slate-500 hover:text-slate-700">
                                    <svg id="eye-icon-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eye-slash-icon-password_confirmation" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <?= error_msg($errors, 'password_confirmation') ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg"><?= t('auth.update_pass') ?></button>

                        <div class="text-center">
                            <a href="<?= url('giris') ?>" class="link text-sm font-semibold"><?= t('auth.back_login') ?></a>
                        </div>
                    </form>

<?php include ROOT . '/views/layout/auth-end.php'; ?>
<script>
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const eyeIcon = document.getElementById('eye-icon-' + fieldId);
    const eyeSlashIcon = document.getElementById('eye-slash-icon-' + fieldId);

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeSlashIcon.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');
    }
}
</script>
</body>
</html>
