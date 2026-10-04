<!DOCTYPE html>
<?php $__lang = current_lang(); ?>
<html lang="<?= $__lang ?>">
<head>
<?php include ROOT . '/views/layout/partials/head.php'; ?>
</head>
<body class="bg-page text-slate-700 antialiased">
<?php
$ap = $activePage ?? '';
$cl = $__lang;
$pubLinks = [
    ['key' => 'home',    'href' => url('/'),                           'label' => t('nav.home')],
    ['key' => 'how',     'href' => url('/') . '#nasil-calisir',        'label' => t('layout_public.nav_how')],
    ['key' => 'about',   'href' => url('hakkimizda'),                  'label' => t('nav.about')],
    ['key' => 'faq',     'href' => url('sss'),                         'label' => t('nav.faq')],
    ['key' => 'contact', 'href' => url('iletisim'),                    'label' => t('nav.contact')],
];
?>
<a href="#main" class="skip-link"><?= t('ui.skip_to_content') ?></a>

<!-- Üst şerit -->
<div class="on-dark bg-navy-950 text-xs text-navy-200">
    <div class="mx-auto flex h-9 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <span class="truncate"><?= t('common.univ') ?></span>
        <div class="flex shrink-0 items-center gap-4">
            <a href="<?= url('sss') ?>" class="hidden hover:text-white sm:inline"><?= t('nav.faq') ?></a>
            <div class="lang-switch" aria-label="<?= e(t('ui.language')) ?>">
                <a href="<?= url('lang/tr') ?>" class="<?= $cl === 'tr' ? 'is-active' : '' ?>" <?= $cl === 'tr' ? 'aria-current="true"' : '' ?>>TR</a>
                <a href="<?= url('lang/en') ?>" class="<?= $cl === 'en' ? 'is-active' : '' ?>" <?= $cl === 'en' ? 'aria-current="true"' : '' ?>>EN</a>
            </div>
        </div>
    </div>
</div>

<!-- Ana menü -->
<header class="sticky top-0 z-50 border-b border-slate-200 bg-white">
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:h-[72px] lg:px-8" aria-label="<?= e(t('nav.menu')) ?>">
        <a href="<?= url('/') ?>" class="flex shrink-0 items-center gap-3">
            <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-10 w-auto">
            <span class="flex flex-col leading-none">
                <span class="wordmark text-lg text-navy-800">Askıda Kampüs</span>
                <span class="mt-1 hidden text-[11px] text-slate-500 sm:block"><?= t('ui.platform_tagline') ?></span>
            </span>
        </a>

        <div class="hidden items-center gap-1 lg:flex">
            <?php foreach ($pubLinks as $l): $on = $ap === $l['key']; ?>
                <a href="<?= $l['href'] ?>"
                   class="relative rounded-xl px-3 py-2 text-sm font-medium hover:text-navy-800 <?= $on ? 'text-navy-800' : 'text-slate-600' ?>"
                   <?= $on ? 'aria-current="page"' : '' ?>>
                    <?= $l['label'] ?>
                    <?php if ($on): ?><span class="absolute inset-x-3 -bottom-0.5 h-0.5 rounded-full bg-gold-500"></span><?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="hidden items-center gap-2 lg:flex">
            <a href="<?= url('giris') ?>" class="btn btn-ghost"><?= t('nav.login') ?></a>
            <a href="<?= url('ogrenci-kayit') ?>" class="btn btn-outline"><?= t('nav.student_reg') ?></a>
            <a href="<?= url('misafir-bagis') ?>" class="btn btn-primary"><?= t('nav.donate') ?></a>
        </div>

        <button type="button" id="mobile-menu-btn"
                class="btn btn-outline btn-icon lg:hidden"
                aria-expanded="false" aria-controls="mobile-menu"
                aria-label="<?= e(t('ui.menu_open')) ?>">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </nav>

    <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white lg:hidden">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6">
            <div class="flex flex-col gap-1">
                <?php foreach ($pubLinks as $l): $on = $ap === $l['key']; ?>
                    <a href="<?= $l['href'] ?>"
                       class="flex min-h-[44px] items-center gap-2 rounded-xl px-3 text-sm font-medium hover:bg-slate-50 <?= $on ? 'bg-navy-50 text-navy-800' : 'text-slate-700' ?>"
                       <?= $on ? 'aria-current="page"' : '' ?>>
                        <?php if ($on): ?><span class="h-1.5 w-1.5 rounded-full bg-gold-500"></span><?php endif; ?>
                        <?= $l['label'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="mt-4 flex flex-col gap-2 border-t border-slate-200 pt-4">
                <a href="<?= url('giris') ?>" class="btn btn-ghost btn-block"><?= t('nav.login') ?></a>
                <a href="<?= url('ogrenci-kayit') ?>" class="btn btn-outline btn-block"><?= t('nav.student_reg') ?></a>
                <a href="<?= url('misafir-bagis') ?>" class="btn btn-primary btn-block"><?= t('nav.donate') ?></a>
            </div>
        </div>
    </div>
</header>

<main id="main">
