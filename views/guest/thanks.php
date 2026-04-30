<!DOCTYPE html>
<html lang="<?= current_lang() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= t('guest.thanks_title') ?> — Askıda Kampüs</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <?php $cl = current_lang(); ?>
        <div class="flex items-center border border-gray-200 rounded-md overflow-hidden text-xs font-bold">
            <a href="<?= url('lang/tr') ?>" class="px-2.5 py-1.5 <?= $cl === 'tr' ? 'bg-[#00A3B4] text-white' : 'text-gray-500 hover:bg-gray-50' ?> transition">TR</a>
            <a href="<?= url('lang/en') ?>" class="px-2.5 py-1.5 <?= $cl === 'en' ? 'bg-[#00A3B4] text-white' : 'text-gray-500 hover:bg-gray-50' ?> transition">EN</a>
        </div>
    </div>
</header>

<div class="flex-1 flex items-center justify-center p-6">
    <div class="bg-white rounded-2xl shadow-lg p-10 max-w-lg w-full text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2"><?= t('guest.thanks_title') ?></h1>
        <p class="text-gray-500 text-sm mb-6"><?= t('guest.thanks_id') ?> <span class="font-semibold text-gray-700">#<?= e($donationId) ?></span></p>

        <div class="bg-[#E0F7FA] rounded-xl p-5 text-left mb-6">
            <p class="text-sm text-gray-700 font-semibold mb-3"><?= t('guest.thanks_iban') ?></p>
            <p class="font-mono text-sm bg-white rounded-lg px-3 py-2 text-gray-800 tracking-wider break-all"><?= e($iban) ?></p>
            <p class="text-xs text-gray-500 mt-3">
                <?= t('guest.thanks_total') ?> <span class="font-bold text-[#00A3B4]"><?= number_format($totalAmount, 2) ?> ₺</span>
            </p>
            <p class="text-xs text-gray-500 mt-2">
                <?= t('guest.thanks_desc', ['id' => $donationId]) ?>
            </p>
        </div>

        <div class="border-t border-gray-100 pt-6 space-y-3">
            <a href="<?= url('misafir-bagis') ?>"
               class="block w-full py-2.5 bg-[#00A3B4] hover:bg-[#007A8A] text-white font-semibold rounded-xl transition text-sm">
                <?= t('guest.donate_again') ?>
            </a>
            <a href="<?= url('kayit') ?>"
               class="block w-full py-2.5 border border-[#00A3B4] text-[#00A3B4] hover:bg-[#E0F7FA] font-semibold rounded-xl transition text-sm">
                <?= t('guest.track') ?>
            </a>
            <a href="<?= url() ?>" class="block text-xs text-gray-400 hover:text-gray-600 transition">
                <?= t('guest.back_home') ?>
            </a>
        </div>
    </div>
</div>

<footer class="bg-[#0d1b3e] text-white/50 text-xs text-center py-4 mt-auto">
    <?= t('common.copyright', ['year' => date('Y')]) ?>
</footer>
</body>
</html>
