</main>

<footer class="bg-[#0d1b3e] text-white">
    <!-- Ana footer -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            <!-- Sol: Logo + Slogan -->
            <div class="flex flex-col gap-5">
                <div class="flex items-center gap-3">
                    <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-12 w-auto brightness-0 invert">
                    <span class="text-2xl font-extrabold tracking-wide text-white">AYBÜ</span>
                </div>
                <p class="text-[#00C8DC] text-xl font-light italic leading-snug">Geçmişten Geleceğe...</p>
            </div>

            <!-- Orta: Hızlı Erişim -->
            <div class="border-l border-white/10 pl-10">
                <h4 class="text-[#00C8DC] text-xs font-bold uppercase tracking-widest mb-4">Hızlı Erişim</h4>
                <ul class="space-y-2 text-sm text-white/70">
                    <?php $u = auth(); $role = $u['role'] ?? ''; ?>
                    <?php if (in_array($role, ['super-admin','university-admin'])): ?>
                        <li><a href="<?= url('admin') ?>" class="hover:text-white transition">Dashboard</a></li>
                        <li><a href="<?= url('admin/isletmeler') ?>" class="hover:text-white transition">İşletmeler</a></li>
                        <li><a href="<?= url('admin/kullanicilar') ?>" class="hover:text-white transition">Kullanıcılar</a></li>
                        <li><a href="<?= url('admin/bagislar') ?>" class="hover:text-white transition">Bağışlar</a></li>
                    <?php elseif ($role === 'venue-admin'): ?>
                        <li><a href="<?= url('isletme') ?>" class="hover:text-white transition">Dashboard</a></li>
                        <li><a href="<?= url('isletme/stok') ?>" class="hover:text-white transition">Stok Yönetimi</a></li>
                        <li><a href="<?= url('isletme/bagislar') ?>" class="hover:text-white transition">Bağışlar</a></li>
                    <?php elseif ($role === 'cashier'): ?>
                        <li><a href="<?= url('kasa') ?>" class="hover:text-white transition">Kasa</a></li>
                    <?php elseif ($role === 'student'): ?>
                        <li><a href="<?= url('isletmeler') ?>" class="hover:text-white transition">İşletmeler</a></li>
                        <li><a href="<?= url('rezervasyonlarim') ?>" class="hover:text-white transition">Rezervasyonlarım</a></li>
                    <?php elseif ($role === 'donor'): ?>
                        <li><a href="<?= url('bagis') ?>" class="hover:text-white transition">Bağış Yap</a></li>
                        <li><a href="<?= url('bagislarim') ?>" class="hover:text-white transition">Bağışlarım</a></li>
                    <?php else: ?>
                        <li><a href="<?= url('giris') ?>" class="hover:text-white transition">Giriş Yap</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Sağ: İletişim -->
            <div>
                <h4 class="text-[#00C8DC] text-xs font-bold uppercase tracking-widest mb-4">İletişim</h4>
                <ul class="space-y-2 text-sm text-white/70">
                    <li><span class="text-white font-medium">Adres:</span> Ankara Yıldırım Beyazıt Üniversitesi Esenboğa Külliyesi, Esenboğa/ANKARA</li>
                    <li><span class="text-white font-medium">E-posta:</span> <a href="mailto:basin@aybu.edu.tr" class="hover:text-white transition">basin@aybu.edu.tr</a></li>
                    <li><span class="text-white font-medium">Telefon:</span> +90 312 906 10 00</li>
                </ul>
                <!-- Sosyal Medya -->
                <div class="flex items-center gap-3 mt-5">
                    <a href="https://instagram.com/aybu_resmi" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#00C8DC] flex items-center justify-center transition" title="Instagram">
                        <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="https://x.com/aybu_resmi" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#00C8DC] flex items-center justify-center transition" title="X">
                        <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.261 5.638 5.902-5.638zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://youtube.com/@aybu" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#00C8DC] flex items-center justify-center transition" title="YouTube">
                        <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="https://linkedin.com/school/aybu" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#00C8DC] flex items-center justify-center transition" title="LinkedIn">
                        <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="https://facebook.com/aybu" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#00C8DC] flex items-center justify-center transition" title="Facebook">
                        <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://aybu.edu.tr" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#00C8DC] flex items-center justify-center transition" title="Web Sitesi">
                        <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alt bar -->
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/40">
            <p>&copy; <?= date('Y') ?> Ankara Yıldırım Beyazıt Üniversitesi. Tüm hakları saklıdır.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-white transition">Erişilebilirlik</a>
                <a href="#" class="hover:text-white transition">Gizlilik Politikası</a>
                <a href="#" class="hover:text-white transition">KVKK</a>
            </div>
        </div>
    </div>
</footer>

<script src="<?= url('assets/js/app.js') ?>"></script>
</body>
</html>
