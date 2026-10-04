<?php
$pageTitle  = t('contact.hero_title');
$activePage = 'contact';
$metaDesc   = t('contact.hero_desc');
include ROOT . '/views/layout/public-header.php';
?>

<!-- Hero -->
<header class="on-dark relative overflow-hidden bg-navy-800">
    <div class="arch-lines" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-6xl px-6 py-14 sm:py-[72px]">
        <p class="eyebrow eyebrow-light mb-3"><?= t('contact.hero_tag') ?></p>
        <h1 class="text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl"><?= t('contact.hero_title') ?></h1>
        <p class="mt-5 max-w-xl text-lg leading-relaxed text-navy-200"><?= t('contact.hero_desc') ?></p>
    </div>
</header>

<section class="bg-page px-6 py-16">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-12 lg:grid-cols-[1fr_1.2fr]">

        <!-- Sol: İletişim bilgileri -->
        <div class="flex flex-col gap-4">
            <div class="mb-2">
                <p class="eyebrow mb-1.5"><?= t('contact.info_tag') ?></p>
                <h2 class="mb-1 text-xl font-bold text-navy-950">Ankara Yıldırım Beyazıt Üniversitesi</h2>
                <p class="text-sm text-slate-600"><?= t('contact.subtitle') ?></p>
            </div>

            <div class="card card-body flex items-start gap-4">
                <span class="icon-chip" aria-hidden="true">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                <div>
                    <p class="stat-label mb-1 uppercase tracking-wide"><?= t('contact.address_lbl') ?></p>
                    <p class="text-[15px] leading-relaxed text-slate-700"><?= nl2br(t('contact.address_val')) ?></p>
                </div>
            </div>

            <div class="card card-body flex items-start gap-4">
                <span class="icon-chip" aria-hidden="true">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <div>
                    <p class="stat-label mb-1 uppercase tracking-wide"><?= t('contact.email_lbl') ?></p>
                    <a href="mailto:basin@aybu.edu.tr" class="link text-[15px] font-medium">basin@aybu.edu.tr</a>
                </div>
            </div>

            <div class="card card-body flex items-start gap-4">
                <span class="icon-chip" aria-hidden="true">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </span>
                <div>
                    <p class="stat-label mb-1 uppercase tracking-wide"><?= t('contact.phone_lbl') ?></p>
                    <a href="tel:+903129061000" class="link text-[15px] font-medium">+90 312 906 10 00</a>
                </div>
            </div>

            <div class="card card-body flex items-start gap-4">
                <span class="icon-chip" aria-hidden="true">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <div>
                    <p class="stat-label mb-1 uppercase tracking-wide"><?= t('contact.hours_lbl') ?></p>
                    <p class="text-[15px] leading-relaxed text-slate-700"><?= nl2br(t('contact.hours_val')) ?></p>
                </div>
            </div>
        </div>

        <!-- Sağ: Hızlı Erişim -->
        <div class="flex flex-col gap-4">
            <div class="mb-2">
                <p class="eyebrow mb-1.5"><?= t('contact.links_tag') ?></p>
                <h2 class="text-xl font-bold text-navy-950"><?= t('contact.links_title') ?></h2>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <a href="<?= url('misafir-bagis') ?>" class="card card-body contact-quick">
                    <span class="icon-chip" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </span>
                    <span class="text-sm font-bold text-navy-950"><?= t('contact.link_donate') ?></span>
                    <span class="text-xs text-slate-600"><?= t('contact.link_donate_s') ?></span>
                </a>
                <a href="<?= url('ogrenci-kayit') ?>" class="card card-body contact-quick">
                    <span class="icon-chip" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </span>
                    <span class="text-sm font-bold text-navy-950"><?= t('contact.link_reg') ?></span>
                    <span class="text-xs text-slate-600"><?= t('contact.link_reg_s') ?></span>
                </a>
                <a href="<?= url('sss') ?>" class="card card-body contact-quick">
                    <span class="icon-chip" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <span class="text-sm font-bold text-navy-950"><?= t('contact.link_faq') ?></span>
                    <span class="text-xs text-slate-600"><?= t('contact.link_faq_s') ?></span>
                </a>
                <a href="<?= url('giris') ?>" class="card card-body contact-quick">
                    <span class="icon-chip" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    </span>
                    <span class="text-sm font-bold text-navy-950"><?= t('contact.link_login') ?></span>
                    <span class="text-xs text-slate-600"><?= t('contact.link_login_s') ?></span>
                </a>
            </div>

            <!-- Bilgi kutusu -->
            <div class="flash flash-info mt-2" role="note">
                <svg class="mt-0.5 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="flash-body">
                    <p class="font-semibold"><?= t('contact.support_title') ?></p>
                    <p class="mt-1 text-sm"><?= t('contact.support_desc') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- İletişim Formu -->
<section class="border-t border-slate-200 bg-white px-6 py-16">
    <div class="mx-auto max-w-2xl">

        <!-- Başlık -->
        <div class="mb-10 text-center">
            <p class="eyebrow mb-2"><?= t('contact.form_tag') ?></p>
            <h2 class="mb-2.5 text-3xl font-bold tracking-tight text-navy-950"><?= t('contact.form_title') ?></h2>
            <p class="text-[15px] leading-relaxed text-slate-600"><?= t('contact.form_desc') ?></p>
        </div>

        <?php
            $flashSuccess = flash('success');
            $flashError   = flash('error');
            $errors       = $errors ?? [];
            $old          = $old ?? [];
        ?>

        <?php if ($flashSuccess): ?>
        <div class="flash flash-success mb-6" role="status">
            <svg class="mt-0.5 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="flash-body"><?= e($flashSuccess) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($flashError): ?>
        <div class="flash flash-error mb-6" role="alert">
            <svg class="mt-0.5 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="flash-body"><?= e($flashError) ?></p>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?= url('iletisim') ?>" id="contact-form" class="card card-elevated p-6 sm:p-9">
            <?= csrf_field() ?>

            <div class="mb-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                <!-- Ad Soyad -->
                <div>
                    <label class="form-label" for="contact-name"><?= t('contact.form_name') ?> <span class="text-red-600" aria-hidden="true">*</span></label>
                    <input type="text" name="name" id="contact-name"
                           value="<?= e($old['name'] ?? '') ?>"
                           placeholder="<?= t('contact.form_name_ph') ?>"
                           class="form-input<?= isset($errors['name']) ? ' is-invalid' : '' ?>">
                    <?php if (isset($errors['name'])): ?>
                    <p class="form-error"><?= e($errors['name']) ?></p>
                    <?php endif; ?>
                </div>
                <!-- E-posta -->
                <div>
                    <label class="form-label" for="contact-email"><?= t('contact.form_email') ?> <span class="text-red-600" aria-hidden="true">*</span></label>
                    <input type="email" name="email" id="contact-email"
                           value="<?= e($old['email'] ?? '') ?>"
                           placeholder="<?= t('contact.form_email_ph') ?>"
                           class="form-input<?= isset($errors['email']) ? ' is-invalid' : '' ?>">
                    <?php if (isset($errors['email'])): ?>
                    <p class="form-error"><?= e($errors['email']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Konu -->
            <div class="mb-5">
                <label class="form-label" for="contact-subject"><?= t('contact.form_subject') ?> <span class="text-red-600" aria-hidden="true">*</span></label>
                <input type="text" name="subject" id="contact-subject"
                       value="<?= e($old['subject'] ?? '') ?>"
                       placeholder="<?= t('contact.form_subject_ph') ?>"
                       class="form-input<?= isset($errors['subject']) ? ' is-invalid' : '' ?>">
                <?php if (isset($errors['subject'])): ?>
                <p class="form-error"><?= e($errors['subject']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Mesaj -->
            <div class="mb-6">
                <label class="form-label" for="contact-message"><?= t('contact.form_message') ?> <span class="text-red-600" aria-hidden="true">*</span></label>
                <textarea name="message" id="contact-message" rows="6"
                          placeholder="<?= t('contact.form_message_ph') ?>"
                          class="form-textarea<?= isset($errors['message']) ? ' is-invalid' : '' ?>"><?= e($old['message'] ?? '') ?></textarea>
                <?php if (isset($errors['message'])): ?>
                <p class="form-error"><?= e($errors['message']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Gönder -->
            <div class="flex flex-wrap items-center justify-between gap-3">
                <p class="form-help flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <?= t('contact.form_note') ?>
                </p>
                <button type="submit" id="contact-submit" class="btn btn-primary btn-lg"><?= t('contact.form_submit') ?></button>
            </div>
        </form>
    </div>
</section>

<script>
document.getElementById('contact-form').addEventListener('submit', function() {
    const btn = document.getElementById('contact-submit');
    btn.disabled = true;
    btn.textContent = '<?= t('contact.form_sending') ?>';
});
</script>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
