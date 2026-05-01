<?php
$pageTitle  = t('contact.hero_title');
$activePage = 'contact';
$metaDesc   = t('contact.hero_desc');
include ROOT . '/views/layout/public-header.php';
?>

<style>
    .page-hero { background: linear-gradient(135deg, #0d1f3c 0%, #003a6e 50%, #005f7a 100%); padding: 64px 24px; text-align: center; }
    .contact-card { background: #fff; border-radius: 12px; padding: 28px; border: 1px solid #e8edf2; display: flex; gap: 16px; align-items: flex-start; transition: box-shadow 0.2s; }
    .contact-card:hover { box-shadow: 0 6px 24px rgba(0,58,110,0.08); }
    .contact-icon { width: 44px; height: 44px; border-radius: 10px; background: #e0f7fa; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
</style>

<!-- Hero -->
<div class="page-hero">
    <p style="font-size:12px;font-weight:600;color:#7dd8f0;letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;"><?= t('contact.hero_tag') ?></p>
    <h1 style="font-size:clamp(28px,5vw,44px);font-weight:800;color:#fff;line-height:1.2;margin-bottom:16px;"><?= t('contact.hero_title') ?></h1>
    <p style="font-size:15px;color:rgba(255,255,255,0.7);max-width:480px;margin:0 auto;line-height:1.7;">
        <?= t('contact.hero_desc') ?>
    </p>
</div>

<section style="background:#f8f9fa;padding:64px 24px;">
    <div style="max-width:900px;margin:0 auto;display:grid;grid-template-columns:1fr 1.4fr;gap:40px;">

        <!-- Sol: İletişim bilgileri -->
        <div style="display:flex;flex-direction:column;gap:16px;">
            <div>
                <p style="font-size:12px;font-weight:700;color:#009999;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:6px;"><?= t('contact.info_tag') ?></p>
                <h2 style="font-size:20px;font-weight:700;color:#0d1f3c;margin-bottom:4px;">Ankara Yıldırım Beyazıt Üniversitesi</h2>
                <p style="font-size:13px;color:#6b7280;"><?= t('contact.subtitle') ?></p>
                <div style="width:36px;height:3px;background:#009999;border-radius:2px;margin-top:12px;"></div>
            </div>

            <div class="contact-card">
                <div class="contact-icon">
                    <svg style="width:20px;height:20px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;"><?= t('contact.address_lbl') ?></p>
                    <p style="font-size:13.5px;color:#4b5563;line-height:1.6;"><?= nl2br(t('contact.address_val')) ?></p>
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-icon">
                    <svg style="width:20px;height:20px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;"><?= t('contact.email_lbl') ?></p>
                    <a href="mailto:basin@aybu.edu.tr" style="font-size:13.5px;color:#009999;text-decoration:none;font-weight:500;">basin@aybu.edu.tr</a>
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-icon">
                    <svg style="width:20px;height:20px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;"><?= t('contact.phone_lbl') ?></p>
                    <a href="tel:+903129061000" style="font-size:13.5px;color:#009999;text-decoration:none;font-weight:500;">+90 312 906 10 00</a>
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-icon">
                    <svg style="width:20px;height:20px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:12px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;"><?= t('contact.hours_lbl') ?></p>
                    <p style="font-size:13.5px;color:#4b5563;"><?= nl2br(t('contact.hours_val')) ?></p>
                </div>
            </div>
        </div>

        <!-- Sağ: Hızlı Erişim -->
        <div style="display:flex;flex-direction:column;gap:16px;">
            <div>
                <p style="font-size:12px;font-weight:700;color:#009999;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:6px;"><?= t('contact.links_tag') ?></p>
                <h2 style="font-size:20px;font-weight:700;color:#0d1f3c;margin-bottom:4px;"><?= t('contact.links_title') ?></h2>
                <div style="width:36px;height:3px;background:#009999;border-radius:2px;margin-top:12px;margin-bottom:24px;"></div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <a href="<?= url('misafir-bagis') ?>" style="padding:20px;background:#fff;border:1px solid #e8edf2;border-radius:12px;text-decoration:none;display:flex;flex-direction:column;gap:8px;transition:box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,153,153,0.12)'" onmouseout="this.style.boxShadow='none'">
                    <div style="width:36px;height:36px;background:#e0f7fa;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:18px;height:18px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <span style="font-size:13px;font-weight:600;color:#0d1f3c;"><?= t('contact.link_donate') ?></span>
                    <span style="font-size:12px;color:#6b7280;"><?= t('contact.link_donate_s') ?></span>
                </a>
                <a href="<?= url('kayit') ?>" style="padding:20px;background:#fff;border:1px solid #e8edf2;border-radius:12px;text-decoration:none;display:flex;flex-direction:column;gap:8px;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,153,153,0.12)'" onmouseout="this.style.boxShadow='none'">
                    <div style="width:36px;height:36px;background:#e0f7fa;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:18px;height:18px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <span style="font-size:13px;font-weight:600;color:#0d1f3c;"><?= t('contact.link_reg') ?></span>
                    <span style="font-size:12px;color:#6b7280;"><?= t('contact.link_reg_s') ?></span>
                </a>
                <a href="<?= url('sss') ?>" style="padding:20px;background:#fff;border:1px solid #e8edf2;border-radius:12px;text-decoration:none;display:flex;flex-direction:column;gap:8px;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,153,153,0.12)'" onmouseout="this.style.boxShadow='none'">
                    <div style="width:36px;height:36px;background:#e0f7fa;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:18px;height:18px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span style="font-size:13px;font-weight:600;color:#0d1f3c;"><?= t('contact.link_faq') ?></span>
                    <span style="font-size:12px;color:#6b7280;"><?= t('contact.link_faq_s') ?></span>
                </a>
                <a href="<?= url('giris') ?>" style="padding:20px;background:#fff;border:1px solid #e8edf2;border-radius:12px;text-decoration:none;display:flex;flex-direction:column;gap:8px;" onmouseover="this.style.boxShadow='0 6px 20px rgba(0,153,153,0.12)'" onmouseout="this.style.boxShadow='none'">
                    <div style="width:36px;height:36px;background:#e0f7fa;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:18px;height:18px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    </div>
                    <span style="font-size:13px;font-weight:600;color:#0d1f3c;"><?= t('contact.link_login') ?></span>
                    <span style="font-size:12px;color:#6b7280;"><?= t('contact.link_login_s') ?></span>
                </a>
            </div>

            <!-- Bilgi kutusu -->
            <div style="background:linear-gradient(135deg,#e0f7fa,#f0f9ff);border-radius:12px;padding:24px;border:1px solid #b2ebf2;margin-top:8px;">
                <div style="display:flex;gap:12px;align-items:flex-start;">
                    <svg style="width:20px;height:20px;color:#009999;flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p style="font-size:13px;font-weight:600;color:#007a7a;margin-bottom:4px;"><?= t('contact.support_title') ?></p>
                        <p style="font-size:12.5px;color:#4b5563;line-height:1.6;"><?= t('contact.support_desc') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- İletişim Formu -->
<section style="background:#fff;padding:64px 24px;border-top:1px solid #e8edf2;">
    <div style="max-width:680px;margin:0 auto;">

        <!-- Başlık -->
        <div style="text-align:center;margin-bottom:40px;">
            <p style="font-size:12px;font-weight:700;color:#009999;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:8px;">
                <?= t('contact.form_tag') ?>
            </p>
            <h2 style="font-size:26px;font-weight:800;color:#0d1f3c;margin:0 0 10px;"><?= t('contact.form_title') ?></h2>
            <p style="font-size:14px;color:#6b7280;line-height:1.7;margin:0;"><?= t('contact.form_desc') ?></p>
        </div>

        <?php
            $flashSuccess = flash('success');
            $flashError   = flash('error');
            $errors       = $errors ?? [];
            $old          = $old ?? [];
        ?>

        <?php if ($flashSuccess): ?>
        <div style="background:#d1fae5;border:1px solid #6ee7b7;border-radius:10px;padding:16px 20px;display:flex;align-items:flex-start;gap:12px;margin-bottom:24px;">
            <svg style="width:20px;height:20px;color:#059669;flex-shrink:0;margin-top:1px;" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p style="margin:0;font-size:14px;color:#065f46;font-weight:500;"><?= e($flashSuccess) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($flashError): ?>
        <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:10px;padding:16px 20px;display:flex;align-items:flex-start;gap:12px;margin-bottom:24px;">
            <svg style="width:20px;height:20px;color:#dc2626;flex-shrink:0;margin-top:1px;" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p style="margin:0;font-size:14px;color:#991b1b;font-weight:500;"><?= e($flashError) ?></p>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?= url('iletisim') ?>" id="contact-form"
              style="background:#f8f9fb;border:1px solid #e8edf2;border-radius:14px;padding:36px;">
            <?= csrf_field() ?>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
                <!-- Ad Soyad -->
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                        <?= t('contact.form_name') ?> <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" name="name"
                           value="<?= e($old['name'] ?? '') ?>"
                           placeholder="<?= t('contact.form_name_ph') ?>"
                           style="width:100%;padding:11px 14px;border:1.5px solid <?= isset($errors['name']) ? '#ef4444' : '#d1d5db' ?>;border-radius:8px;font-size:14px;color:#111827;background:#fff;outline:none;box-sizing:border-box;transition:border-color .2s;"
                           onfocus="this.style.borderColor='#00A3B4'" onblur="this.style.borderColor='<?= isset($errors['name']) ? '#ef4444' : '#d1d5db' ?>'">
                    <?php if (isset($errors['name'])): ?>
                    <p style="margin:5px 0 0;font-size:12px;color:#ef4444;"><?= e($errors['name']) ?></p>
                    <?php endif; ?>
                </div>
                <!-- E-posta -->
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                        <?= t('contact.form_email') ?> <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="email" name="email"
                           value="<?= e($old['email'] ?? '') ?>"
                           placeholder="<?= t('contact.form_email_ph') ?>"
                           style="width:100%;padding:11px 14px;border:1.5px solid <?= isset($errors['email']) ? '#ef4444' : '#d1d5db' ?>;border-radius:8px;font-size:14px;color:#111827;background:#fff;outline:none;box-sizing:border-box;transition:border-color .2s;"
                           onfocus="this.style.borderColor='#00A3B4'" onblur="this.style.borderColor='<?= isset($errors['email']) ? '#ef4444' : '#d1d5db' ?>'">
                    <?php if (isset($errors['email'])): ?>
                    <p style="margin:5px 0 0;font-size:12px;color:#ef4444;"><?= e($errors['email']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Konu -->
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                    <?= t('contact.form_subject') ?> <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="subject"
                       value="<?= e($old['subject'] ?? '') ?>"
                       placeholder="<?= t('contact.form_subject_ph') ?>"
                       style="width:100%;padding:11px 14px;border:1.5px solid <?= isset($errors['subject']) ? '#ef4444' : '#d1d5db' ?>;border-radius:8px;font-size:14px;color:#111827;background:#fff;outline:none;box-sizing:border-box;transition:border-color .2s;"
                       onfocus="this.style.borderColor='#00A3B4'" onblur="this.style.borderColor='<?= isset($errors['subject']) ? '#ef4444' : '#d1d5db' ?>'">
                <?php if (isset($errors['subject'])): ?>
                <p style="margin:5px 0 0;font-size:12px;color:#ef4444;"><?= e($errors['subject']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Mesaj -->
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                    <?= t('contact.form_message') ?> <span style="color:#ef4444;">*</span>
                </label>
                <textarea name="message" rows="6"
                          placeholder="<?= t('contact.form_message_ph') ?>"
                          style="width:100%;padding:11px 14px;border:1.5px solid <?= isset($errors['message']) ? '#ef4444' : '#d1d5db' ?>;border-radius:8px;font-size:14px;color:#111827;background:#fff;outline:none;box-sizing:border-box;resize:vertical;line-height:1.6;transition:border-color .2s;font-family:inherit;"
                          onfocus="this.style.borderColor='#00A3B4'" onblur="this.style.borderColor='<?= isset($errors['message']) ? '#ef4444' : '#d1d5db' ?>'"><?= e($old['message'] ?? '') ?></textarea>
                <?php if (isset($errors['message'])): ?>
                <p style="margin:5px 0 0;font-size:12px;color:#ef4444;"><?= e($errors['message']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Gönder -->
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <p style="margin:0;font-size:12px;color:#9ca3af;display:flex;align-items:center;gap:5px;">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <?= t('contact.form_note') ?>
                </p>
                <button type="submit" id="contact-submit"
                        style="padding:12px 32px;background:linear-gradient(135deg,#00A3B4,#007A8A);color:#fff;font-size:15px;font-weight:700;border:none;border-radius:9px;cursor:pointer;transition:opacity .2s;letter-spacing:0.2px;">
                    <?= t('contact.form_submit') ?>
                </button>
            </div>
        </form>
    </div>
</section>

<script>
document.getElementById('contact-form').addEventListener('submit', function() {
    const btn = document.getElementById('contact-submit');
    btn.disabled = true;
    btn.style.opacity = '0.7';
    btn.textContent = '<?= t('contact.form_sending') ?>';
});
</script>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
