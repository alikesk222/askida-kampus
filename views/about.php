<?php
$pageTitle  = t('about.hero_title');
$activePage = 'about';
$metaDesc   = t('about.hero_desc');
include ROOT . '/views/layout/public-header.php';
?>

<style>
    .section-divider { width: 40px; height: 3px; background: #009999; border-radius: 2px; }
    .stat-card { background: #fff; border-radius: 10px; padding: 22px 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); text-align: center; }
    .value-card {
        background: #fff;
        border-radius: 10px;
        padding: 28px 26px;
        border: 1px solid #e8edf2;
        border-top: 3px solid #009999;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .value-card:hover { box-shadow: 0 6px 24px rgba(0,58,110,0.09); transform: translateY(-2px); }
    .value-num { font-size: 11px; font-weight: 700; color: #c4cdd8; letter-spacing: 1.5px; margin-bottom: 14px; }
    @media (max-width: 640px) {
        .proj-grid { grid-template-columns: 1fr !important; }
        .stat-grid  { grid-template-columns: 1fr 1fr !important; }
    }
</style>

<!-- Hero -->
<div style="background:linear-gradient(135deg,#0d1f3c 0%,#003a6e 55%,#005f7a 100%);padding:72px 24px;text-align:center;">
    <p style="font-size:11px;font-weight:700;color:#7dd8f0;letter-spacing:2.5px;text-transform:uppercase;margin-bottom:14px;"><?= t('about.hero_tag') ?></p>
    <h1 style="font-size:clamp(30px,5vw,46px);font-weight:800;color:#fff;line-height:1.15;margin-bottom:18px;letter-spacing:-0.5px;"><?= t('about.hero_title') ?></h1>
    <p style="font-size:15px;color:rgba(255,255,255,0.65);max-width:520px;margin:0 auto;line-height:1.8;">
        <?= t('about.hero_desc') ?>
    </p>
</div>

<!-- Proje Hakkında -->
<section style="background:#fff;padding:72px 24px;">
    <div style="max-width:920px;margin:0 auto;">
        <div class="proj-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:start;">

            <div>
                <p style="font-size:11px;font-weight:700;color:#009999;letter-spacing:2px;text-transform:uppercase;margin-bottom:10px;"><?= t('about.proj_tag') ?></p>
                <h2 style="font-size:26px;font-weight:800;color:#0d1f3c;margin-bottom:14px;line-height:1.25;letter-spacing:-0.3px;"><?= nl2br(t('about.proj_title')) ?></h2>
                <div class="section-divider" style="margin-bottom:24px;"></div>
                <p style="font-size:14px;color:#4b5563;line-height:1.85;margin-bottom:16px;">
                    <?= t('about.proj_p1') ?>
                </p>
                <p style="font-size:14px;color:#4b5563;line-height:1.85;margin-bottom:16px;">
                    <?= t('about.proj_p2') ?>
                </p>
                <p style="font-size:14px;color:#4b5563;line-height:1.85;">
                    <?= t('about.proj_p3') ?>
                </p>
            </div>

            <div>
                <div style="background:linear-gradient(145deg,#e8f7f9,#f0f9ff);border-radius:16px;padding:28px;">
                    <div class="stat-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div class="stat-card">
                            <div style="font-size:30px;font-weight:800;color:#009999;line-height:1;">13+</div>
                            <div style="font-size:11px;color:#6b7280;margin-top:6px;font-weight:600;letter-spacing:0.3px;"><?= t('about.stat_venues') ?></div>
                        </div>
                        <div class="stat-card">
                            <div style="font-size:30px;font-weight:800;color:#0d1f3c;line-height:1;">2</div>
                            <div style="font-size:11px;color:#6b7280;margin-top:6px;font-weight:600;letter-spacing:0.3px;"><?= t('about.stat_campuses') ?></div>
                        </div>
                        <div class="stat-card">
                            <div style="font-size:30px;font-weight:800;color:#009999;line-height:1;">7/24</div>
                            <div style="font-size:11px;color:#6b7280;margin-top:6px;font-weight:600;letter-spacing:0.3px;"><?= t('about.stat_system') ?></div>
                        </div>
                        <div class="stat-card">
                            <div style="font-size:30px;font-weight:800;color:#0d1f3c;line-height:1;">0₺</div>
                            <div style="font-size:11px;color:#6b7280;margin-top:6px;font-weight:600;letter-spacing:0.3px;"><?= t('about.stat_fee') ?></div>
                        </div>
                    </div>
                    <p style="font-size:11px;color:#9ca3af;text-align:center;margin-top:18px;line-height:1.5;">
                        Ankara Yıldırım Beyazıt Üniversitesi<br>kampüslerinde aktif
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Ayırıcı -->
<div style="max-width:920px;margin:0 auto;padding:0 24px;">
    <hr style="border:none;border-top:1px solid #e8edf2;">
</div>

<!-- Değerlerimiz -->
<section style="background:#fff;padding:72px 24px;">
    <div style="max-width:920px;margin:0 auto;">

        <div style="margin-bottom:44px;">
            <p style="font-size:11px;font-weight:700;color:#009999;letter-spacing:2px;text-transform:uppercase;margin-bottom:10px;"><?= t('about.values_tag') ?></p>
            <h2 style="font-size:26px;font-weight:800;color:#0d1f3c;margin-bottom:12px;letter-spacing:-0.3px;"><?= t('about.values_title') ?></h2>
            <div class="section-divider"></div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:18px;">

            <div class="value-card">
                <p class="value-num">01</p>
                <h3 style="font-size:16px;font-weight:700;color:#0d1f3c;margin-bottom:10px;"><?= t('about.val1_title') ?></h3>
                <p style="font-size:13px;color:#6b7280;line-height:1.75;"><?= t('about.val1_desc') ?></p>
            </div>

            <div class="value-card">
                <p class="value-num">02</p>
                <h3 style="font-size:16px;font-weight:700;color:#0d1f3c;margin-bottom:10px;"><?= t('about.val2_title') ?></h3>
                <p style="font-size:13px;color:#6b7280;line-height:1.75;"><?= t('about.val2_desc') ?></p>
            </div>

            <div class="value-card">
                <p class="value-num">03</p>
                <h3 style="font-size:16px;font-weight:700;color:#0d1f3c;margin-bottom:10px;"><?= t('about.val3_title') ?></h3>
                <p style="font-size:13px;color:#6b7280;line-height:1.75;"><?= t('about.val3_desc') ?></p>
            </div>

            <div class="value-card">
                <p class="value-num">04</p>
                <h3 style="font-size:16px;font-weight:700;color:#0d1f3c;margin-bottom:10px;"><?= t('about.val4_title') ?></h3>
                <p style="font-size:13px;color:#6b7280;line-height:1.75;"><?= t('about.val4_desc') ?></p>
            </div>

        </div>
    </div>
</section>

<!-- CTA -->
<section style="background:linear-gradient(135deg,#0d1f3c,#005f7a);padding:64px 24px;text-align:center;">
    <p style="font-size:11px;font-weight:700;color:#7dd8f0;letter-spacing:2px;text-transform:uppercase;margin-bottom:14px;">Katılın</p>
    <h2 style="font-size:26px;font-weight:800;color:#fff;margin-bottom:14px;letter-spacing:-0.3px;"><?= t('about.cta_title') ?></h2>
    <p style="font-size:14px;color:rgba(255,255,255,0.65);margin-bottom:32px;max-width:420px;margin-left:auto;margin-right:auto;line-height:1.8;">
        <?= t('about.cta_desc') ?>
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
        <a href="<?= url('misafir-bagis') ?>"
           style="padding:13px 30px;background:#009999;color:#fff;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;transition:background 0.2s;"
           onmouseover="this.style.background='#007a7a'" onmouseout="this.style.background='#009999'">
            <?= t('about.cta_btn_donate') ?>
        </a>
        <a href="<?= url('ogrenci-kayit') ?>"
           style="padding:13px 30px;background:rgba(255,255,255,0.1);color:#fff;border:1.5px solid rgba(255,255,255,0.3);border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;transition:background 0.2s;"
           onmouseover="this.style.background='rgba(255,255,255,0.18)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
            <?= t('about.cta_btn_reg') ?>
        </a>
    </div>
</section>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
