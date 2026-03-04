<!DOCTYPE html>
<html lang="tr" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="page-title">İftar Programı — AYBU İktisadi İşletmeler Müdürlüğü</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        :root { --teal: #0097a7; --teal-dark: #006978; --navy: #1a3560; }
        .menu-card { transition: all .2s ease; cursor: pointer; border: 2px solid #e5e7eb; }
        .menu-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,151,167,.12); border-color: #0097a7; }
        .menu-card.selected { border-left-color: #0097a7 !important; background: #f0fdfe !important; box-shadow: 0 4px 16px rgba(0,151,167,.14); }
        .menu-card.selected .sel-dot { background:#0097a7; border-color:#0097a7; }
        .copy-btn:active { transform: scale(.95); }
        .fade-in { animation: fadeIn .35s ease; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
        .lang-btn.active { background:#0097a7; color:#fff; }
        .underline-title::after { content:''; display:block; width:48px; height:3px; background:#0097a7; margin-top:6px; border-radius:2px; }
        .nav-link { color:#333; font-size:.85rem; font-weight:500; padding:4px 10px; border-radius:4px; transition:color .15s; }
        .nav-link:hover { color:#0097a7; }
    </style>
</head>
<body class="min-h-screen bg-[#f5f6f8] flex flex-col">

<!-- TOP BAR -->
<div class="bg-[#1a3560] text-white text-xs py-1.5 px-4">
    <div class="max-w-6xl mx-auto flex justify-end items-center gap-3">
        <a href="https://www.aybu.edu.tr" target="_blank" class="text-white/60 hover:text-white transition">aybu.edu.tr</a>
        <span class="text-white/30">|</span>
        <div class="flex gap-1">
            <button onclick="setLang('tr')" id="btn-tr" class="lang-btn active text-xs px-2 py-0.5 rounded font-semibold transition">TR</button>
            <button onclick="setLang('en')" id="btn-en" class="lang-btn text-xs px-2 py-0.5 rounded font-semibold text-white/60 hover:text-white transition">EN</button>
        </div>
    </div>
</div>

<!-- HEADER — resmi site stili -->
<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-[76px]">
        <a href="https://www.aybu.edu.tr" target="_blank" class="flex items-center gap-3">
            <img src="assets/aybu.png" alt="AYBU" class="h-12 w-auto">
            <div class="border-l-2 border-[#0097a7] pl-3">
                <p class="text-[13px] font-bold text-[#1a3560] leading-tight" data-tr="Ankara Yıldırım Beyazıt Üniversitesi" data-en="Ankara Yıldırım Beyazıt University">Ankara Yıldırım Beyazıt Üniversitesi</p>
                <p class="text-[11px] text-[#0097a7] font-semibold leading-tight" data-tr="İktisadi İşletmeler Müdürlüğü" data-en="Directorate of Economic Enterprises">İktisadi İşletmeler Müdürlüğü</p>
            </div>
        </a>
        <!-- Nav links -->
        <nav class="hidden lg:flex items-center gap-1">
            <a href="#" class="nav-link" data-tr="Hakkımızda" data-en="About Us">Hakkımızda</a>
            <a href="#" class="nav-link" data-tr="Yönetim" data-en="Management">Yönetim</a>
            <a href="#" class="nav-link" data-tr="İletişim" data-en="Contact">İletişim</a>
        </nav>
    </div>
    <!-- Alt teal çizgi -->
    <div class="h-[3px] bg-gradient-to-r from-[#0097a7] via-[#00bcd4] to-[#0097a7]"></div>
</header>

<!-- BREADCRUMB -->
<div class="bg-white border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-6 py-2 flex items-center gap-2 text-xs text-gray-400">
        <a href="https://www.aybu.edu.tr" class="hover:text-[#0097a7] transition" data-tr="Ana Sayfa" data-en="Home">Ana Sayfa</a>
        <span>/</span>
        <span class="text-[#0097a7] font-medium" data-tr="İftar Programı" data-en="Iftar Program">İftar Programı</span>
    </div>
</div>

<!-- SAYFA BAŞLIĞI -->
<div class="bg-white border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-6 py-6">
        <div class="inline-block bg-[#0097a7] text-white text-[11px] font-semibold px-3 py-1 rounded mb-3 tracking-wide"
             data-tr="RAMAZAN İFTAR PROGRAMI" data-en="RAMADAN IFTAR PROGRAM">RAMAZAN İFTAR PROGRAMI</div>
        <h1 class="text-2xl font-bold text-[#1a3560] mb-1"
            data-tr="İftar Menüsü Ön Ödeme" data-en="Iftar Menu Pre-Payment">İftar Menüsü Ön Ödeme</h1>
        <p class="text-sm text-gray-500"
           data-tr="Yemek alım sırasında aksama yaşanmaması için lütfen menünüzü seçin ve ücretini IBAN ile önceden ödeyin."
           data-en="To avoid disruptions during meal service, please select your menu and pay in advance via IBAN transfer.">
            Yemek alım sırasında aksama yaşanmaması için lütfen menünüzü seçin ve ücretini IBAN ile önceden ödeyin.
        </p>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="flex-1 max-w-6xl mx-auto w-full px-4 sm:px-6 py-8">

    <!-- Bilgilendirme banner -->
    <div class="bg-[#e3f6f8] border-l-4 border-[#0097a7] rounded-r-lg p-4 mb-8 flex items-start gap-3">
        <svg class="w-5 h-5 text-[#0097a7] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
        <p class="text-sm text-[#006978]"
           data-tr="Aşağıdaki menülerden birini seçin, ardından belirtilen IBAN numarasına havale/EFT yapın. <strong>Ödeme sırasında açıklama alanına mutlaka Ad Soyadınızı yazınız.</strong> Yemek alımında ödeme dekontunuzu ibraz etmeniz gerekmektedir."
           data-en="Select one of the menus below, then make a wire transfer to the provided IBAN. <strong>Please write your full name in the transfer description.</strong> You must present your payment receipt when collecting your meal.">
            Aşağıdaki menülerden birini seçin, ardından belirtilen IBAN numarasına havale/EFT yapın. <strong>Ödeme sırasında açıklama alanına mutlaka Ad Soyadınızı yazınız.</strong> Yemek alımında ödeme dekontunuzu ibraz etmeniz gerekmektedir.
        </p>
    </div>

    <!-- SOL FOTO + SAĞ MENÜLER iki sütun layout -->
    <div class="flex flex-col lg:flex-row gap-8 mb-10">

        <!-- SOL: Fotoğraf -->
        <div class="lg:w-2/5 flex-shrink-0">
            <img src="assets/iftar.jpg" alt="İftar Programı"
                 class="w-full h-full object-cover rounded-lg shadow-sm" style="max-height:520px; object-position:center">
        </div>

        <!-- SAĞ: Menü başlığı + 2li grid -->
        <div class="flex-1 flex flex-col">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-[#1a3560] underline-title"
                    data-tr="Menü Seçimi" data-en="Menu Selection">Menü Seçimi</h2>
                <p class="text-sm text-gray-400 mt-2"
                   data-tr="Bir menü seçiniz. Ödeme bilgileri aşağıda görünecektir."
                   data-en="Select a menu. Payment details will appear below.">Bir menü seçiniz. Ödeme bilgileri aşağıda görünecektir.</p>
            </div>

            <!-- MENÜ KARTLARI 2li grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 flex-1" id="menu-grid">

        <?php
        $menus = [
            ['id'=>1,'emoji'=>'','color'=>'red',  'name_tr'=>'Kavurma / Et Menü',  'name_en'=>'Meat Menu',
             'sub_tr'=>'Kavurma / Köfte / Et Döner','sub_en'=>'Roasted Meat / Meatball / Doner',
             'price'=>650,
             'items_tr'=>['Çorba','Pilav','Patates','Çiğ Köfte','İftariyelik','Tarator','Tatlı','Ayran','Su','Çay'],
             'items_en'=>['Soup','Rice','Potatoes','Raw Meatball','Iftar Starter','Tarator','Dessert','Ayran','Water','Tea']],
            ['id'=>2,'emoji'=>'','color'=>'orange','name_tr'=>'Pide Menü',           'name_en'=>'Pide Menu',
             'sub_tr'=>'Kıymalı Pide / Kaşarlı Pide / Lahmacun (2 Adet)','sub_en'=>'Minced Pide / Cheese Pide / Lahmacun (x2)',
             'price'=>600,
             'items_tr'=>['Çorba','Çiğ Köfte','İftariyelik','Tarator','Tatlı','Ayran','Su','Çay'],
             'items_en'=>['Soup','Raw Meatball','Iftar Starter','Tarator','Dessert','Ayran','Water','Tea']],
            ['id'=>3,'emoji'=>'','color'=>'yellow','name_tr'=>'Tavuk Menü',          'name_en'=>'Chicken Menu',
             'sub_tr'=>'Tavuk Döner / Julyan Izgara / Tavuk İskender','sub_en'=>'Chicken Doner / Julienne Grill / Chicken Iskender',
             'price'=>550,
             'items_tr'=>['Çorba','Pilav','Patates','Çiğ Köfte','İftariyelik','Tarator','Tatlı','Ayran','Su','Çay'],
             'items_en'=>['Soup','Rice','Potatoes','Raw Meatball','Iftar Starter','Tarator','Dessert','Ayran','Water','Tea']],
            ['id'=>4,'emoji'=>'','color'=>'green', 'name_tr'=>'Güveç Menü',          'name_en'=>'Casserole Menu',
             'sub_tr'=>'Güveç','sub_en'=>'Clay Pot Casserole',
             'price'=>700,
             'items_tr'=>['Çorba','Pilav','Patates','Salata','Yoğurtlu Meze','Çiğ Köfte','İftariyelik','Tatlı','Ayran','Su','Çay'],
             'items_en'=>['Soup','Rice','Potatoes','Salad','Yogurt Meze','Raw Meatball','Iftar Starter','Dessert','Ayran','Water','Tea']],
        ];
        foreach ($menus as $m):
        ?>
        <div class="menu-card bg-white rounded-lg p-5 shadow-sm select-none border-l-4 border-transparent"
             onclick="selectMenu(this)"
             data-id="<?= $m['id'] ?>"
             data-name-tr="<?= $m['name_tr'] ?>"
             data-name-en="<?= $m['name_en'] ?>"
             data-price="<?= $m['price'] ?>">

            <!-- Kart başlığı -->
            <div class="flex items-start justify-between mb-2">
                <div>
                    <p class="font-bold text-[#1a3560] text-sm leading-snug lang-tr"><?= $m['name_tr'] ?></p>
                    <p class="font-bold text-[#1a3560] text-sm leading-snug lang-en hidden"><?= $m['name_en'] ?></p>
                    <p class="text-xs text-gray-400 mt-0.5 lang-tr"><?= $m['sub_tr'] ?></p>
                    <p class="text-xs text-gray-400 mt-0.5 lang-en hidden"><?= $m['sub_en'] ?></p>
                </div>
                <div class="sel-dot w-5 h-5 rounded-full border-2 border-gray-300 flex-shrink-0 mt-0.5 transition-all"></div>
            </div>

            <!-- Fiyat -->
            <p class="text-2xl font-extrabold text-[#0097a7] mb-3"><?= number_format($m['price']) ?> ₺</p>

            <!-- İçerik listesi -->
            <div class="border-t border-gray-100 pt-3 grid grid-cols-2 gap-x-2 gap-y-1">
                <?php foreach ($m['items_tr'] as $k => $item): ?>
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <span class="w-1 h-1 rounded-full bg-[#0097a7] flex-shrink-0"></span>
                    <span class="lang-tr"><?= $item ?></span>
                    <span class="lang-en hidden"><?= $m['items_en'][$k] ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
            </div><!-- /menü grid -->
        </div><!-- /sağ kolon -->
    </div><!-- /iki sütun layout -->

    <!-- ÖDEME BÖLÜMİ -->
    <div id="payment-section" class="hidden fade-in">

        <!-- Seçim özeti -->
        <div class="bg-[#1a3560] text-white rounded-xl p-5 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs text-white/50 uppercase tracking-widest mb-1 lang-tr">Seçilen Menü</p>
                <p class="text-xs text-white/50 uppercase tracking-widest mb-1 lang-en hidden">Selected Menu</p>
                <p id="summary-name" class="text-lg font-bold"></p>
            </div>
            <div class="sm:text-right">
                <p class="text-xs text-white/50 uppercase tracking-widest mb-1 lang-tr">Ödenecek Tutar</p>
                <p class="text-xs text-white/50 uppercase tracking-widest mb-1 lang-en hidden">Amount Due</p>
                <p id="summary-price" class="text-3xl font-extrabold text-[#00bcd4]"></p>
            </div>
        </div>

        <!-- IBAN Kartı -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="font-bold text-[#1a3560] mb-5 flex items-center gap-2 text-base">
                <div class="w-7 h-7 bg-[#0097a7] rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <span data-tr="Havale / EFT Bilgileri" data-en="Wire Transfer Details">Havale / EFT Bilgileri</span>
            </h3>

            <!-- IBAN satırı -->
            <div class="mb-4">
                <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-2">IBAN</p>
                <div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                    <span class="font-mono text-sm font-bold text-gray-800 tracking-widest flex-1 select-all">
                        TR10 0001 2009 1940 0006 0000 56
                    </span>
                    <button onclick="copyText('TR10000120091940000600 0056', this, 'iban')"
                        class="copy-btn flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#0097a7] hover:bg-[#006978] text-white text-xs font-semibold rounded-lg transition"
                        data-tr-copy="Kopyala" data-en-copy="Copy">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="lang-tr">Kopyala</span><span class="lang-en hidden">Copy</span>
                    </button>
                </div>
            </div>

            <!-- Hesap adı satırı -->
            <div class="mb-5">
                <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider mb-2"
                   data-tr="Hesap Adı" data-en="Account Name">Hesap Adı</p>
                <div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                    <span class="text-sm font-semibold text-gray-800 flex-1 select-all leading-snug">
                        YILDIRIM BEYAZIT ÜNİ V.İKT.İŞLT.MÜD.YÜRÜTME KURULU BAŞKANLIĞI
                    </span>
                    <button onclick="copyText('YILDIRIM BEYAZIT UNI V.IKT.ISLT.MUD.YURUTME KURULU BASKANLIGI', this)"
                        class="copy-btn flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#0097a7] hover:bg-[#006978] text-white text-xs font-semibold rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="lang-tr">Kopyala</span><span class="lang-en hidden">Copy</span>
                    </button>
                </div>
            </div>

            <!-- Uyarı kutusu -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-amber-800 mb-0.5"
                       data-tr="Açıklama Alanına Dikkat!" data-en="Important: Transfer Description">Açıklama Alanına Dikkat!</p>
                    <p class="text-xs text-amber-700"
                       data-tr="Havale / EFT yaparken açıklama alanına <strong>Ad Soyadınızı</strong> yazınız. Açıklama olmayan ödemeler eşleştirilemeyebilir."
                       data-en="Please write your <strong>full name</strong> in the transfer description. Payments without a name cannot be matched.">
                        Havale / EFT yaparken açıklama alanına <strong>Ad Soyadınızı</strong> yazınız. Açıklama olmayan ödemeler eşleştirilemeyebilir.
                    </p>
                </div>
            </div>
        </div>

        <!-- Onay kutusu -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h3 class="font-bold text-[#1a3560] mb-4 text-base flex items-center gap-2">
                <div class="w-7 h-7 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span data-tr="Ödeme Onayı" data-en="Payment Confirmation">Ödeme Onayı</span>
            </h3>

            <label class="flex items-start gap-3 cursor-pointer mb-5 group">
                <input type="checkbox" id="confirm-cb" onchange="toggleConfirm()"
                    class="mt-0.5 w-5 h-5 accent-[#0097a7] flex-shrink-0 cursor-pointer">
                <span class="text-sm text-gray-700 leading-relaxed">
                    <span class="lang-tr">Yukarıdaki IBAN numarasına <strong id="cb-price" class="text-[#0097a7]"></strong> tutarında havale / EFT yaptım. Açıklama alanına ad ve soyadımı yazdım.</span>
                    <span class="lang-en hidden">I have transferred <strong id="cb-price-en" class="text-[#0097a7]"></strong> to the IBAN above. I have written my full name in the transfer description.</span>
                </span>
            </label>

            <div id="confirm-box" class="hidden fade-in">
                <div class="bg-green-50 border border-green-200 rounded-xl p-5 flex items-start gap-4 mb-4">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-green-800 mb-1"
                           data-tr="Teşekkürler!" data-en="Thank You!">Teşekkürler!</p>
                        <p class="text-sm text-green-700"
                           data-tr="Ödemenizi onayladınız. Yemek alım sırasında <strong>ödeme dekontunuzu göstermeniz rica olunur.</strong>"
                           data-en="Your payment has been confirmed. Please <strong>present your payment receipt</strong> when collecting your meal.">
                            Ödemenizi onayladınız. Yemek alım sırasında <strong>ödeme dekontunuzu göstermeniz rica olunur.</strong>
                        </p>
                    </div>
                </div>
                <div class="bg-[#e3f6f8] border border-[#0097a7]/30 rounded-lg p-4 flex items-start gap-3">
                    <span class="text-xl flex-shrink-0">📱</span>
                    <p class="text-sm text-[#006978]"
                       data-tr="Banka uygulamanızdan işlem dekontunu ekran görüntüsü olarak kaydedin. <strong>Yemek alım sırasında dekontunuzu göstermeniz gerekmektedir.</strong>"
                       data-en="Save your bank transaction receipt as a screenshot. <strong>You must show your receipt when collecting your meal.</strong>">
                        Banka uygulamanızdan işlem dekontunu ekran görüntüsü olarak kaydedin. <strong>Yemek alım sırasında dekontunuzu göstermeniz gerekmektedir.</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Seçim yapılmadı -->
    <div id="no-selection" class="bg-white rounded-xl border border-dashed border-gray-300 p-12 text-center">
        <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <p class="font-semibold text-gray-500 mb-1"
           data-tr="Henüz menü seçilmedi" data-en="No menu selected yet">Henüz menü seçilmedi</p>
        <p class="text-sm text-gray-400"
           data-tr="Ödeme bilgilerini görmek için yukarıdan bir menü seçin." data-en="Select a menu above to view payment details.">
            Ödeme bilgilerini görmek için yukarıdan bir menü seçin.
        </p>
    </div>

</div>

<!-- FOOTER -->
<footer class="bg-[#1a3560] text-white mt-auto">
    <div class="max-w-6xl mx-auto px-6 py-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <img src="assets/aybu.png" alt="AYBU" class="h-12 w-auto opacity-90 brightness-200">
                <div class="border-l border-white/20 pl-4">
                    <p class="text-sm font-bold text-white leading-tight">Ankara Yıldırım Beyazıt Üniversitesi</p>
                    <p class="text-xs text-[#00bcd4] leading-tight mt-0.5">İktisadi İşletmeler Müdürlüğü</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs text-white/40">&copy; <?= date('Y') ?> AYBU İktisadi İşletmeler Müdürlüğü</p>
                <p class="text-xs text-white/40 mt-0.5">Tüm hakları saklıdır.</p>
            </div>
        </div>
    </div>
    <div class="h-1 bg-gradient-to-r from-[#0097a7] via-[#00bcd4] to-[#0097a7]"></div>
</footer>

<script>
let currentLang = 'tr';

/* ── Dil sistemi ── */
function setLang(lang) {
    currentLang = lang;
    document.getElementById('html-root').lang = lang;

    // lang-tr / lang-en göster/gizle
    document.querySelectorAll('.lang-tr').forEach(el => el.classList.toggle('hidden', lang !== 'tr'));
    document.querySelectorAll('.lang-en').forEach(el => el.classList.toggle('hidden', lang !== 'en'));

    // data-tr / data-en ile text update
    document.querySelectorAll('[data-tr]').forEach(el => {
        el.innerHTML = el.dataset[lang] || el.dataset.tr;
    });

    // Aktif buton
    document.getElementById('btn-tr').classList.toggle('active', lang === 'tr');
    document.getElementById('btn-en').classList.toggle('active', lang === 'en');
    document.getElementById('btn-tr').classList.toggle('text-white/60', lang !== 'tr');
    document.getElementById('btn-en').classList.toggle('text-white/60', lang !== 'en');

    // Özet güncelle
    const sel = document.querySelector('.menu-card.selected');
    if (sel) {
        document.getElementById('summary-name').textContent = sel.dataset['name' + lang.charAt(0).toUpperCase() + lang.slice(1)] || sel.dataset.nameTr;
    }
}

/* ── Menü seçimi ── */
function selectMenu(el) {
    document.querySelectorAll('.menu-card').forEach(c => {
        c.classList.remove('selected');
        const d = c.querySelector('.sel-dot');
        d.style.cssText = '';
        d.innerHTML = '';
    });

    el.classList.add('selected');
    const dot = el.querySelector('.sel-dot');
    dot.style.backgroundColor = '#0097a7';
    dot.style.borderColor = '#0097a7';
    dot.innerHTML = '<svg style="width:10px;height:10px" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';

    const nameKey = 'name' + currentLang.charAt(0).toUpperCase() + currentLang.slice(1);
    const name  = el.dataset[nameKey] || el.dataset.nameTr;
    const price = el.dataset.price;

    document.getElementById('no-selection').classList.add('hidden');
    const ps = document.getElementById('payment-section');
    ps.classList.remove('hidden');

    document.getElementById('summary-name').textContent   = name;
    document.getElementById('summary-price').textContent  = Number(price).toLocaleString('tr-TR') + ' ₺';
    document.getElementById('cb-price').textContent       = Number(price).toLocaleString('tr-TR') + ' ₺';
    document.getElementById('cb-price-en').textContent    = Number(price).toLocaleString('tr-TR') + ' ₺';

    document.getElementById('confirm-cb').checked = false;
    document.getElementById('confirm-box').classList.add('hidden');

    setTimeout(() => ps.scrollIntoView({ behavior: 'smooth', block: 'start' }), 120);
}

/* ── Onay checkbox ── */
function toggleConfirm() {
    const cb  = document.getElementById('confirm-cb');
    const box = document.getElementById('confirm-box');
    if (cb.checked) {
        box.classList.remove('hidden');
        setTimeout(() => box.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 100);
    } else {
        box.classList.add('hidden');
    }
}

/* ── Kopyala ── */
function copyText(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const labelTr = btn.querySelector('.lang-tr');
        const labelEn = btn.querySelector('.lang-en');
        const origTr  = labelTr ? labelTr.textContent : '';
        const origEn  = labelEn ? labelEn.textContent : '';
        const origBg  = 'bg-[#0097a7]';

        if (labelTr) labelTr.textContent = '✓ Kopyalandı';
        if (labelEn) labelEn.textContent = '✓ Copied';
        btn.classList.replace('bg-[#0097a7]', 'bg-green-500');

        setTimeout(() => {
            if (labelTr) labelTr.textContent = origTr || 'Kopyala';
            if (labelEn) labelEn.textContent = origEn || 'Copy';
            btn.classList.replace('bg-green-500', 'bg-[#0097a7]');
        }, 2000);
    });
}
</script>
</body>
</html>
