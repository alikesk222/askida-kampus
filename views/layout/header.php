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
                            dark: '#007A8A',
                            light: '#E0F7FA',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>

<body class="min-h-screen bg-gray-50">

    <?php $user = auth(); ?>
    <?php if ($user): ?>
        <?php $role = $user['role']; ?>
        <?php $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>

        <!-- Top Header -->
        <header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 z-40">
            <div class="h-full px-4 flex items-center justify-between">
                <!-- Left: Menu Toggle + Logo -->
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-3">
                        <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-10 w-auto">
                        <div class="hidden sm:block border-l border-gray-300 pl-3">
                            <p class="text-xs font-semibold text-gray-800 leading-tight">Ankara Yıldırım Beyazıt
                                Üniversitesi</p>
                            <p class="text-[11px] text-gray-500 leading-tight">İktisadi İşletmeler Müdürlüğü</p>
                        </div>
                    </div>
                </div>

                <!-- Right: User Menu -->
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2">
                        <div
                            class="w-9 h-9 bg-gradient-to-br from-[#00A3B4] to-[#007A8A] rounded-full flex items-center justify-center text-sm font-bold text-white">
                            <?= strtoupper(mb_substr($user['name'], 0, 1)) ?>
                        </div>
                        <div class="text-sm">
                            <div class="font-medium text-gray-800"><?= e($user['name']) ?></div>
                            <div class="text-gray-500 text-xs"><?= e($user['role']) ?></div>
                        </div>
                    </div>
                    <?php if (in_array($role, ['student', 'donor'])): ?>
                    <?php $cl = current_lang(); ?>
                    <div class="hidden sm:flex items-center border border-gray-200 rounded-md overflow-hidden text-xs font-bold">
                        <a href="<?= url('lang/tr') ?>" class="px-2.5 py-1.5 <?= $cl === 'tr' ? 'bg-[#00A3B4] text-white' : 'text-gray-500 hover:bg-gray-50' ?> transition">TR</a>
                        <a href="<?= url('lang/en') ?>" class="px-2.5 py-1.5 <?= $cl === 'en' ? 'bg-[#00A3B4] text-white' : 'text-gray-500 hover:bg-gray-50' ?> transition">EN</a>
                    </div>
                    <?php endif; ?>
                    <form method="POST" action="<?= url('cikis') ?>">
                        <?= csrf_field() ?>
                        <button type="submit"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition">
                            <?= t('common.logout') ?>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed top-16 left-0 w-56 bg-white border-r border-gray-200 z-30 transform -translate-x-full lg:translate-x-0 transition-all duration-300 overflow-y-auto"
            style="height: calc(100vh - 4rem);">
            <nav class="py-4 px-3" id="sidebar-nav">
                <?php if (in_array($role, ['super-admin', 'university-admin'])): ?>
                    <a href="<?= url('admin') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_starts_with($currentPath, '/admin') && !str_contains($currentPath, '/isletmeler') && !str_contains($currentPath, '/kullanicilar') && !str_contains($currentPath, '/bagislar') && !str_contains($currentPath, '/rezervasyonlar') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>"
                        title="Dashboard">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Dashboard</span>
                    </a>
                    <a href="<?= url('admin/isletmeler') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/isletmeler') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">İşletmeler</span>
                    </a>
                    <a href="<?= url('admin/kullanicilar') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/kullanicilar') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Kullanıcılar</span>
                    </a>
                    <a href="<?= url('admin/bagislar') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/bagislar') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Bağışlar</span>
                    </a>
                    <a href="<?= url('admin/rezervasyonlar') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/rezervasyonlar') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Rezervasyonlar</span>
                    </a>
                    <a href="<?= url('admin/ayarlar') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/ayarlar') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Ayarlar</span>
                    </a>
                <?php elseif ($role === 'venue-admin'): ?>
                    <a href="<?= url('isletme') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= $currentPath === '/isletme' ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Dashboard</span>
                    </a>
                    <a href="<?= url('isletme/teslim') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/teslim') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Teslim Al</span>
                    </a>
                    <a href="<?= url('isletme/stok') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/stok') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Stok Yönetimi</span>
                    </a>
                    <a href="<?= url('isletme/bagislar') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/bagislar') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Bağışlar</span>
                    </a>
                    <a href="<?= url('isletme/rezervasyonlar') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/rezervasyonlar') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Rezervasyonlar</span>
                    </a>
                <?php elseif ($role === 'student'): ?>
                    <a href="<?= url('isletmeler') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_starts_with($currentPath, '/isletmeler') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">İşletmeler</span>
                    </a>
                    <a href="<?= url('rezervasyonlarim') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/rezervasyonlarim') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Rezervasyonlarım</span>
                    </a>
                <?php elseif ($role === 'donor'): ?>
                    <a href="<?= url('bagis') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_starts_with($currentPath, '/bagis') && !str_contains($currentPath, '/bagislarim') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Bağış Yap</span>
                    </a>
                    <a href="<?= url('bagislarim') ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= str_contains($currentPath, '/bagislarim') ? 'bg-[#00A3B4] text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap">Bağışlarım</span>
                    </a>
                <?php endif; ?>
            </nav>
        </aside>

        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden"></div>

        <script>
            // Sidebar Toggle
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const mainContent = document.querySelector('main');
            let sidebarCollapsed = false; // Varsayılan olarak açık

            function toggleSidebar() {
                // Mobile: slide in/out
                if (window.innerWidth < 1024) {
                    sidebar.classList.toggle('-translate-x-full');
                    sidebarOverlay.classList.toggle('hidden');
                }
                // Desktop: collapse/expand
                else {
                    sidebarCollapsed = !sidebarCollapsed;

                    if (sidebarCollapsed) {
                        // Collapse - ikonlara kadar
                        sidebar.classList.remove('w-56');
                        sidebar.classList.add('w-16');
                        document.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('hidden'));
                        mainContent?.classList.remove('lg:pl-56');
                        mainContent?.classList.add('lg:pl-16');
                    } else {
                        // Expand
                        sidebar.classList.remove('w-16');
                        sidebar.classList.add('w-56');
                        document.querySelectorAll('.sidebar-text').forEach(el => el.classList.remove('hidden'));
                        mainContent?.classList.remove('lg:pl-16');
                        mainContent?.classList.add('lg:pl-56');
                    }
                }
            }

            sidebarToggle?.addEventListener('click', toggleSidebar);
            sidebarOverlay?.addEventListener('click', toggleSidebar);
        </script>
    <?php endif; ?>

    <main class="<?= $user ? 'pt-16 lg:pl-56' : '' ?> min-h-screen transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <?php
            // Flash mesajları
            $flashSuccess = flash('success');
            $flashError = flash('error');
            $flashInfo = flash('info');
            ?>
            <?php if ($flashSuccess): ?>
                <div data-flash
                    class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span><?= e($flashSuccess) ?></span>
                </div>
            <?php endif; ?>
            <?php if ($flashError): ?>
                <div data-flash
                    class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span><?= e($flashError) ?></span>
                </div>
            <?php endif; ?>
            <?php if ($flashInfo): ?>
                <div data-flash
                    class="mb-4 p-4 bg-blue-100 border border-blue-300 text-blue-800 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <span><?= e($flashInfo) ?></span>
                </div>
            <?php endif; ?>