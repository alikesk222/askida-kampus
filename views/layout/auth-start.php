<?php
/**
 * Auth sayfaları — ortak bölünmüş düzen (başlangıç).
 * Kullanım: $headTitle = t('...'); include ROOT . '/views/layout/auth-start.php';
 *   ... sayfa içeriği ...
 *   include ROOT . '/views/layout/auth-end.php';  (sayfa scriptleri bundan SONRA, </body> öncesi)
 * Opsiyonel: $authWide (bool) — kayıt formları için biraz daha geniş form kolonu.
 */
$__cl = current_lang();
$__wide = !empty($authWide);
?>
<!DOCTYPE html>
<html lang="<?= $__cl ?>">
<head>
<?php include ROOT . '/views/layout/partials/head.php'; ?>
</head>
<body class="bg-white text-slate-900 antialiased">
<a href="#main" class="skip-link"><?= t('ui.skip_to_content') ?></a>
<div class="min-h-screen flex flex-col lg:flex-row">

    <!-- Sol tanıtım paneli (lg+) -->
    <aside class="hidden lg:flex lg:w-[45%] lg:max-w-[640px] lg:sticky lg:top-0 lg:h-screen flex-col justify-between gap-12 bg-navy-800 text-white p-12 relative overflow-hidden on-dark">
        <div class="arch-lines"></div>

        <a href="<?= url() ?>" class="relative flex items-center gap-3 text-white no-underline hover:text-white">
            <span class="flex items-center justify-center w-[52px] h-[52px] rounded-2xl bg-white"><img src="<?= asset('aybu.png') ?>" alt="AYBÜ" class="h-[38px] w-auto"></span>
            <span class="wordmark text-xl">Askıda Kampüs</span>
        </a>

        <div class="relative flex flex-col gap-6 max-w-[440px]">
            <h1 class="text-4xl leading-[1.1] font-bold tracking-tight"><?= t('auth.promo_headline') ?></h1>
            <ul class="flex flex-col gap-3.5 text-[15px] leading-relaxed text-navy-100 list-none m-0 p-0">
                <?php foreach (['auth.promo_1', 'auth.promo_2', 'auth.promo_3'] as $__pk): ?>
                <li class="flex items-start gap-3">
                    <span class="flex-none flex items-center justify-center w-6 h-6 rounded-full bg-gold-500 text-navy-950"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 5 5 9-10"/></svg></span>
                    <?= t($__pk) ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <span class="relative text-[13px] text-navy-400"><?= t('common.univ') ?></span>
    </aside>

    <!-- Form kolonu -->
    <div class="flex-1 min-w-0 flex flex-col">
        <!-- Kompakt üst şerit (<1024px) -->
        <a href="<?= url() ?>" class="lg:hidden flex items-center gap-3 bg-navy-800 px-5 py-3 text-white no-underline hover:text-white on-dark">
            <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-white"><img src="<?= asset('aybu.png') ?>" alt="AYBÜ" class="h-7 w-auto"></span>
            <span class="wordmark text-base">Askıda Kampüs</span>
        </a>

        <main id="main" class="flex-1 flex flex-col gap-6 px-5 py-6 sm:px-10 lg:px-12 lg:py-10">
            <div class="flex items-center justify-between text-sm font-semibold">
                <a href="<?= url() ?>" class="inline-flex items-center gap-1.5 text-slate-600 no-underline hover:text-navy-800">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="m11 18-6-6 6-6"/></svg>
                    <?= t('ui.back_home') ?>
                </a>
                <span class="lang-switch">
                    <a href="<?= url('lang/tr') ?>" class="<?= $__cl === 'tr' ? 'is-active' : '' ?>">TR</a>
                    <a href="<?= url('lang/en') ?>" class="<?= $__cl === 'en' ? 'is-active' : '' ?>">EN</a>
                </span>
            </div>

            <div class="flex-1 flex items-center justify-center">
                <div class="w-full <?= $__wide ? 'max-w-[440px]' : 'max-w-[400px]' ?> flex flex-col gap-5">
