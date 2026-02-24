<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Askıda Kampüs') ?> — AYBU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        aybu: {
                            DEFAULT: '#00A3B4',
                            dark:    '#007A8A',
                            light:   '#E0F7FA',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="<?= url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-gray-50">

<?php $user = auth(); ?>
<?php if ($user): ?>
<nav class="bg-[#00A3B4] text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[72px]">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <a href="<?= url() ?>" class="flex items-center gap-3">
                    <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-11 w-auto brightness-0 invert">
                    <div class="border-l border-white/40 pl-3">
                        <p class="text-[13px] font-semibold leading-tight">Ankara Yıldırım Beyazıt Üniversitesi</p>
                        <p class="text-[11px] text-white/75 leading-tight">İktisadi İşletmeler Müdürlüğü</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-1">
                <?php $role = $user['role']; ?>

                <?php if (in_array($role, ['super-admin','university-admin'])): ?>
                    <a href="<?= url('admin') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Dashboard</a>
                    <a href="<?= url('admin/isletmeler') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">İşletmeler</a>
                    <a href="<?= url('admin/kullanicilar') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Kullanıcılar</a>
                    <a href="<?= url('admin/bagislar') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Bağışlar</a>
                    <a href="<?= url('admin/rezervasyonlar') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Rezervasyonlar</a>
                <?php elseif ($role === 'venue-admin'): ?>
                    <a href="<?= url('isletme') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Dashboard</a>
                    <a href="<?= url('isletme/stok') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Stok</a>
                    <a href="<?= url('isletme/bagislar') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Bağışlar</a>
                    <a href="<?= url('isletme/rezervasyonlar') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Rezervasyonlar</a>
                <?php elseif ($role === 'cashier'): ?>
                    <a href="<?= url('kasa') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Kasa</a>
                <?php elseif ($role === 'student'): ?>
                    <a href="<?= url('isletmeler') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">İşletmeler</a>
                    <a href="<?= url('rezervasyonlarim') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Rezervasyonlarım</a>
                <?php elseif ($role === 'donor'): ?>
                    <a href="<?= url('bagis') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Bağış Yap</a>
                    <a href="<?= url('bagislarim') ?>" class="px-3 py-2 rounded text-sm hover:bg-white/20 transition">Bağışlarım</a>
                <?php endif; ?>
            </div>

            <!-- User menu -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm font-bold">
                        <?= strtoupper(mb_substr($user['name'], 0, 1)) ?>
                    </div>
                    <div class="text-sm">
                        <div class="font-medium"><?= e($user['name']) ?></div>
                        <div class="text-white/70 text-xs capitalize"><?= e($user['role']) ?></div>
                    </div>
                </div>
                <form method="POST" action="<?= url('cikis') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="px-3 py-1.5 bg-white/20 hover:bg-white/30 rounded text-sm transition">
                        Çıkış
                    </button>
                </form>
                <!-- Mobile menu button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded hover:bg-white/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-3 border-t border-white/20 mt-1 pt-2">
            <?php if (in_array($role, ['super-admin','university-admin'])): ?>
                <a href="<?= url('admin') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Dashboard</a>
                <a href="<?= url('admin/isletmeler') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">İşletmeler</a>
                <a href="<?= url('admin/kullanicilar') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Kullanıcılar</a>
                <a href="<?= url('admin/bagislar') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Bağışlar</a>
                <a href="<?= url('admin/rezervasyonlar') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Rezervasyonlar</a>
            <?php elseif ($role === 'venue-admin'): ?>
                <a href="<?= url('isletme') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Dashboard</a>
                <a href="<?= url('isletme/stok') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Stok</a>
                <a href="<?= url('isletme/bagislar') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Bağışlar</a>
                <a href="<?= url('isletme/rezervasyonlar') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Rezervasyonlar</a>
            <?php elseif ($role === 'cashier'): ?>
                <a href="<?= url('kasa') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Kasa</a>
            <?php elseif ($role === 'student'): ?>
                <a href="<?= url('isletmeler') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">İşletmeler</a>
                <a href="<?= url('rezervasyonlarim') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Rezervasyonlarım</a>
            <?php elseif ($role === 'donor'): ?>
                <a href="<?= url('bagis') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Bağış Yap</a>
                <a href="<?= url('bagislarim') ?>" class="block px-3 py-2 rounded text-sm hover:bg-white/20">Bağışlarım</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php endif; ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

<?php
// Flash mesajları
$flashSuccess = flash('success');
$flashError   = flash('error');
$flashInfo    = flash('info');
?>
<?php if ($flashSuccess): ?>
<div data-flash class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg flex items-center gap-2">
    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    <span><?= e($flashSuccess) ?></span>
</div>
<?php endif; ?>
<?php if ($flashError): ?>
<div data-flash class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg flex items-center gap-2">
    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
    <span><?= e($flashError) ?></span>
</div>
<?php endif; ?>
<?php if ($flashInfo): ?>
<div data-flash class="mb-4 p-4 bg-blue-100 border border-blue-300 text-blue-800 rounded-lg flex items-center gap-2">
    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
    <span><?= e($flashInfo) ?></span>
</div>
<?php endif; ?>
