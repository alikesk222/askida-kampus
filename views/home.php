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
        * {
            font-family: 'Inter', sans-serif;
        }

        /* ── AYBU-style Header ── */
        .aybu-topbar {
            background-color: #003a6e;
            color: #fff;
            font-size: 12px;
            padding: 5px 0;
        }

        .aybu-header {
            background: #fff;
            border-bottom: 3px solid #003a6e;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .aybu-header-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
        }

        .aybu-logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }

        .aybu-logo-area img {
            height: 58px;
            width: auto;
        }

        .aybu-logo-text {
            border-left: 2px solid #003a6e;
            padding-left: 14px;
        }

        .aybu-logo-text .uni-name {
            font-size: 13px;
            font-weight: 700;
            color: #003a6e;
            line-height: 1.3;
            letter-spacing: -0.2px;
        }

        .aybu-logo-text .unit-name {
            font-size: 11.5px;
            color: #e04010;
            font-weight: 600;
            line-height: 1.3;
            margin-top: 2px;
        }

        .aybu-nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .aybu-nav a {
            font-size: 13px;
            font-weight: 500;
            color: #333;
            padding: 7px 14px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .aybu-nav a:hover {
            background: #f0f4f8;
            color: #003a6e;
        }

        .aybu-nav .btn-login {
            background: #003a6e;
            color: #fff !important;
            padding: 8px 18px;
            border-radius: 4px;
            font-weight: 600;
        }

        .aybu-nav .btn-login:hover {
            background: #004d99 !important;
            color: #fff !important;
        }

        /* Mobile nav */
        @media (max-width: 768px) {
            .aybu-nav {
                display: none;
            }

            .aybu-mobile-btn {
                display: flex;
            }

            .aybu-logo-text .uni-name {
                font-size: 11px;
            }

            .aybu-logo-text .unit-name {
                font-size: 10px;
            }

            .aybu-logo-area img {
                height: 44px;
            }
        }

        @media (min-width: 769px) {
            .aybu-mobile-btn {
                display: none;
            }
        }

        /* Sections */
        .hero-gradient {
            background: linear-gradient(135deg, #003a6e 0%, #0057a8 50%, #00a3b4 100%);
        }

        .stat-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 58, 110, 0.12);
        }

        .venue-card {
            transition: all 0.2s;
        }

        .venue-card:hover {
            transform: translateY(-2px);
            border-color: #003a6e;
            box-shadow: 0 8px 25px rgba(0, 58, 110, 0.1);
        }

        .step-number {
            background: #003a6e;
            color: #fff;
        }

        .section-title {
            color: #003a6e;
        }

        /* Mobile menu slide */
        #mobile-menu {
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- ── Top Bar (AYBU Stil) ── -->
    <div class="aybu-topbar hidden md:block">
        <div class="max-w-[1200px] mx-auto px-5 flex items-center justify-between">
            <span>Ankara Yıldırım Beyazıt Üniversitesi</span>
            <div class="flex items-center gap-4">
                <a href="https://aybu.edu.tr" target="_blank"
                    class="text-white/70 hover:text-white text-xs transition">aybu.edu.tr</a>
                <span class="text-white/30">|</span>
                <a href="<?= url('giris') ?>" class="text-white/70 hover:text-white text-xs transition">Sisteme
                    Giriş</a>
            </div>
        </div>
    </div>

    <!-- ── Ana Header (AYBU Stil) ── -->
    <header class="aybu-header">
        <div class="aybu-header-inner">
            <!-- Sol: Logo + Üniversite Adı -->
            <a href="<?= url('/') ?>" class="aybu-logo-area">
                <img src="<?= asset('aybu.png') ?>" alt="AYBU Logo">
                <div class="aybu-logo-text">
                    <p class="uni-name">Ankara Yıldırım Beyazıt Üniversitesi</p>
                    <p class="unit-name">İktisadi İşletmeler Müdürlüğü</p>
                </div>
            </a>

            <!-- Sağ: Desktop Nav -->
            <nav class="aybu-nav">
                <a href="#nasil-calisir">Nasıl Çalışır?</a>
                <a href="#isletmeler">İşletmeler</a>
                <a href="#iletisim">İletişim</a>
                <a href="<?= url('giris') ?>" class="btn-login">Giriş Yap</a>
            </nav>

            <!-- Mobil Hamburger -->
            <button id="mobile-menu-btn"
                class="aybu-mobile-btn items-center justify-center p-2 rounded-md text-gray-600 hover:bg-gray-100 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobil Overlay -->
        <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden"></div>

        <!-- Mobil Menü -->
        <div id="mobile-menu"
            class="fixed top-0 right-0 bottom-0 w-72 bg-white shadow-2xl z-50 transform translate-x-full md:hidden">
            <div class="h-full flex flex-col">
                <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-[#003a6e]">
                    <span class="font-bold text-white text-sm">Menü</span>
                    <button id="mobile-close" class="text-white/80 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <nav class="flex-1 px-4 py-6 space-y-1">
                    <a href="#nasil-calisir"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition font-medium">Nasıl
                        Çalışır?</a>
                    <a href="#isletmeler"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition font-medium">İşletmeler</a>
                    <a href="#iletisim"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition font-medium">İletişim</a>
                    <div class="pt-4 mt-4 border-t border-gray-100">
                        <a href="<?= url('giris') ?>"
                            class="block w-full text-center px-4 py-3 bg-[#003a6e] hover:bg-[#004d99] text-white font-semibold rounded-lg transition text-sm">
                            Sisteme Giriş Yap
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- ── Hero ── -->
    <section class="hero-gradient text-white py-24 px-4 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-64 h-64 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-5xl mx-auto text-center relative">
            <div
                class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-medium mb-8 border border-white/20">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse inline-block"></span>
                Sistem aktif — Bağışlar devam ediyor
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black mb-6 leading-tight tracking-tight">
                Paylaşmak Güzeldir,<br class="hidden sm:block">
                <span class="text-[#7dd8f0]">Dayanışmak Daha Güzel</span>
            </h1>
            <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                Askıda Kampüs ile bir kahve, bir simit ya da bir sandviç bırak —
                ihtiyaç sahibi bir öğrenci kodu söyleyerek teslim alsın.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center flex-wrap">
                <a href="<?= url('misafir-bagis') ?>"
                    class="px-8 py-3.5 bg-white text-[#003a6e] font-bold rounded-lg hover:bg-gray-100 transition text-base shadow-xl">
                    🤝 Bağış Yap
                </a>
                <a href="<?= url('kayit') ?>"
                    class="px-8 py-3.5 bg-[#e04010] hover:bg-[#c0350d] text-white font-bold rounded-lg transition text-base shadow-xl">
                    Öğrenci Kaydı
                </a>
                <a href="<?= url('giris') ?>"
                    class="px-8 py-3.5 bg-white/15 hover:bg-white/25 text-white font-semibold rounded-lg transition text-base backdrop-blur-sm border border-white/30">
                    Giriş Yap
                </a>
            </div>
        </div>
    </section>

    <!-- ── İstatistikler ── -->
    <section class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 py-10 grid grid-cols-2 sm:grid-cols-4 gap-6">
            <div class="stat-card text-center p-4 rounded-xl bg-blue-50 border border-blue-100">
                <p class="text-3xl font-black text-[#003a6e]"><?= e($stats['venues']) ?>+</p>
                <p class="text-sm text-gray-600 mt-1 font-medium">Katılımcı İşletme</p>
            </div>
            <div class="stat-card text-center p-4 rounded-xl bg-green-50 border border-green-100">
                <p class="text-3xl font-black text-green-700"><?= e($stats['donations']) ?>+</p>
                <p class="text-sm text-gray-600 mt-1 font-medium">Toplam Bağış</p>
            </div>
            <div class="stat-card text-center p-4 rounded-xl bg-purple-50 border border-purple-100">
                <p class="text-3xl font-black text-purple-700"><?= e($stats['reservations']) ?>+</p>
                <p class="text-sm text-gray-600 mt-1 font-medium">Teslim Edilen</p>
            </div>
            <div class="stat-card text-center p-4 rounded-xl bg-orange-50 border border-orange-100">
                <p class="text-3xl font-black text-orange-600"><?= e($stats['stock']) ?>+</p>
                <p class="text-sm text-gray-600 mt-1 font-medium">Serbest Ürün</p>
            </div>
        </div>
    </section>

    <!-- ── Nasıl Çalışır ── -->
    <section id="nasil-calisir" class="py-20 px-4 bg-gray-50">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black section-title mb-3">Nasıl Çalışır?</h2>
                <p class="text-gray-500 text-base">Üç adımda yardım et, üç adımda yararlan</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Bağışçı -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-2xl">🤝
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Bağışçılar İçin</h3>
                            <p class="text-xs text-gray-400">Destek olmak isteyenler</p>
                        </div>
                    </div>
                    <ol class="space-y-4">
                        <li class="flex items-start gap-4">
                            <span
                                class="step-number w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">1</span>
                            <p class="text-gray-600 text-sm leading-relaxed">Sisteme giriş yapın ve kampüsdeki katılımcı
                                işletmeleri görün.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span
                                class="step-number w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">2</span>
                            <p class="text-gray-600 text-sm leading-relaxed">Bağışlamak istediğiniz ürünleri ve
                                miktarları seçin.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span
                                class="step-number w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">3</span>
                            <p class="text-gray-600 text-sm leading-relaxed">IBAN üzerinden ödeme yapın — bağışınız
                                onaylandıktan sonra stoğa eklenir.</p>
                        </li>
                    </ol>
                    <a href="<?= url('giris') ?>"
                        class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition">
                        Bağış Yapmak İstiyorum →
                    </a>
                </div>

                <!-- Öğrenci -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-2xl">🎓
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">Öğrenciler İçin</h3>
                            <p class="text-xs text-gray-400">Yararlanmak isteyenler</p>
                        </div>
                    </div>
                    <ol class="space-y-4">
                        <li class="flex items-start gap-4">
                            <span
                                class="step-number w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">1</span>
                            <p class="text-gray-600 text-sm leading-relaxed">Öğrenci hesabınızla giriş yapın, açık
                                işletmeleri ve ürünleri görün.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span
                                class="step-number w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">2</span>
                            <p class="text-gray-600 text-sm leading-relaxed">İstediğiniz ürünü rezerve edin — size özel
                                bir teslim kodu oluşturulur.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span
                                class="step-number w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">3</span>
                            <p class="text-gray-600 text-sm leading-relaxed">İşletmeye gidin, kasiyere kodunuzu söyleyin
                                ve ürününüzü teslim alın.</p>
                        </li>
                    </ol>
                    <a href="<?= url('giris') ?>"
                        class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-[#003a6e] hover:bg-[#004d99] text-white text-sm font-semibold rounded-lg transition">
                        Rezervasyon Yapmak İstiyorum →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ── İşletmeler ── -->
    <?php if (!empty($venues)): ?>
        <section id="isletmeler" class="bg-white py-20 px-4 border-t border-gray-100">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-black section-title mb-3">Katılımcı İşletmeler</h2>
                    <p class="text-gray-500 text-base">Bu işletmelerde askıda ürün rezervasyonu yapabilirsiniz</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <?php foreach ($venues as $v): ?>
                        <a href="<?= url('isletme/' . $v['id']) ?>"
                            class="venue-card border border-gray-200 rounded-2xl p-5 block bg-white hover:shadow-md">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-[#003a6e]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <span
                                        class="text-[#003a6e] font-black text-base"><?= mb_substr(e($v['name']), 0, 1) ?></span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-800 text-sm"><?= e($v['name']) ?></p>
                                    <p class="text-xs text-gray-400 mt-0.5"><?= e($v['campus_name']) ?></p>
                                    <?php if ($v['location']): ?>
                                        <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <?= e($v['location']) ?>
                                        </p>
                                    <?php endif; ?>
                                    <span class="inline-flex items-center gap-1 mt-2 text-xs text-[#003a6e] font-semibold">
                                        Detayları Gör →
                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ── İletişim ── -->
    <section id="iletisim" class="bg-[#003a6e] py-16 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
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

    <!-- ── Footer ── -->
    <footer class="bg-[#001f3f] text-white">
        <div class="max-w-5xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Logo -->
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-12 w-auto">
                    <span class="text-xl font-black text-white">AYBÜ</span>
                </div>
                <p class="text-[#7dd8f0] text-sm font-light italic leading-snug">Geçmişten Geleceğe...</p>
                <div class="flex items-center gap-2 mt-1">
                    <a href="https://instagram.com/aybu_resmi" target="_blank"
                        class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <svg class="w-3.5 h-3.5 fill-white" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="https://x.com/aybu_resmi" target="_blank"
                        class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <svg class="w-3.5 h-3.5 fill-white" viewBox="0 0 24 24">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.261 5.638 5.902-5.638zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                    </a>
                    <a href="https://youtube.com/@aybu" target="_blank"
                        class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <svg class="w-3.5 h-3.5 fill-white" viewBox="0 0 24 24">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>
                    <a href="https://aybu.edu.tr" target="_blank"
                        class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                        <svg class="w-3.5 h-3.5 fill-white" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Hızlı Erişim -->
            <div class="border-l border-white/10 pl-10">
                <h4 class="text-white/40 text-xs font-bold uppercase tracking-widest mb-4">Hızlı Erişim</h4>
                <ul class="space-y-2.5 text-sm text-white/60">
                    <li><a href="<?= url('giris') ?>" class="hover:text-white transition">Sisteme Giriş Yap</a></li>
                    <li><a href="#nasil-calisir" class="hover:text-white transition">Nasıl Çalışır?</a></li>
                    <li><a href="#isletmeler" class="hover:text-white transition">Katılımcı İşletmeler</a></li>
                    <li><a href="<?= url('misafir-bagis') ?>" class="hover:text-white transition">Misafir Bağış</a></li>
                </ul>
            </div>

            <!-- AYBU Linkleri -->
            <div>
                <h4 class="text-white/40 text-xs font-bold uppercase tracking-widest mb-4">AYBÜ Bağlantıları</h4>
                <ul class="space-y-2.5 text-sm text-white/60">
                    <li><a href="https://aybu.edu.tr" target="_blank" class="hover:text-white transition">Ana Web
                            Sitesi</a></li>
                    <li><a href="https://aybu.edu.tr/iktisadi.isletme/tr" target="_blank"
                            class="hover:text-white transition">İktisadi İşletmeler Müdürlüğü</a></li>
                    <li><a href="https://obs.aybu.edu.tr" target="_blank" class="hover:text-white transition">Öğrenci
                            Bilgi Sistemi</a></li>
                </ul>
            </div>
        </div>

        <!-- Alt bar -->
        <div class="border-t border-white/10">
            <div
                class="max-w-5xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/30">
                <p>© <?= date('Y') ?> Ankara Yıldırım Beyazıt Üniversitesi. Tüm hakları saklıdır.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-white transition">Erişilebilirlik</a>
                    <a href="#" class="hover:text-white transition">Gizlilik Politikası</a>
                    <a href="#" class="hover:text-white transition">KVKK</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobil menü
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const mobileClose = document.getElementById('mobile-close');

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

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
            });
        });
    </script>
</body>

</html>