<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Askıda Kampüs — AYBU İktisadi İşletmeler Müdürlüğü</title>
    <meta name="description"
        content="Ankara Yıldırım Beyazıt Üniversitesi Askıda Kampüs sistemi. Bağış yapın, ihtiyaç sahibi öğrencilere destek olun.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        /* ── HEADER ── */
        header {
            background: #ffffff;
            width: 100%;
            border-bottom: 1px solid #e8e8e8;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .logo-area img {
            height: 58px;
            width: auto;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .logo-text .line1 {
            font-size: 14.5px;
            font-weight: 600;
            color: #009999;
            letter-spacing: 0.1px;
        }

        .logo-text .line2 {
            font-size: 13.5px;
            font-weight: 400;
            color: #009999;
        }

        .nav-area {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .nav-area a {
            text-decoration: none;
            color: #009999;
            font-size: 13.5px;
            font-weight: 500;
            white-space: nowrap;
            transition: opacity 0.2s;
        }

        .nav-area a:hover { opacity: 0.65; }

        .nav-area a.uppercase {
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.3px;
        }

        .nav-area .btn-giris {
            background: #009999;
            color: #fff !important;
            padding: 8px 18px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 13px;
        }

        .nav-area .btn-giris:hover {
            opacity: 1 !important;
            background: #007a7a;
        }

        .lang {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-left: 10px;
        }

        .lang a {
            color: #009999;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .lang a:hover { opacity: 0.65; }

        .lang span { color: #ccc; font-size: 12px; }

        /* Mobile nav */
        @media (max-width: 768px) {
            .nav-area { display: none; }
            .mobile-menu-btn { display: flex !important; }
            .logo-area img { height: 44px; }
            .logo-text .line1 { font-size: 12px; }
            .logo-text .line2 { font-size: 11px; }
            .header-inner { padding: 10px 16px; }
        }

        /* ── HERO SLIDER ── */
        .hero-slider {
            position: relative;
            width: 100%;
            height: 420px;
            overflow: hidden;
            background: #1a2a3a;
            border-top: 3px solid #009999;
        }

        @media (max-width: 768px) {
            .hero-slider { height: 520px; }
            .slider-btn { width: 38px; height: 38px; }
            .slider-btn.prev { left: 10px; }
            .slider-btn.next { right: 10px; }
            .slider-progress { display: none; }
            .slide-desc { font-size: 13px; }
            .slide-actions a { padding: 9px 18px; font-size: 13px; }
        }

        .slides {
            display: flex;
            height: 100%;
            transition: transform 0.6s cubic-bezier(0.77, 0, 0.175, 1);
        }

        .slide {
            min-width: 100%;
            height: 100%;
            overflow: hidden;
            position: relative;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .slide-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,58,110,0.82) 0%, rgba(0,100,140,0.55) 50%, rgba(0,153,153,0.35) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
        }

        .slide-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            padding: 6px 18px;
            border-radius: 999px;
            margin-bottom: 20px;
        }

        .slide-badge .dot {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.85); }
        }

        .slide-title {
            font-size: clamp(28px, 5vw, 52px);
            font-weight: 900;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .slide-title span { color: #7dd8f0; }

        .slide-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.80);
            max-width: 560px;
            line-height: 1.65;
            margin-bottom: 28px;
            font-weight: 300;
        }

        .slide-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .slide-actions a {
            padding: 11px 26px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }

        .slide-actions .btn-primary {
            background: #fff;
            color: #003a6e;
            box-shadow: 0 4px 20px rgba(0,0,0,0.25);
        }

        .slide-actions .btn-primary:hover { background: #f0f4f8; }

        .slide-actions .btn-secondary {
            background: #009999;
            color: #fff;
            box-shadow: 0 4px 20px rgba(0,153,153,0.4);
        }

        .slide-actions .btn-secondary:hover { background: #007a7a; }

        .slide-actions .btn-ghost {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(4px);
        }

        .slide-actions .btn-ghost:hover { background: rgba(255,255,255,0.25); }

        /* Ok butonları */
        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #009999;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: background 0.2s, transform 0.2s;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
        }

        .slider-btn:hover {
            background: #007a7a;
            transform: translateY(-50%) scale(1.08);
        }

        .slider-btn svg {
            width: 20px; height: 20px;
            fill: none; stroke: #fff;
            stroke-width: 2.5;
            stroke-linecap: round; stroke-linejoin: round;
        }

        .slider-btn.prev { left: 24px; }
        .slider-btn.next { right: 24px; }

        .slider-counter {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            border-radius: 50% 50% 0 0;
            width: 80px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 500;
            color: #444;
            font-family: 'Segoe UI', sans-serif;
            letter-spacing: 1px;
            z-index: 10;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }

        .slider-progress {
            position: absolute;
            right: 78px;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 80px;
            background: rgba(255,255,255,0.25);
            border-radius: 2px;
            z-index: 10;
            overflow: hidden;
        }

        .slider-progress-fill {
            width: 100%;
            background: #fff;
            border-radius: 2px;
            transition: height 0.5s ease;
        }

        /* ── CONTENT SECTIONS ── */
        .stat-card { transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,58,110,0.12); }

        .venue-card { transition: all 0.2s; }
        .venue-card:hover { transform: translateY(-2px); border-color: #009999; box-shadow: 0 8px 25px rgba(0,153,153,0.12); }

        .step-number { background: #009999; color: #fff; }
        .section-title { color: #003a6e; }

        /* Mobile menu slide */
        #mobile-menu { transition: transform 0.3s ease; }

        /* ── FOOTER ── */
        footer {
            background: #0d1f3c;
            color: #cdd8e8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 48px 0 0 0;
        }

        .footer-main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px 40px;
            display: grid;
            grid-template-columns: 1fr 1px 1fr 1px 1fr;
            gap: 0;
        }

        .footer-divider { background: rgba(255,255,255,0.12); width: 1px; }

        .footer-col { padding: 0 40px; }
        .footer-col:first-child { padding-left: 0; }
        .footer-col:last-child  { padding-right: 0; }

        .footer-brand { display: flex; flex-direction: column; gap: 18px; }

        .footer-brand .brand-logo { display: flex; align-items: center; gap: 14px; }

        .footer-brand .brand-logo img {
            height: 52px;
            filter: brightness(0) invert(1);
            opacity: 0.92;
        }

        .footer-brand .brand-name {
            font-size: 36px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 1px;
        }

        .footer-brand .slogan {
            font-family: 'Brush Script MT', 'Segoe Script', cursive;
            font-size: 24px;
            color: #cdd8e8;
            opacity: 0.85;
            margin-top: 6px;
        }

        .footer-col-title {
            font-size: 13px;
            font-weight: 700;
            color: #00bcd4;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .footer-links { list-style: none; display: flex; flex-direction: column; gap: 10px; }

        .footer-links a { color: #a8bcd4; text-decoration: none; font-size: 13.5px; transition: color 0.2s; }
        .footer-links a:hover { color: #00bcd4; }

        .footer-contact p { font-size: 13.5px; line-height: 1.6; margin-bottom: 12px; color: #cdd8e8; }
        .footer-contact p strong { color: #ffffff; font-weight: 600; }
        .footer-contact a { color: #cdd8e8; text-decoration: none; }
        .footer-contact a:hover { color: #00bcd4; }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .footer-bottom .copy { font-size: 12.5px; color: rgba(255,255,255,0.45); }

        .footer-bottom-links { display: flex; gap: 24px; }
        .footer-bottom-links a { color: rgba(255,255,255,0.5); font-size: 12.5px; text-decoration: none; transition: color 0.2s; }
        .footer-bottom-links a:hover { color: #00bcd4; }

        @media (max-width: 900px) {
            .footer-main { grid-template-columns: 1fr; }
            .footer-divider { display: none; }
            .footer-col { padding: 20px 0; border-bottom: 1px solid rgba(255,255,255,0.08); }
            .footer-bottom { flex-direction: column; text-align: center; padding: 16px 20px; }
            .footer-bottom-links { flex-wrap: wrap; justify-content: center; gap: 12px; }
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- ── HEADER ── -->
    <header>
        <div class="header-inner">
            <!-- Sol: Logo -->
            <a href="<?= url('/') ?>" class="logo-area">
                <img src="https://aybu.edu.tr/assets/images/aybu-images/logo-dark.png" alt="AYBU Logo"
                     onerror="this.src='<?= asset('aybu.png') ?>'">
                <div class="logo-text">
                    <span class="line1">Ankara Yıldırım Beyazıt Üniversitesi</span>
                    <span class="line2">İktisadi İşletmeler Müdürlüğü</span>
                </div>
            </a>

            <!-- Sağ: Nav -->
            <nav class="nav-area">
                <a href="https://aybu.edu.tr/iktisadi.isletme/tr/sayfa/8084" target="_blank" class="uppercase">HAKKIMIZDA</a>
                <a href="https://aybu.edu.tr/iktisadi.isletme/tr/sayfa/9544" target="_blank" class="uppercase">YÖNETİM</a>
                <a href="https://aybu.edu.tr/iktisadi.isletme/tr/sayfa/8092" target="_blank">Mevzuat</a>
                <a href="https://aybu.edu.tr/iktisadi.isletme/tr/sayfa/9533" target="_blank">Personel</a>
                <a href="https://aybu.edu.tr/iktisadi.isletme/tr/sayfa/9531" target="_blank">KYS</a>
                <a href="#iletisim">İletişim</a>
                <div class="lang">
                    <a href="https://aybu.edu.tr/iktisadi.isletme/tr">TR</a>
                    <span>|</span>
                    <a href="https://aybu.edu.tr/iktisadi.isletme/en">EN</a>
                </div>
                <a href="<?= url('giris') ?>" class="btn-giris">Giriş Yap</a>
            </nav>

            <!-- Mobil Hamburger -->
            <button id="mobile-menu-btn"
                class="mobile-menu-btn hidden items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-100 transition">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobil Overlay -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden"></div>

        <!-- Mobil Menü -->
        <div id="mobile-menu"
            class="fixed top-0 right-0 bottom-0 w-72 bg-white shadow-2xl z-50 transform translate-x-full">
            <div class="h-full flex flex-col">
                <div class="flex items-center justify-between p-5 border-b border-gray-100" style="background:#009999">
                    <span class="font-bold text-white text-sm">Menü</span>
                    <button id="mobile-close" class="text-white/80 hover:text-white">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <nav class="flex-1 px-4 py-6 space-y-1">
                    <a href="https://aybu.edu.tr/iktisadi.isletme/tr/sayfa/8084" target="_blank"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition font-medium">Hakkımızda</a>
                    <a href="https://aybu.edu.tr/iktisadi.isletme/tr/sayfa/9544" target="_blank"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition font-medium">Yönetim</a>
                    <a href="#nasil-calisir"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition font-medium">Nasıl Çalışır?</a>
                    <a href="#isletmeler"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition font-medium">İşletmeler</a>
                    <a href="#iletisim"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition font-medium">İletişim</a>
                    <div class="pt-4 mt-4 border-t border-gray-100">
                        <a href="<?= url('giris') ?>"
                            class="block w-full text-center px-4 py-3 text-white font-semibold rounded-lg transition text-sm"
                            style="background:#009999">
                            Sisteme Giriş Yap
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- ── HERO SLIDER ── -->
    <section class="hero-slider">
        <div class="slides" id="slidesTrack">

            <!-- Slayt 1: Askıda Kampüs tanıtım -->
            <div class="slide">
                <img src="<?= asset('slide1.jpg') ?>" alt="Askıda Kampüs">
                <div class="slide-overlay">
                    <div class="slide-badge">
                        <span class="dot"></span>
                        Sistem aktif — Bağışlar devam ediyor
                    </div>
                    <h1 class="slide-title">
                        Paylaşmak Güzeldir,<br>
                        <span>Dayanışmak Daha Güzel</span>
                    </h1>
                    <p class="slide-desc">
                        Askıda Kampüs ile kampesteki öğrenciler için destek ol.
                        Bağışçılar önce sipariş verir, öğrenciler kodu sunarak teslim alır.
                    </p>
                    <div class="slide-actions">
                        <a href="<?= url('misafir-bagis') ?>" class="btn-primary">Bağış Yap</a>
                        <a href="<?= url('kayit') ?>" class="btn-secondary">Öğrenci Kaydı</a>
                        <a href="<?= url('giris') ?>" class="btn-ghost">Giriş Yap</a>
                    </div>
                </div>
            </div>

            <!-- Slayt 2: Nasıl çalışır -->
            <div class="slide">
                <img src="<?= asset('slide2.jpg') ?>" alt="Askıda Kampüs">
                <div class="slide-overlay">
                    <h1 class="slide-title">
                        Nasıl<br><span>Çalışır?</span>
                    </h1>
                    <p class="slide-desc">
                        Bağışçılar IBAN ile ödeme yapar, öğrenciler teslim kodu ile alır.
                        Üç adımda kampüste dayanışmaya katıl.
                    </p>
                    <div class="slide-actions">
                        <a href="#nasil-calisir" class="btn-primary">Detayları Gör</a>
                        <a href="#isletmeler" class="btn-ghost">Katılımcı İşletmeler</a>
                    </div>
                </div>
            </div>

        </div>

        <button class="slider-btn prev" onclick="changeSlide(-1)" aria-label="Önceki">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </button>

        <button class="slider-btn next" onclick="changeSlide(1)" aria-label="Sonraki">
            <svg viewBox="0 0 24 24"><polyline points="9 6 15 12 9 18"/></svg>
        </button>

        <div class="slider-counter">
            <span id="slideCounter">1 / 2</span>
        </div>

        <div class="slider-progress">
            <div class="slider-progress-fill" id="progressFill" style="height:50%"></div>
        </div>
    </section>

    <script>
    (function() {
        const track   = document.getElementById('slidesTrack');
        const counter = document.getElementById('slideCounter');
        const fill    = document.getElementById('progressFill');
        const slides  = track.querySelectorAll('.slide');
        const total   = slides.length;
        let current = 0, timer;

        function goTo(i) {
            current = (i + total) % total;
            track.style.transform = 'translateX(-' + (current * 100) + '%)';
            counter.textContent = (current + 1) + ' / ' + total;
            fill.style.height = (((current + 1) / total) * 100) + '%';
        }

        window.changeSlide = function(dir) {
            clearInterval(timer);
            goTo(current + dir);
            startAuto();
        };

        function startAuto() {
            timer = setInterval(function() { goTo(current + 1); }, 5000);
        }

        goTo(0);
        startAuto();
    })();
    </script>

    <!-- ── İstatistikler ── -->
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 py-8 grid grid-cols-2 sm:grid-cols-4 gap-px bg-gray-100">
            <div class="stat-card text-center p-6 bg-white">
                <p class="text-3xl font-bold text-[#0d1f3c]"><?= e($stats['venues']) ?>+</p>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-medium">Katılımcı İşletme</p>
            </div>
            <div class="stat-card text-center p-6 bg-white">
                <p class="text-3xl font-bold" style="color:#009999"><?= e($stats['donations']) ?>+</p>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-medium">Toplam Bağış</p>
            </div>
            <div class="stat-card text-center p-6 bg-white">
                <p class="text-3xl font-bold text-[#0d1f3c]"><?= e($stats['reservations']) ?>+</p>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-medium">Teslim Edilen</p>
            </div>
            <div class="stat-card text-center p-6 bg-white">
                <p class="text-3xl font-bold" style="color:#009999"><?= e($stats['stock']) ?>+</p>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-medium">Serbest Ürün</p>
            </div>
        </div>
    </section>

    <!-- ── Nasıl Çalışır ── -->
    <section id="nasil-calisir" class="py-16 px-4 bg-gray-50">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold section-title mb-2">Nasıl Çalışır?</h2>
                <div style="width:40px;height:3px;background:#009999;margin:8px auto 12px;border-radius:2px;"></div>
                <p class="text-gray-500 text-sm">Üç adımda destek ol, üç adımda yararlan</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Bağışçılar -->
                <div class="bg-white border border-gray-200 rounded-lg p-8" style="border-top:3px solid #009999;">
                    <div class="mb-6 pb-4 border-b border-gray-100">
                        <h3 class="font-bold text-[#0d1f3c] text-base uppercase tracking-wide">Bağışçılar İçin</h3>
                        <p class="text-xs text-gray-400 mt-1">Destek olmak isteyenler</p>
                    </div>
                    <ol class="space-y-5">
                        <li class="flex items-start gap-4">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#009999;">1</span>
                            <p class="text-gray-600 text-sm leading-relaxed">Sisteme giriş yapın ve kampüsdeki katılımcı işletmeleri görün.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#009999;">2</span>
                            <p class="text-gray-600 text-sm leading-relaxed">Bağışlamak istediğiniz ürünleri ve miktarları seçin.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#009999;">3</span>
                            <p class="text-gray-600 text-sm leading-relaxed">IBAN üzerinden ödeme yapın — bağışınız onaylandıktan sonra stoğa eklenir.</p>
                        </li>
                    </ol>
                    <a href="<?= url('misafir-bagis') ?>"
                        class="mt-7 inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded transition"
                        style="background:#009999;">
                        Bağış Yapmak İstiyorum →
                    </a>
                </div>

                <!-- Öğrenciler -->
                <div class="bg-white border border-gray-200 rounded-lg p-8" style="border-top:3px solid #0d1f3c;">
                    <div class="mb-6 pb-4 border-b border-gray-100">
                        <h3 class="font-bold text-[#0d1f3c] text-base uppercase tracking-wide">Öğrenciler İçin</h3>
                        <p class="text-xs text-gray-400 mt-1">Yararlanmak isteyenler</p>
                    </div>
                    <ol class="space-y-5">
                        <li class="flex items-start gap-4">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#0d1f3c;">1</span>
                            <p class="text-gray-600 text-sm leading-relaxed">Öğrenci hesabınızla giriş yapın, açık işletmeleri ve ürünleri görün.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#0d1f3c;">2</span>
                            <p class="text-gray-600 text-sm leading-relaxed">İstediğiniz ürünü rezerve edin — size özel bir teslim kodu oluşturulur.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#0d1f3c;">3</span>
                            <p class="text-gray-600 text-sm leading-relaxed">İşletmeye gidin, kasiyere kodunuzu söyleyin ve ürününüzü teslim alın.</p>
                        </li>
                    </ol>
                    <a href="<?= url('giris') ?>"
                        class="mt-7 inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded transition"
                        style="background:#0d1f3c;">
                        Rezervasyon Yapmak İstiyorum →
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- ── İşletmeler ── -->
    <?php if (!empty($venues)): ?>
    <section id="isletmeler" class="bg-white py-14 px-4 border-t border-gray-100">
        <div class="max-w-5xl mx-auto">
            <div class="mb-8">
                <h2 class="text-2xl font-bold section-title mb-2">Katılımcı İşletmeler</h2>
                <div style="width:40px;height:3px;background:#009999;margin-top:8px;border-radius:2px;"></div>
                <p class="text-gray-500 text-sm mt-3">Bu işletmelerde askıda ürün rezervasyonu yapabilirsiniz</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($venues as $v): ?>
                    <a href="<?= url('isletme/' . $v['id']) ?>"
                        class="venue-card border border-gray-200 rounded-lg p-5 block bg-white"
                        style="border-left:3px solid #009999;">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded flex items-center justify-center flex-shrink-0 text-white text-sm font-bold"
                                 style="background:#0d1f3c;">
                                <?= mb_strtoupper(mb_substr(e($v['name']), 0, 1)) ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm"><?= e($v['name']) ?></p>
                                <p class="text-xs text-gray-400 mt-0.5"><?= e($v['campus_name']) ?></p>
                                <?php if ($v['location']): ?>
                                    <p class="text-xs text-gray-400 mt-0.5 truncate"><?= e($v['location']) ?></p>
                                <?php endif; ?>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ── İletişim ── -->
    <section id="iletisim" style="background:#0d1f3c;" class="py-14 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="mb-8">
                <h2 class="text-2xl font-black text-white mb-2">Bize Ulaşın</h2>
                <p class="text-white/60 text-sm">Sorularınız için iletişime geçebilirsiniz</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/10">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-white font-semibold text-sm mb-1">Adres</p>
                    <p class="text-white/60 text-xs leading-relaxed">AYBÜ Esenboğa Külliyesi, Esenboğa / ANKARA</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/10">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-white font-semibold text-sm mb-1">E-posta</p>
                    <a href="mailto:basin@aybu.edu.tr"
                        class="text-white/70 hover:text-white text-xs transition">basin@aybu.edu.tr</a>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/10">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <p class="text-white font-semibold text-sm mb-1">Telefon</p>
                    <p class="text-white/70 text-xs">+90 312 906 10 00</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── FOOTER ── -->
    <footer>
        <div class="footer-main">

            <!-- Sol: Marka -->
            <div class="footer-col footer-brand">
                <div class="brand-logo">
                    <img src="https://aybu.edu.tr/assets/images/aybu-images/logo-white.png" alt="AYBU"
                         onerror="this.src='<?= asset('aybu.png') ?>'; this.style.filter='brightness(0) invert(1)'">
                    <span class="brand-name">AYBÜ</span>
                </div>
                <div class="slogan">Geçmişten Geleceğe...</div>
            </div>

            <div class="footer-divider"></div>

            <!-- Orta: Hızlı Erişim -->
            <div class="footer-col">
                <div class="footer-col-title">Hızlı Erişim</div>
                <ul class="footer-links">
                    <li><a href="<?= url('giris') ?>">Sisteme Giriş Yap</a></li>
                    <li><a href="<?= url('misafir-bagis') ?>">Bağış Yap</a></li>
                    <li><a href="#nasil-calisir">Nasıl Çalışır?</a></li>
                    <li><a href="#isletmeler">Katılımcı İşletmeler</a></li>
                    <li><a href="https://aybu.edu.tr/iktisadi.isletme/tr/sayfa/8084" target="_blank">Hakkımızda</a></li>
                    <li><a href="https://aybu.edu.tr/iktisadi.isletme/tr/sayfa/9544" target="_blank">Yönetim</a></li>
                    <li><a href="https://aybu.edu.tr/iktisadi.isletme/tr/sayfa/8094" target="_blank">İletişim</a></li>
                </ul>
            </div>

            <div class="footer-divider"></div>

            <!-- Sağ: İletişim -->
            <div class="footer-col footer-contact">
                <div class="footer-col-title">İletişim</div>
                <p><strong>Adres:</strong> Ankara Yıldırım Beyazıt Üniversitesi Esenboğa Külliyesi, Esenboğa / ANKARA</p>
                <p><strong>E-posta:</strong> <a href="mailto:basin@aybu.edu.tr">basin@aybu.edu.tr</a></p>
                <p><strong>Telefon:</strong> <a href="tel:+903129061000">+90 312 906 10 00</a></p>
                <p><strong>Web:</strong> <a href="https://aybu.edu.tr/iktisadi.isletme/tr" target="_blank">aybu.edu.tr/iktisadi.isletme</a></p>
            </div>

        </div>

        <!-- Alt bar -->
        <div class="footer-bottom">
            <span class="copy">© <?= date('Y') ?> Ankara Yıldırım Beyazıt Üniversitesi. Tüm hakları saklıdır.</span>
            <div class="footer-bottom-links">
                <a href="https://aybu.edu.tr/engelsiz" target="_blank">Erişilebilirlik</a>
                <a href="#">Gizlilik Politikası</a>
                <a href="#">KVKK</a>
            </div>
        </div>
    </footer>

    <script>
        const mobileBtn     = document.getElementById('mobile-menu-btn');
        const mobileMenu    = document.getElementById('mobile-menu');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const mobileClose   = document.getElementById('mobile-close');

        function openMenu() {
            mobileMenu.style.transform = 'translateX(0)';
            mobileOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeMenu() {
            mobileMenu.style.transform = 'translateX(100%)';
            mobileOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        mobileBtn?.addEventListener('click', openMenu);
        mobileClose?.addEventListener('click', closeMenu);
        mobileOverlay?.addEventListener('click', closeMenu);
        document.querySelectorAll('#mobile-menu nav a').forEach(a => a.addEventListener('click', closeMenu));

        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
            });
        });
    </script>
</body>

</html>