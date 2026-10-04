<!DOCTYPE html>
<html lang="<?= e(function_exists('current_lang') ? current_lang() : 'tr') ?>">

<head>
    <?php include ROOT . '/views/layout/partials/head.php'; ?>
</head>

<body class="min-h-screen bg-page">
    <a href="#main" class="skip-link"><?= t('ui.skip_to_content') ?></a>

    <?php $user = auth(); ?>
    <?php if ($user): ?>
        <?php
        $role = $user['role'];
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '';
        $userName = (string) ($user['name'] ?? '');
        $userInitial = $userName !== '' ? mb_strtoupper(mb_substr($userName, 0, 1)) : '?';

        $roleLabels = [
            'super-admin'      => t('ui.role_admin'),
            'university-admin' => t('ui.role_admin'),
            'venue-admin'      => t('ui.role_venue'),
            'student'          => t('ui.role_student'),
            'donor'            => t('ui.role_donor'),
        ];
        $roleLabel = $roleLabels[$role] ?? (string) $role;

        // SVG path'leri (ikonlar)
        $icHome = ['M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'];
        $icBuilding = ['M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'];
        $icUsers = ['M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'];
        $icCoin = ['M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
        $icClip = ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'];
        $icClipList = ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'];
        $icDoc = ['M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'];
        $icHelp = ['M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
        $icCog = ['M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z'];
        $icBox = ['M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'];
        $icHeart = ['M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'];

        // Menü öğeleri: [href, label, icon, active, title|null, badge]
        $menu = [];
        if (in_array($role, ['super-admin', 'university-admin'])) {
            $docBadge = (new Models\StudentDocumentModel())->countPending();
            $menu = [
                ['admin', 'Dashboard', $icHome, str_starts_with($currentPath, '/admin') && !str_contains($currentPath, '/isletmeler') && !str_contains($currentPath, '/kullanicilar') && !str_contains($currentPath, '/bagislar') && !str_contains($currentPath, '/rezervasyonlar'), 'Dashboard', 0],
                ['admin/isletmeler', 'İşletmeler', $icBuilding, str_contains($currentPath, '/isletmeler'), null, 0],
                ['admin/kullanicilar', 'Kullanıcılar', $icUsers, str_contains($currentPath, '/kullanicilar'), null, 0],
                ['admin/bagislar', 'Katkılar', $icCoin, str_contains($currentPath, '/bagislar'), null, 0],
                ['admin/rezervasyonlar', 'Rezervasyonlar', $icClip, str_contains($currentPath, '/rezervasyonlar'), null, 0],
                ['admin/belgeler', 'Belgeler', $icDoc, str_contains($currentPath, '/belgeler'), null, (int) $docBadge],
                ['admin/sss', 'SSS', $icHelp, str_contains($currentPath, '/sss'), null, 0],
                ['admin/ayarlar', 'Ayarlar', $icCog, str_contains($currentPath, '/ayarlar'), null, 0],
            ];
        } elseif ($role === 'venue-admin') {
            $menu = [
                ['isletme', 'Panel', $icHome, $currentPath === '/isletme', null, 0],
                ['isletme/stok', 'Stok Yönetimi', $icBox, str_contains($currentPath, '/stok'), null, 0],
                ['isletme/bagislar', 'Katkılar', $icCoin, str_contains($currentPath, '/bagislar'), null, 0],
                ['isletme/rezervasyonlar', 'Rezervasyonlar', $icClip, str_contains($currentPath, '/rezervasyonlar'), null, 0],
            ];
        } elseif ($role === 'student') {
            $menu = [
                ['isletmeler', 'İşletmeler', $icBuilding, str_starts_with($currentPath, '/isletmeler'), null, 0],
                ['rezervasyonlarim', 'Rezervasyonlarım', $icClipList, str_contains($currentPath, '/rezervasyonlarim'), null, 0],
                ['ogrencim/belgeler', 'Belgelerim', $icDoc, str_contains($currentPath, '/ogrencim/belgeler'), null, 0],
            ];
        } elseif ($role === 'donor') {
            $menu = [
                ['bagis', 'Katkı Sağla', $icHeart, str_starts_with($currentPath, '/bagis') && !str_contains($currentPath, '/bagislarim'), null, 0],
                ['bagislarim', 'Katkılarım', $icDoc, str_contains($currentPath, '/bagislarim'), null, 0],
            ];
        }
        $hasLang = in_array($role, ['student', 'donor']);
        ?>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed top-0 left-0 bottom-0 w-56 bg-navy-900 text-white z-50 transform -translate-x-full lg:translate-x-0 transition-all duration-300 flex flex-col on-dark">
            <!-- Marka -->
            <a href="<?= url() ?>" class="flex items-center gap-3 px-4 h-16 flex-shrink-0 border-b border-white/10">
                <span class="w-9 h-9 flex-shrink-0 bg-white rounded-xl flex items-center justify-center">
                    <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-6 w-auto">
                </span>
                <span class="sidebar-text min-w-0 leading-tight whitespace-nowrap">
                    <span class="wordmark block text-white text-[15px]">Askıda Kampüs</span>
                    <span class="block text-[11px] text-navy-200"><?= e($roleLabel) ?></span>
                </span>
            </a>

            <!-- Menü -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1" id="sidebar-nav" aria-label="<?= e($roleLabel) ?>">
                <?php foreach ($menu as [$href, $label, $icon, $active, $title, $badge]): ?>
                    <a href="<?= url($href) ?>"
                        class="sidebar-link flex items-center gap-3 px-3 py-2.5 min-h-[44px] rounded-xl text-sm font-medium transition <?= $active ? 'bg-white/10 text-white' : 'text-navy-200 hover:bg-white/5 hover:text-white' ?>"
                        <?= $active ? 'aria-current="page"' : '' ?>
                        title="<?= e($title ?? $label) ?>">
                        <svg class="w-5 h-5 flex-shrink-0 <?= $active ? 'text-gold-500' : '' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <?php foreach ($icon as $d): ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $d ?>" />
                            <?php endforeach; ?>
                        </svg>
                        <span class="sidebar-text whitespace-nowrap"><?= e($label) ?></span>
                        <?php if ($badge > 0): ?>
                            <span class="sidebar-text badge-count ml-auto"><?= $badge ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <!-- Kullanıcı kartı + çıkış -->
            <div class="flex-shrink-0 border-t border-white/10 p-3">
                <div class="flex items-center gap-3 px-1 pb-3">
                    <span class="w-9 h-9 flex-shrink-0 rounded-full bg-white/10 text-white flex items-center justify-center text-sm font-semibold"><?= e($userInitial) ?></span>
                    <span class="sidebar-text min-w-0 leading-tight">
                        <span class="block text-sm font-medium text-white truncate"><?= e($userName) ?></span>
                        <span class="block text-[11px] text-navy-200 truncate"><?= e($roleLabel) ?></span>
                    </span>
                </div>
                <form method="POST" action="<?= url('cikis') ?>">
                    <?= csrf_field() ?>
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 min-h-[44px] rounded-xl text-sm font-medium text-navy-200 hover:bg-white/5 hover:text-white transition"
                        title="<?= e(t('common.logout')) ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="sidebar-text whitespace-nowrap"><?= t('common.logout') ?></span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-navy-950/60 z-40 hidden lg:hidden"></div>

        <!-- Top Bar -->
        <header id="topbar" class="fixed top-0 right-0 left-0 lg:left-56 h-16 bg-white border-b border-slate-200 z-30 transition-all duration-300">
            <div class="h-full px-4 sm:px-6 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <button type="button" id="sidebar-toggle" class="btn btn-ghost btn-icon" aria-controls="sidebar" aria-expanded="false" aria-label="<?= e(t('ui.menu_open')) ?>">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="hidden md:flex items-center gap-2 min-w-0 leading-tight">
                        <span class="text-xs text-slate-500 whitespace-nowrap"><?= e($roleLabel) ?></span>
                        <?php if (!empty($pageTitle)): ?>
                            <span class="text-slate-300" aria-hidden="true">/</span>
                            <span class="text-sm font-semibold text-slate-900 truncate"><?= e($pageTitle) ?></span>
                        <?php endif; ?>
                    </div>
                    <a href="<?= url() ?>" class="md:hidden wordmark text-navy-900 text-[15px] truncate">Askıda Kampüs</a>
                </div>

                <div class="flex items-center gap-3">
                    <?php if ($hasLang): ?>
                        <?php $cl = current_lang(); ?>
                        <div class="lang-switch" role="group" aria-label="<?= e(t('ui.language')) ?>">
                            <a href="<?= url('lang/tr') ?>" class="<?= $cl === 'tr' ? 'is-active' : '' ?>" <?= $cl === 'tr' ? 'aria-current="true"' : '' ?>>TR</a>
                            <a href="<?= url('lang/en') ?>" class="<?= $cl === 'en' ? 'is-active' : '' ?>" <?= $cl === 'en' ? 'aria-current="true"' : '' ?>>EN</a>
                        </div>
                    <?php endif; ?>
                    <span class="w-9 h-9 rounded-full bg-navy-800 text-white flex items-center justify-center text-sm font-semibold" title="<?= e($userName) ?>" aria-hidden="true"><?= e($userInitial) ?></span>
                </div>
            </div>
        </header>

        <script>
            // Sidebar Toggle
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const mainContent = document.querySelector('main');
            const topbar = document.getElementById('topbar');
            const mainFooter = document.getElementById('main-footer');
            let sidebarCollapsed = false; // Varsayılan olarak açık

            function swapClass(el, from, to) {
                if (!el) return;
                el.classList.remove(from);
                el.classList.add(to);
            }

            function setExpanded(open) {
                document.querySelectorAll('[aria-controls="sidebar"]').forEach(b => b.setAttribute('aria-expanded', open ? 'true' : 'false'));
            }

            function toggleSidebar() {
                // Mobile: slide in/out
                if (window.innerWidth < 1024) {
                    sidebar.classList.toggle('-translate-x-full');
                    sidebarOverlay.classList.toggle('hidden');
                    setExpanded(!sidebar.classList.contains('-translate-x-full'));
                }
                // Desktop: collapse/expand
                else {
                    sidebarCollapsed = !sidebarCollapsed;
                    const from = sidebarCollapsed ? '56' : '16';
                    const to = sidebarCollapsed ? '16' : '56';
                    swapClass(sidebar, 'w-' + from, 'w-' + to);
                    document.querySelectorAll('.sidebar-text').forEach(el => el.classList.toggle('hidden', sidebarCollapsed));
                    swapClass(mainContent, 'lg:pl-' + from, 'lg:pl-' + to);
                    swapClass(mainFooter, 'lg:pl-' + from, 'lg:pl-' + to);
                    swapClass(topbar, 'lg:left-' + from, 'lg:left-' + to);
                    setExpanded(!sidebarCollapsed);
                }
            }

            sidebarToggle?.addEventListener('click', toggleSidebar);
            sidebarOverlay?.addEventListener('click', toggleSidebar);
            document.getElementById('tab-menu-btn')?.addEventListener('click', toggleSidebar);
            if (window.innerWidth >= 1024) setExpanded(true);
        </script>
    <?php else: ?>
        <!-- Misafir üst bar -->
        <header class="h-16 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8 flex items-center">
                <a href="<?= url() ?>" class="flex items-center gap-3">
                    <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-9 w-auto">
                    <span class="wordmark text-navy-900 text-lg">Askıda Kampüs</span>
                </a>
            </div>
        </header>
    <?php endif; ?>

    <main id="main" class="<?= $user ? 'pt-16 lg:pl-56' : '' ?> min-h-screen transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">

            <?php
            // Flash mesajları
            $flashSuccess = flash('success');
            $flashError = flash('error');
            $flashInfo = flash('info');
            $flashes = [
                ['success', 'status', $flashSuccess, 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'],
                ['error', 'alert', $flashError, 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z'],
                ['info', 'status', $flashInfo, 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z'],
            ];
            ?>
            <?php foreach ($flashes as [$ftype, $frole, $fmsg, $ficon]): ?>
                <?php if ($fmsg): ?>
                    <div data-flash class="flash flash-<?= $ftype ?> mb-4" role="<?= $frole ?>">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="<?= $ficon ?>" clip-rule="evenodd" />
                        </svg>
                        <div class="flash-body"><?= e($fmsg) ?></div>
                        <button type="button" class="flash-close" data-flash-close aria-label="<?= e(t('ui.close')) ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
