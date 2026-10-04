<?php $pageTitle = '403 — Yetkisiz Erişim'; ?>
<?php include ROOT . '/views/layout/header.php'; ?>
<div class="error-page">
    <div class="error-arch" aria-hidden="true"><span>403</span></div>
    <h1 class="mb-2 text-2xl font-bold text-slate-900">Yetkisiz Erişim</h1>
    <p class="mb-7 max-w-md text-slate-600">Bu sayfaya erişim yetkiniz bulunmamaktadır.</p>
    <a href="<?= url() ?>" class="btn btn-primary btn-lg">Ana Sayfaya Dön</a>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
