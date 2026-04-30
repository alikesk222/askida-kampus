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

<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-[72px]">
        <a href="<?= url() ?>" class="flex items-center gap-3">
            <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-12 w-auto">
            <div class="border-l border-gray-300 pl-3">
                <p class="text-[13px] font-semibold text-gray-800 leading-tight"><?= t('common.univ') ?></p>
                <p class="text-[12px] text-gray-500 leading-tight"><?= t('common.dept') ?></p>
            </div>
        </a>
        <div class="flex items-center gap-3 text-sm">
            <?php $cl = current_lang(); ?>
            <div class="flex items-center border border-gray-200 rounded-md overflow-hidden text-xs font-bold">
                <a href="<?= url('lang/tr') ?>" class="px-2.5 py-1.5 <?= $cl === 'tr' ? 'bg-[#00A3B4] text-white' : 'text-gray-500 hover:bg-gray-50' ?> transition">TR</a>
                <a href="<?= url('lang/en') ?>" class="px-2.5 py-1.5 <?= $cl === 'en' ? 'bg-[#00A3B4] text-white' : 'text-gray-500 hover:bg-gray-50' ?> transition">EN</a>
            </div>
            <a href="<?= url('giris') ?>" class="text-gray-600 hover:text-[#00A3B4] transition"><?= t('nav.login') ?></a>
            <a href="<?= url('kayit') ?>" class="px-4 py-1.5 bg-[#00A3B4] text-white rounded-lg hover:bg-[#007A8A] transition"><?= t('nav.register') ?></a>
        </div>
    </div>
</header>

<div class="flex-1 max-w-5xl mx-auto w-full px-4 py-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800"><?= t('guest.title') ?></h1>
        <p class="text-gray-500 text-sm mt-1"><?= t('guest.sub') ?></p>
    </div>

    <div class="border border-gray-200 bg-white rounded-lg p-4 flex items-start gap-3 mb-8" style="border-left:3px solid #009999;">
        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-gray-700"><?= t('guest.account_tip') ?></p>
            <p class="text-sm text-gray-500 mt-0.5"><?= t('guest.account_tip_desc') ?>
                <a href="<?= url('kayit') ?>" class="font-semibold hover:underline" style="color:#009999;"><?= t('guest.create_free') ?></a>.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($venues as $v): ?>
        <a href="<?= url('misafir-bagis/' . $v['id']) ?>"
           class="bg-white rounded-lg border border-gray-200 p-5 block transition hover:border-gray-300" style="border-left:3px solid #009999;">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded flex items-center justify-center flex-shrink-0 text-white font-bold text-sm" style="background:#0d1f3c;">
                    <?= mb_strtoupper(mb_substr(e($v['name']), 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 text-sm"><?= e($v['name']) ?></p>
                    <p class="text-xs text-gray-400"><?= e($v['campus_name']) ?></p>
                </div>
            </div>
            <?php if ($v['location']): ?>
            <p class="text-xs text-gray-400 truncate"><?= e($v['location']) ?></p>
            <?php endif; ?>
            <?php if ($v['opens_at'] && $v['closes_at']): ?>
            <p class="text-xs text-gray-400 mt-0.5"><?= e($v['opens_at']) ?> – <?= e($v['closes_at']) ?></p>
            <?php endif; ?>
            <p class="mt-3 text-xs font-semibold" style="color:#009999;"><?= t('guest.donate_cta') ?></p>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<footer class="bg-[#0d1b3e] text-white/50 text-xs text-center py-4 mt-auto">
    <?= t('common.copyright', ['year' => date('Y')]) ?>
</footer>
</body>
</html>
