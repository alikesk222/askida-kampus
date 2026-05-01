<!DOCTYPE html>
<?php $__lang = current_lang(); ?>
<html lang="<?= $__lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Askıda Kampüs') ?> — AYBU İktisadi İşletmeler</title>
    <meta name="description" content="<?= e($metaDesc ?? t('footer.brand_desc')) ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', 'Segoe UI', sans-serif; background: #f8f9fa; }

        /* ── NAV ── */
        .pub-nav {
            background: #fff;
            border-bottom: 1px solid #e8edf2;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }

        .pub-nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .pub-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            flex-shrink: 0;
        }
        .pub-logo img { height: 44px; width: auto; }
        .pub-logo-text { display: flex; flex-direction: column; gap: 1px; }
        .pub-logo-text .t1 { font-size: 11px; font-weight: 500; color: #6b7280; letter-spacing: 0.2px; line-height: 1; }
        .pub-logo-text .t2 { font-size: 15px; font-weight: 700; color: #009999; line-height: 1; letter-spacing: -0.2px; }

        .pub-links {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 1;
            justify-content: center;
        }
        .pub-links a {
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: #4b5563;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
            white-space: nowrap;
        }
        .pub-links a:hover { background: #f3f4f6; color: #009999; }
        .pub-links a.active { background: #e0f7fa; color: #007a7a; font-weight: 600; }

        .pub-cta {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn-outline-teal {
            padding: 8px 16px;
            border-radius: 8px;
            border: 1.5px solid #009999;
            color: #009999;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .btn-outline-teal:hover { background: #009999; color: #fff; }

        .btn-filled-teal {
            padding: 8px 16px;
            border-radius: 8px;
            background: #009999;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s;
            white-space: nowrap;
        }
        .btn-filled-teal:hover { background: #007a7a; }

        /* Language switcher */
        .lang-switcher {
            display: flex;
            align-items: center;
            gap: 2px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 2px;
            flex-shrink: 0;
        }
        .lang-switcher a {
            padding: 4px 9px;
            border-radius: 4px;
            font-size: 11.5px;
            font-weight: 700;
            color: #6b7280;
            text-decoration: none;
            letter-spacing: 0.5px;
            transition: all 0.15s;
        }
        .lang-switcher a:hover { background: #f3f4f6; color: #009999; }
        .lang-switcher a.lang-active { background: #009999; color: #fff; }

        /* Mobile */
        .pub-hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            padding: 8px;
            cursor: pointer;
            border: none;
            background: none;
            border-radius: 6px;
        }
        .pub-hamburger span { display: block; width: 22px; height: 2px; background: #374151; border-radius: 2px; transition: all 0.25s; }

        .pub-mobile-menu {
            display: none;
            border-top: 1px solid #e8edf2;
            background: #fff;
            padding: 16px 24px 20px;
        }
        .pub-mobile-menu.open { display: block; }
        .pub-mobile-menu a {
            display: block;
            padding: 11px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
            transition: background 0.15s;
        }
        .pub-mobile-menu a:hover { background: #f3f4f6; color: #009999; }
        .pub-mobile-menu a.active { background: #e0f7fa; color: #007a7a; font-weight: 600; }
        .pub-mobile-divider { height: 1px; background: #f3f4f6; margin: 10px 0; }
        .pub-mobile-cta { display: flex; flex-direction: column; gap: 8px; margin-top: 4px; }
        .pub-mobile-cta a { text-align: center; padding: 11px; border-radius: 8px; font-size: 13.5px; font-weight: 600; }

        .pub-mobile-lang { display: flex; gap: 8px; margin-top: 10px; }
        .pub-mobile-lang a {
            flex: 1;
            text-align: center;
            padding: 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid #e5e7eb;
            color: #6b7280;
            text-decoration: none;
            letter-spacing: 0.5px;
        }
        .pub-mobile-lang a.lang-active { background: #009999; color: #fff; border-color: #009999; }

        @media (max-width: 768px) {
            .pub-links, .pub-cta, .lang-switcher { display: none; }
            .pub-hamburger { display: flex; }
            .pub-nav-inner { padding: 0 16px; }
        }
    </style>
</head>
<body>

<nav class="pub-nav">
    <div class="pub-nav-inner">
        <!-- Logo -->
        <a href="<?= url('/') ?>" class="pub-logo">
            <img src="<?= asset('aybu.png') ?>" alt="AYBU">
            <div class="pub-logo-text">
                <span class="t1">Ankara Yıldırım Beyazıt Üniversitesi</span>
                <span class="t2">Askıda Kampüs</span>
            </div>
        </a>

        <!-- Orta: Linkler -->
        <div class="pub-links">
            <?php $ap = $activePage ?? ''; ?>
            <a href="<?= url('/') ?>"          class="<?= $ap === 'home'    ? 'active' : '' ?>"><?= t('nav.home') ?></a>
            <a href="<?= url('hakkimizda') ?>" class="<?= $ap === 'about'   ? 'active' : '' ?>"><?= t('nav.about') ?></a>
            <a href="<?= url('iletisim') ?>"   class="<?= $ap === 'contact' ? 'active' : '' ?>"><?= t('nav.contact') ?></a>
        </div>

        <!-- Dil Değiştirici -->
        <?php $cl = current_lang(); ?>
        <div class="lang-switcher">
            <a href="<?= url('lang/tr') ?>" class="<?= $cl === 'tr' ? 'lang-active' : '' ?>">TR</a>
            <a href="<?= url('lang/en') ?>" class="<?= $cl === 'en' ? 'lang-active' : '' ?>">EN</a>
        </div>

        <!-- Sağ: Butonlar -->
        <div class="pub-cta">
            <a href="<?= url('misafir-bagis') ?>" class="btn-outline-teal"><?= t('nav.donate') ?></a>
            <a href="<?= url('giris') ?>"         class="btn-filled-teal"><?= t('nav.login') ?></a>
        </div>

        <!-- Mobil hamburger -->
        <button class="pub-hamburger" id="pub-hamburger" aria-label="<?= t('nav.menu') ?>">
            <span></span><span></span><span></span>
        </button>
    </div>

    <!-- Mobil menü -->
    <div class="pub-mobile-menu" id="pub-mobile-menu">
        <?php $ap = $activePage ?? ''; $cl = current_lang(); ?>
        <a href="<?= url('/') ?>"          class="<?= $ap === 'home'    ? 'active' : '' ?>"><?= t('nav.home') ?></a>
        <a href="<?= url('hakkimizda') ?>" class="<?= $ap === 'about'   ? 'active' : '' ?>"><?= t('nav.about') ?></a>
        <a href="<?= url('iletisim') ?>"   class="<?= $ap === 'contact' ? 'active' : '' ?>"><?= t('nav.contact') ?></a>
        <div class="pub-mobile-divider"></div>
        <div class="pub-mobile-cta">
            <a href="<?= url('misafir-bagis') ?>" style="background:#e0f7fa;color:#007a7a;"><?= t('nav.donate') ?></a>
            <a href="<?= url('giris') ?>"         style="background:#009999;color:#fff;"><?= t('nav.login') ?></a>
        </div>
        <div class="pub-mobile-lang">
            <a href="<?= url('lang/tr') ?>" class="<?= $cl === 'tr' ? 'lang-active' : '' ?>">TR</a>
            <a href="<?= url('lang/en') ?>" class="<?= $cl === 'en' ? 'lang-active' : '' ?>">EN</a>
        </div>
    </div>
</nav>

<script>
(function(){
    const btn  = document.getElementById('pub-hamburger');
    const menu = document.getElementById('pub-mobile-menu');
    btn?.addEventListener('click', () => menu.classList.toggle('open'));
})();
</script>
