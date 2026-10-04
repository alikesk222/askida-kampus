<?php $headTitle = t('auth.login_btn'); include ROOT . '/views/layout/auth-start.php'; ?>

                    <div class="flex flex-col gap-1.5">
                        <h2 class="text-3xl font-bold tracking-tight text-navy-950"><?= t('auth.login_btn') ?></h2>
                        <p class="text-[15px] text-slate-600"><?= t('auth.login_univ') ?> · <?= t('auth.login_title') ?></p>
                    </div>

                    <?php $flashError = flash('error'); ?>
                    <?php if ($flashError): ?>
                    <div class="flash flash-error" role="alert"><div class="flash-body"><?= e($flashError) ?></div></div>
                    <?php endif; ?>

                    <form method="POST" action="<?= url('giris') ?>" class="flex flex-col gap-[18px]">
                        <?= csrf_field() ?>
                        <div class="absolute -left-[9999px] -top-[9999px] h-0 overflow-hidden" aria-hidden="true">
                            <input type="text" name="website" value="" tabindex="-1" autocomplete="off">
                        </div>

                        <div>
                            <label for="email" class="form-label"><?= t('auth.email') ?></label>
                            <input type="email" id="email" name="email" value="<?= old('email') ?>"
                                class="form-input<?= isset($errors['email']) ? ' is-invalid' : '' ?>"
                                placeholder="2105081101@aybu.edu.tr" autocomplete="email" required>
                            <?= error_msg($errors, 'email') ?>
                        </div>

                        <div>
                            <div class="flex items-baseline justify-between">
                                <label for="password" class="form-label"><?= t('auth.password') ?></label>
                                <a href="<?= url('sifremi-unuttum') ?>" class="link text-[13px] font-semibold"><?= t('auth.forgot') ?></a>
                            </div>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="form-input pr-12<?= isset($errors['password']) ? ' is-invalid' : '' ?>"
                                    placeholder="••••••••" autocomplete="current-password" required>
                                <button type="button" onclick="togglePassword()" class="absolute right-1 top-1/2 -translate-y-1/2 w-11 h-11 flex items-center justify-center rounded-xl text-slate-500 hover:text-slate-700">
                                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <?= error_msg($errors, 'password') ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg"><?= t('auth.login_btn') ?></button>
                    </form>

                    <div class="pt-5 border-t border-slate-200 text-center">
                        <p class="text-sm text-slate-600">
                            <?= t('auth.no_account') ?>
                            <a href="<?= url('ogrenci-kayit') ?>" class="link font-semibold ml-1"><?= t('auth.register_link') ?></a>
                        </p>
                    </div>

<?php include ROOT . '/views/layout/auth-end.php'; ?>
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeSlashIcon = document.getElementById('eye-slash-icon');

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
