</main>

<footer class="on-dark bg-navy-950 text-navy-200">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">

            <div class="sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3">
                    <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-11 w-auto brightness-0 invert">
                    <span class="wordmark text-lg text-white">Askıda Kampüs</span>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-navy-200"><?= t('footer.brand_desc') ?></p>
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-white"><?= t('layout_public.footer_platform') ?></h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a class="hover:text-white" href="<?= url('/') ?>"><?= t('nav.home') ?></a></li>
                    <li><a class="hover:text-white" href="<?= url('misafir-bagis') ?>"><?= t('nav.donate') ?></a></li>
                    <li><a class="hover:text-white" href="<?= url('ogrenci-kayit') ?>"><?= t('footer.student_reg') ?></a></li>
                    <li><a class="hover:text-white" href="<?= url('giris') ?>"><?= t('nav.login') ?></a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-white"><?= t('layout_public.footer_corporate') ?></h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a class="hover:text-white" href="<?= url('hakkimizda') ?>"><?= t('nav.about') ?></a></li>
                    <li><a class="hover:text-white" href="<?= url('sss') ?>"><?= t('nav.faq') ?></a></li>
                    <li><a class="hover:text-white" href="<?= url('iletisim') ?>"><?= t('footer.contact') ?></a></li>
                    <li class="pt-1 leading-relaxed">Ankara Yıldırım Beyazıt Üniversitesi<br>Esenboğa Külliyesi, Esenboğa / ANKARA</li>
                    <li><a class="hover:text-white" href="mailto:basin@aybu.edu.tr">basin@aybu.edu.tr</a></li>
                    <li><a class="hover:text-white" href="tel:+903129061000">+90 312 906 10 00</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-white"><?= t('layout_public.footer_legal') ?></h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a class="hover:text-white" href="<?= url('kvkk') ?>"><?= t('footer.privacy') ?></a></li>
                    <li><a class="hover:text-white" href="<?= url('kvkk') ?>"><?= t('footer.kvkk') ?></a></li>
                    <li><a class="hover:text-white" href="<?= url('guvenlik-politikasi') ?>"><?= t('footer.accessibility') ?></a></li>
                    <li><a class="hover:text-white" href="<?= url('tuketici-haklari') ?>"><?= t('layout_public.footer_consumer') ?></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-3 px-4 py-4 text-xs text-navy-200 sm:flex-row sm:items-center sm:px-6 lg:px-8">
            <span><?= t('footer.rights', ['year' => date('Y')]) ?></span>
            <div class="lang-switch" aria-label="<?= e(t('ui.language')) ?>">
                <a href="<?= url('lang/tr') ?>" class="<?= current_lang() === 'tr' ? 'is-active' : '' ?>">TR</a>
                <a href="<?= url('lang/en') ?>" class="<?= current_lang() === 'en' ? 'is-active' : '' ?>">EN</a>
            </div>
        </div>
    </div>
</footer>

<script src="<?= asset('js/app.js') ?>?v=<?= filemtime(ROOT . '/public/assets/js/app.js') ?>"></script>
</body>
</html>
