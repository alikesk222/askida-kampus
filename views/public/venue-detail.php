<!DOCTYPE html>
<html lang="<?= current_lang() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> — Askıda Kampüs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

<header class="bg-white border-b border-gray-200">
    <div class="max-w-5xl mx-auto px-6 flex items-center justify-between h-[68px]">
        <a href="<?= url('/') ?>" class="flex items-center gap-3">
            <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-11 w-auto"
                 onerror="this.src='https://aybu.edu.tr/assets/images/aybu-images/logo-dark.png'">
            <div class="border-l border-gray-300 pl-3">
                <p class="text-[13px] font-semibold text-gray-800 leading-tight"><?= t('common.univ') ?></p>
                <p class="text-[11px] text-gray-500 leading-tight"><?= t('common.dept') ?></p>
            </div>
        </a>
        <div class="flex items-center gap-3 text-sm">
            <?php $cl = current_lang(); ?>
            <div class="flex items-center border border-gray-200 rounded-md overflow-hidden text-xs font-bold">
                <a href="<?= url('lang/tr') ?>" class="px-2.5 py-1.5 <?= $cl === 'tr' ? 'bg-[#00A3B4] text-white' : 'text-gray-500 hover:bg-gray-50' ?> transition">TR</a>
                <a href="<?= url('lang/en') ?>" class="px-2.5 py-1.5 <?= $cl === 'en' ? 'bg-[#00A3B4] text-white' : 'text-gray-500 hover:bg-gray-50' ?> transition">EN</a>
            </div>
            <a href="<?= url('misafir-bagis') ?>" class="text-gray-600 hover:text-gray-800 transition"><?= t('nav.donate') ?></a>
            <a href="<?= url('giris') ?>"
               class="px-4 py-1.5 text-white rounded font-medium transition text-sm"
               style="background:#009999;"><?= t('nav.login') ?></a>
        </div>
    </div>
</header>

<div class="flex-1">


    <div class="bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-6 py-6">
            <div class="mb-4 text-sm text-gray-400">
                <a href="<?= url('/') ?>" class="hover:text-[#00A3B4] transition"><?= t('nav.home') ?></a>
                <span class="mx-2 text-gray-300">›</span>
                <span class="text-gray-600"><?= e($venue['name']) ?></span>
            </div>

            <div class="flex items-start gap-5">
                <div class="w-16 h-16 rounded-2xl flex-shrink-0 flex items-center justify-center text-white text-2xl font-bold shadow-sm"
                     style="background:linear-gradient(135deg,#00A3B4,#006B76);">
                    <?= mb_strtoupper(mb_substr(e($venue['name']), 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 flex-wrap">
                        <h1 class="text-2xl font-bold text-gray-900"><?= e($venue['name']) ?></h1>
                        <?php
                        $isOpen = true;
                        if ($venue['opens_at'] && $venue['closes_at']) {
                            $now    = new DateTime();
                            $opens  = DateTime::createFromFormat('H:i:s', $venue['opens_at']);
                            $closes = DateTime::createFromFormat('H:i:s', $venue['closes_at']);
                            $cur    = DateTime::createFromFormat('H:i:s', $now->format('H:i:s'));
                            $isOpen = ($cur >= $opens && $cur <= $closes);
                        }
                        ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold
                            <?= $isOpen ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-gray-100 text-gray-500 ring-1 ring-gray-200' ?>">
                            <span class="w-1.5 h-1.5 rounded-full <?= $isOpen ? 'bg-emerald-500' : 'bg-gray-400' ?>"></span>
                            <?= $isOpen ? t('venue.open') : t('venue.closed') ?>
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1"><?= e($venue['campus_name']) ?></p>
                    <div class="flex items-center flex-wrap gap-4 mt-3 text-xs text-gray-500">
                        <?php if ($venue['location']): ?>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <?= e($venue['location']) ?>
                        </span>
                        <?php endif; ?>
                        <?php if ($venue['opens_at'] && $venue['closes_at']): ?>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <?= e(substr($venue['opens_at'], 0, 5)) ?> – <?= e(substr($venue['closes_at'], 0, 5)) ?>
                        </span>
                        <?php endif; ?>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <?= count($products) ?> <?= t('common.items') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 py-8">


        <div class="flex items-center justify-between mb-5">
            <h2 class="text-base font-bold text-gray-800"><?= t('venue.avail_products') ?></h2>
            <span class="text-xs text-gray-400"><?= count($products) ?> <?= t('common.items') ?></span>
        </div>

        <?php if (empty($products)): ?>
        <div class="bg-white border border-gray-200 rounded-2xl p-14 text-center">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p class="text-gray-400 text-sm"><?= t('venue.no_products') ?></p>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            <?php foreach ($products as $p): ?>
            <?php $free = $stocks[$p['id']] ?? 0; ?>
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-md hover:border-gray-300 transition-all duration-200 <?= $free <= 0 ? 'opacity-60' : '' ?>">

                <?php if (!empty($p['image_url'])): ?>
                <div class="relative h-44 bg-gray-100 overflow-hidden">
                    <img src="<?= url($p['image_url']) ?>"
                         alt="<?= e(pname($p)) ?>"
                         class="w-full h-full object-cover">
                    <div class="absolute top-2.5 right-2.5">
                        <?php if ($free > 0): ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/90 backdrop-blur-sm text-emerald-700 text-[11px] font-semibold rounded-full shadow-sm ring-1 ring-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <?= t('venue.in_stock') ?>
                        </span>
                        <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-1 bg-white/90 backdrop-blur-sm text-gray-500 text-[11px] font-semibold rounded-full shadow-sm ring-1 ring-gray-200">
                            <?= t('venue.out_of_stock') ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="relative h-44 flex items-center justify-center" style="background:linear-gradient(135deg,#e8f7f9,#d0eef1);">
                    <svg class="w-12 h-12 text-[#00A3B4]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <div class="absolute top-2.5 right-2.5">
                        <?php if ($free > 0): ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/90 text-emerald-700 text-[11px] font-semibold rounded-full shadow-sm ring-1 ring-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <?= t('venue.in_stock') ?>
                        </span>
                        <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-1 bg-white/90 text-gray-500 text-[11px] font-semibold rounded-full shadow-sm ring-1 ring-gray-200">
                            <?= t('venue.out_of_stock') ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="p-4">
                    <?php if ($p['category']): ?>
                    <span class="inline-block text-[10px] font-semibold uppercase tracking-wide text-[#00A3B4] bg-[#e8f7f9] px-2 py-0.5 rounded-md mb-2"><?= e($p['category']) ?></span>
                    <?php endif; ?>
                    <h3 class="font-semibold text-gray-800 text-sm leading-snug"><?= e(pname($p)) ?></h3>
                    <?php if ($p['description']): ?>
                    <p class="text-xs text-gray-400 mt-1 line-clamp-2"><?= e($p['description']) ?></p>
                    <?php endif; ?>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500"><?= t('student.stock') ?>:
                            <span class="font-bold <?= $free > 0 ? 'text-[#00A3B4]' : 'text-gray-400' ?>"><?= $free ?></span>
                        </span>
                        <span class="text-xs font-semibold text-gray-500"><?= number_format($p['price_snapshot'], 2) ?> ₺</span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>


        <div class="rounded-2xl overflow-hidden" style="background:linear-gradient(135deg,#00A3B4,#006B76);">
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-5">
                <div class="text-white text-center sm:text-left">
                    <p class="font-bold text-lg"><?= t('venue.cta_title') ?></p>
                    <p class="text-sm text-white/70 mt-1"><?= t('venue.cta_desc') ?></p>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="<?= url('misafir-bagis/' . $venue['id']) ?>"
                       class="px-5 py-2.5 text-sm font-semibold bg-white/15 hover:bg-white/25 text-white rounded-xl transition border border-white/30">
                        <?= t('nav.donate') ?>
                    </a>
                    <a href="<?= url('giris') ?>"
                       class="px-5 py-2.5 text-sm font-semibold bg-white text-[#006B76] rounded-xl hover:bg-gray-50 transition shadow-sm">
                        <?= t('nav.login') ?>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<footer class="border-t border-gray-200 bg-white text-center py-5 text-xs text-gray-400 mt-auto">
    <?= t('common.copyright', ['year' => date('Y')]) ?>
</footer>

</body>
</html>
