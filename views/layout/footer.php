        </div>
</main>

<?php
$fu = auth();
$fRole = $fu['role'] ?? '';
$fIsStudent = $fRole === 'student';
$fPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
?>
<footer id="main-footer" class="border-t border-slate-200 bg-white <?= $fu ? 'lg:pl-56' : '' ?> transition-all duration-300 <?= $fIsStudent ? 'pb-24 md:pb-0' : '' ?>">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500">
        <p><?= t('common.copyright', ['year' => date('Y')]) ?></p>
        <div class="flex items-center gap-4">
            <a href="<?= url('kvkk') ?>" class="hover:text-navy-800 transition"><?= t('footer.kvkk') ?></a>
            <a href="<?= url('guvenlik-politikasi') ?>" class="hover:text-navy-800 transition"><?= t('layout.security_policy') ?></a>
        </div>
    </div>
</footer>

<?php if ($fIsStudent): ?>
    <?php
    $tabs = [
        ['isletmeler', t('student.venues_title'), str_starts_with($fPath, '/isletmeler'), 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
        ['rezervasyonlarim', t('student.reservations'), str_contains($fPath, '/rezervasyonlarim'), 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
        ['ogrencim/belgeler', t('layout.my_documents'), str_contains($fPath, '/ogrencim/belgeler'), 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
    ];
    ?>
    <nav class="md:hidden fixed bottom-0 inset-x-0 z-30 bg-white border-t border-slate-200 pb-[env(safe-area-inset-bottom)]" aria-label="<?= e(t('layout.student_nav')) ?>">
        <ul class="grid grid-cols-4">
            <?php foreach ($tabs as [$thref, $tlabel, $tactive, $tpath]): ?>
                <li>
                    <a href="<?= url($thref) ?>" class="tab-link <?= $tactive ? 'is-active' : '' ?>" <?= $tactive ? 'aria-current="page"' : '' ?>>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $tpath ?>" />
                        </svg>
                        <span><?= e($tlabel) ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
            <li>
                <button type="button" id="tab-menu-btn" class="tab-link w-full" aria-controls="sidebar" aria-expanded="false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span><?= t('nav.menu') ?></span>
                </button>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<script src="<?= asset('js/app.js') ?>?v=<?= @filemtime(ROOT . '/public/assets/js/app.js') ?: 1 ?>"></script>
</body>
</html>
