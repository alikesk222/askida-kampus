<?php $pageTitle = '404 — Sayfa Bulunamadı'; ?>
<?php include ROOT . '/views/layout/header.php'; ?>
<div class="flex flex-col items-center justify-center min-h-[50vh] text-center">
    <div class="text-6xl font-bold text-[#00A3B4] mb-4">404</div>
    <h1 class="text-2xl font-semibold text-gray-700 mb-2">Sayfa Bulunamadı</h1>
    <p class="text-gray-500 mb-6">Aradığınız sayfa mevcut değil veya taşınmış olabilir.</p>
    <a href="<?= url() ?>" class="px-6 py-2 bg-[#00A3B4] text-white rounded-lg hover:bg-[#007A8A] transition">
        Ana Sayfaya Dön
    </a>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
