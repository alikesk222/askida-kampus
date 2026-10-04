<?php $headTitle = t('auth.forgot_title'); include ROOT . '/views/layout/auth-start.php'; ?>

                    <div class="flex flex-col gap-1.5">
                        <h2 class="text-3xl font-bold tracking-tight text-navy-950"><?= t('auth.forgot_title') ?></h2>
                        <p class="text-[15px] text-slate-600"><?= t('auth.forgot_sub') ?></p>
                    </div>

                    <?php $flashSuccess = flash('success'); ?>
                    <?php if ($flashSuccess): ?>
                    <div class="flash flash-success" role="status"><div class="flash-body"><?= e($flashSuccess) ?></div></div>
                    <?php endif; ?>

                    <?php $flashError = flash('error'); ?>
                    <?php if ($flashError): ?>
                    <div class="flash flash-error" role="alert"><div class="flash-body"><?= e($flashError) ?></div></div>
                    <?php endif; ?>

                    <form method="POST" action="<?= url('sifremi-unuttum') ?>" class="flex flex-col gap-[18px]">
                        <?= csrf_field() ?>

                        <div>
                            <label class="form-label" for="email"><?= t('auth.email_addr') ?></label>
                            <input type="email" id="email" name="email" value="<?= old('email') ?>"
                                class="form-input<?= isset($errors['email']) ? ' is-invalid' : '' ?>"
                                placeholder="ornek@aybu.edu.tr" autocomplete="email" required>
                            <?= error_msg($errors, 'email') ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg"><?= t('auth.send_reset') ?></button>

                        <div class="text-center">
                            <a href="<?= url('giris') ?>" class="link text-sm font-semibold"><?= t('auth.back_login') ?></a>
                        </div>
                    </form>

<?php include ROOT . '/views/layout/auth-end.php'; ?>
</body>
</html>
