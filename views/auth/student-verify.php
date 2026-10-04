<?php $headTitle = t('student_verify.page_title'); include ROOT . '/views/layout/auth-start.php'; ?>

                    <?php $stepperSteps = [t('stepper.info'), t('stepper.verify'), t('stepper.documents')]; $stepperCurrent = 1; include ROOT . '/views/partials/stepper.php'; ?>

                    <div class="flex flex-col gap-1.5">
                        <h2 class="text-3xl font-bold tracking-tight text-navy-950"><?= t('student_verify.title') ?></h2>
                        <p class="text-[15px] text-slate-600 leading-relaxed">
                            <?= str_replace(':email', '<strong class="text-slate-900">' . e($email) . '</strong>', t('student_verify.desc')) ?>
                        </p>
                    </div>

                    <?php $flashError = flash('error'); ?>
                    <?php if ($flashError): ?>
                    <div class="flash flash-error" role="alert"><div class="flash-body"><?= e($flashError) ?></div></div>
                    <?php endif; ?>
                    <?php $flashSuccess = flash('success'); ?>
                    <?php if ($flashSuccess): ?>
                    <div class="flash flash-success" role="status"><div class="flash-body"><?= e($flashSuccess) ?></div></div>
                    <?php endif; ?>

                    <form method="POST" action="<?= url('ogrenci-kayit/dogrula') ?>" class="flex flex-col gap-[18px]">
                        <?= csrf_field() ?>

                        <div>
                            <label for="code" class="form-label"><?= t('student_verify.code_label') ?></label>
                            <input type="text" name="code" id="code"
                                maxlength="6" minlength="6" inputmode="numeric" pattern="[0-9]*"
                                class="code-input<?= isset($errors['code']) ? ' is-invalid' : '' ?>"
                                placeholder="000000" autocomplete="one-time-code" autofocus required>
                            <?= error_msg($errors, 'code') ?>
                            <p class="form-help text-center"><?= t('student_verify.expires_note') ?></p>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg"><?= t('student_verify.submit') ?></button>
                    </form>

                    <div class="pt-4 border-t border-slate-200 text-center">
                        <form method="POST" action="<?= url('ogrenci-kayit/tekrar-gonder') ?>" class="inline">
                            <?= csrf_field() ?>
                            <button type="submit" class="link text-sm font-semibold">
                                <?= t('student_verify.resend') ?>
                            </button>
                        </form>
                        <span class="text-slate-300 mx-2">|</span>
                        <a href="<?= url('ogrenci-kayit') ?>" class="text-sm text-slate-500 hover:text-navy-800">
                            <?= t('student_verify.back_reg') ?>
                        </a>
                    </div>

<?php include ROOT . '/views/layout/auth-end.php'; ?>
<script>
// Auto-format: sadece rakam, 6 hane dolunca otomatik submit
document.getElementById('code').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '').slice(0, 6);
    if (this.value.length === 6) this.closest('form').submit();
});
</script>
</body>
</html>
