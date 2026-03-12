<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> — Askıda Kampüs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

<!-- Header -->
<header class="bg-white border-b border-gray-200">
    <div class="max-w-5xl mx-auto px-6 flex items-center justify-between h-[68px]">
        <a href="<?= url('/') ?>" class="flex items-center gap-3">
            <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-11 w-auto"
                 onerror="this.src='https://aybu.edu.tr/assets/images/aybu-images/logo-dark.png'">
            <div class="border-l border-gray-300 pl-3">
                <p class="text-[13px] font-semibold text-gray-800 leading-tight">Ankara Yıldırım Beyazıt Üniversitesi</p>
                <p class="text-[11px] text-gray-500 leading-tight">İktisadi İşletmeler Müdürlüğü</p>
            </div>
        </a>
        <div class="flex items-center gap-3 text-sm">
            <a href="<?= url('misafir-bagis') ?>" class="text-gray-600 hover:text-gray-800 transition">Bağış Yap</a>
            <a href="<?= url('giris') ?>"
               class="px-4 py-1.5 text-white rounded font-medium transition text-sm"
               style="background:#009999;">Giriş Yap</a>
        </div>
    </div>
</header>

<div class="flex-1 max-w-5xl mx-auto w-full px-4 py-10">

    <!-- Breadcrumb -->
    <div class="mb-6 text-sm text-gray-400">
        <a href="<?= url('/') ?>" class="hover:text-gray-600 transition">Ana Sayfa</a>
        <span class="mx-2">›</span>
        <span class="text-gray-600 font-medium"><?= e($venue['name']) ?></span>
    </div>

    <!-- İşletme Başlık -->
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6" style="border-top:3px solid #009999;">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded flex items-center justify-center flex-shrink-0 text-white font-bold text-lg"
                         style="background:#0d1f3c;">
                        <?= mb_strtoupper(mb_substr(e($venue['name']), 0, 1)) ?>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800"><?= e($venue['name']) ?></h1>
                        <p class="text-sm text-gray-500 mt-0.5"><?= e($venue['campus_name']) ?></p>
                        <?php if ($venue['location']): ?>
                        <p class="text-xs text-gray-400 mt-1"><?= e($venue['location']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                $isOpen = true;
                if ($venue['opens_at'] && $venue['closes_at']) {
                    $now = new DateTime();
                    $opens  = DateTime::createFromFormat('H:i:s', $venue['opens_at']);
                    $closes = DateTime::createFromFormat('H:i:s', $venue['closes_at']);
                    $cur    = DateTime::createFromFormat('H:i:s', $now->format('H:i:s'));
                    $isOpen = ($cur >= $opens && $cur <= $closes);
                }
                ?>
                <span class="flex-shrink-0 px-3 py-1 rounded text-xs font-semibold
                    <?= $isOpen ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-100 text-gray-500 border border-gray-200' ?>">
                    <?= $isOpen ? 'Açık' : 'Kapalı' ?>
                </span>
            </div>

            <?php if ($venue['opens_at'] && $venue['closes_at']): ?>
            <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2 text-xs text-gray-500">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Çalışma saatleri: <?= e($venue['opens_at']) ?> – <?= e($venue['closes_at']) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Ürünler -->
    <div class="mb-4">
        <h2 class="text-base font-bold text-gray-700 mb-1">Mevcut Ürünler</h2>
        <div style="width:32px;height:2px;background:#009999;border-radius:2px;"></div>
    </div>

    <?php if (empty($products)): ?>
    <div class="bg-white border border-gray-200 rounded-lg p-10 text-center text-gray-400 text-sm">
        Bu işletmede şu an ürün bulunmamaktadır.
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <?php foreach ($products as $p): ?>
        <?php $free = $stocks[$p['id']] ?? 0; ?>
        <div class="bg-white border border-gray-200 rounded-lg p-4 <?= $free <= 0 ? 'opacity-60' : '' ?>">
            <div class="flex items-start justify-between gap-2 mb-2">
                <p class="font-semibold text-gray-800 text-sm"><?= e($p['name']) ?></p>
                <?php if ($free > 0): ?>
                <span class="flex-shrink-0 text-[10px] bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded font-medium">Mevcut</span>
                <?php else: ?>
                <span class="flex-shrink-0 text-[10px] bg-gray-100 text-gray-500 border border-gray-200 px-2 py-0.5 rounded font-medium">Tükendi</span>
                <?php endif; ?>
            </div>
            <?php if ($p['description']): ?>
            <p class="text-xs text-gray-400 mb-2 line-clamp-2"><?= e($p['description']) ?></p>
            <?php endif; ?>
            <?php if ($p['category']): ?>
            <span class="inline-block text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded mb-2"><?= e($p['category']) ?></span>
            <?php endif; ?>
            <div class="flex items-center justify-between pt-2 border-t border-gray-100 mt-2">
                <span class="text-xs text-gray-500">Stok: <span class="font-semibold <?= $free > 0 ? 'text-green-600' : 'text-gray-400' ?>"><?= $free ?> adet</span></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- CTA -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col sm:flex-row items-center justify-between gap-4" style="border-left:3px solid #009999;">
        <div>
            <p class="font-semibold text-gray-800 text-sm">Bu işletmeden yararlanmak veya bağış yapmak ister misiniz?</p>
            <p class="text-xs text-gray-400 mt-0.5">Sisteme giriş yaparak rezervasyon oluşturabilir ya da bağış yapabilirsiniz.</p>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            <a href="<?= url('misafir-bagis/' . $venue['id']) ?>"
               class="px-4 py-2 text-sm font-semibold border border-gray-300 text-gray-700 rounded hover:bg-gray-50 transition">
                Bağış Yap
            </a>
            <a href="<?= url('giris') ?>"
               class="px-4 py-2 text-sm font-semibold text-white rounded transition"
               style="background:#009999;">
                Giriş Yap
            </a>
        </div>
    </div>

</div>

<footer class="border-t border-gray-200 bg-white text-center py-4 text-xs text-gray-400 mt-auto">
    &copy; <?= date('Y') ?> Ankara Yıldırım Beyazıt Üniversitesi — İktisadi İşletmeler Müdürlüğü
</footer>

</body>
</html>
