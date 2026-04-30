<?php
$pageTitle  = t('about.hero_title');
$activePage = 'about';
$metaDesc   = t('about.hero_desc');
include ROOT . '/views/layout/public-header.php';
?>

<style>
    .page-hero { background: linear-gradient(135deg, #0d1f3c 0%, #003a6e 50%, #005f7a 100%); padding: 64px 24px; text-align: center; }
    .section-divider { width: 48px; height: 3px; background: #009999; border-radius: 2px; margin: 12px auto 0; }
    .value-card { background: #fff; border-radius: 12px; padding: 28px; border: 1px solid #e8edf2; transition: box-shadow 0.2s, transform 0.2s; }
    .value-card:hover { box-shadow: 0 8px 30px rgba(0,58,110,0.1); transform: translateY(-2px); }
    .value-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
</style>

<!-- Hero -->
<div class="page-hero">
    <p style="font-size:12px;font-weight:600;color:#7dd8f0;letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;"><?= t('about.hero_tag') ?></p>
    <h1 style="font-size:clamp(28px,5vw,44px);font-weight:800;color:#fff;line-height:1.2;margin-bottom:16px;"><?= t('about.hero_title') ?></h1>
    <p style="font-size:15px;color:rgba(255,255,255,0.7);max-width:560px;margin:0 auto;line-height:1.7;">
        <?= t('about.hero_desc') ?>
    </p>
</div>

<!-- Proje Hakkında -->
<section style="background:#fff;padding:64px 24px;">
    <div style="max-width:900px;margin:0 auto;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center;">
            <div>
                <p style="font-size:12px;font-weight:700;color:#009999;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:8px;"><?= t('about.proj_tag') ?></p>
                <h2 style="font-size:26px;font-weight:700;color:#0d1f3c;margin-bottom:16px;line-height:1.3;"><?= nl2br(t('about.proj_title')) ?></h2>
                <div class="section-divider" style="margin:0 0 20px;"></div>
                <p style="font-size:14px;color:#4b5563;line-height:1.8;margin-bottom:14px;">
                    <?= t('about.proj_p1') ?>
                </p>
                <p style="font-size:14px;color:#4b5563;line-height:1.8;margin-bottom:14px;">
                    <?= t('about.proj_p2') ?>
                </p>
                <p style="font-size:14px;color:#4b5563;line-height:1.8;">
                    <?= t('about.proj_p3') ?>
                </p>
            </div>
            <div style="background:linear-gradient(135deg,#e0f7fa,#f0f9ff);border-radius:16px;padding:32px;text-align:center;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div style="background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                        <div style="font-size:28px;font-weight:800;color:#009999;">13+</div>
                        <div style="font-size:11px;color:#6b7280;margin-top:4px;font-weight:500;"><?= t('about.stat_venues') ?></div>
                    </div>
                    <div style="background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                        <div style="font-size:28px;font-weight:800;color:#0d1f3c;">2</div>
                        <div style="font-size:11px;color:#6b7280;margin-top:4px;font-weight:500;"><?= t('about.stat_campuses') ?></div>
                    </div>
                    <div style="background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                        <div style="font-size:28px;font-weight:800;color:#009999;">7/24</div>
                        <div style="font-size:11px;color:#6b7280;margin-top:4px;font-weight:500;"><?= t('about.stat_system') ?></div>
                    </div>
                    <div style="background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                        <div style="font-size:28px;font-weight:800;color:#0d1f3c;">0₺</div>
                        <div style="font-size:11px;color:#6b7280;margin-top:4px;font-weight:500;"><?= t('about.stat_fee') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Değerlerimiz -->
<section style="background:#f8f9fa;padding:64px 24px;">
    <div style="max-width:900px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:40px;">
            <p style="font-size:12px;font-weight:700;color:#009999;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:8px;"><?= t('about.values_tag') ?></p>
            <h2 style="font-size:24px;font-weight:700;color:#0d1f3c;"><?= t('about.values_title') ?></h2>
            <div class="section-divider"></div>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;">
            <div class="value-card">
                <div class="value-icon" style="background:#e0f7fa;">
                    <svg style="width:24px;height:24px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 style="font-size:15px;font-weight:700;color:#0d1f3c;margin-bottom:8px;"><?= t('about.val1_title') ?></h3>
                <p style="font-size:13px;color:#6b7280;line-height:1.6;"><?= t('about.val1_desc') ?></p>
            </div>
            <div class="value-card">
                <div class="value-icon" style="background:#fef3c7;">
                    <svg style="width:24px;height:24px;color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 style="font-size:15px;font-weight:700;color:#0d1f3c;margin-bottom:8px;"><?= t('about.val2_title') ?></h3>
                <p style="font-size:13px;color:#6b7280;line-height:1.6;"><?= t('about.val2_desc') ?></p>
            </div>
            <div class="value-card">
                <div class="value-icon" style="background:#ede9fe;">
                    <svg style="width:24px;height:24px;color:#7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 style="font-size:15px;font-weight:700;color:#0d1f3c;margin-bottom:8px;"><?= t('about.val3_title') ?></h3>
                <p style="font-size:13px;color:#6b7280;line-height:1.6;"><?= t('about.val3_desc') ?></p>
            </div>
            <div class="value-card">
                <div class="value-icon" style="background:#dcfce7;">
                    <svg style="width:24px;height:24px;color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 style="font-size:15px;font-weight:700;color:#0d1f3c;margin-bottom:8px;"><?= t('about.val4_title') ?></h3>
                <p style="font-size:13px;color:#6b7280;line-height:1.6;"><?= t('about.val4_desc') ?></p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section style="background:#009999;padding:56px 24px;text-align:center;">
    <h2 style="font-size:24px;font-weight:800;color:#fff;margin-bottom:12px;"><?= t('about.cta_title') ?></h2>
    <p style="font-size:14px;color:rgba(255,255,255,0.85);margin-bottom:28px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.7;">
        <?= t('about.cta_desc') ?>
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
        <a href="<?= url('misafir-bagis') ?>" style="padding:12px 28px;background:#fff;color:#009999;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;"><?= t('about.cta_btn_donate') ?></a>
        <a href="<?= url('kayit') ?>"         style="padding:12px 28px;background:rgba(255,255,255,0.15);color:#fff;border:1.5px solid rgba(255,255,255,0.4);border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;"><?= t('about.cta_btn_reg') ?></a>
    </div>
</section>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
