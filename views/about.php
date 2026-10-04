<?php
$pageTitle  = t('about.hero_title');
$activePage = 'about';
$metaDesc   = t('about.hero_desc');
include ROOT . '/views/layout/public-header.php';
?>

<!-- Hero -->
<header class="on-dark relative overflow-hidden bg-navy-800">
    <div class="arch-lines" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-6xl px-6 py-16 sm:py-20">
        <p class="eyebrow eyebrow-light mb-3"><?= t('about.hero_tag') ?></p>
        <h1 class="max-w-3xl text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl"><?= t('about.hero_title') ?></h1>
        <p class="mt-5 max-w-xl text-lg leading-relaxed text-navy-200"><?= t('about.hero_desc') ?></p>
    </div>
</header>

<!-- Proje Hakkında -->
<section class="bg-white px-6 py-20">
    <div class="mx-auto grid max-w-6xl grid-cols-1 items-start gap-14 lg:grid-cols-2">
        <div>
            <p class="eyebrow mb-2.5"><?= t('about.proj_tag') ?></p>
            <h2 class="mb-6 text-3xl font-bold leading-tight tracking-tight text-navy-950"><?= nl2br(t('about.proj_title')) ?></h2>
            <div class="space-y-4 text-base leading-relaxed text-slate-700">
                <p><?= t('about.proj_p1') ?></p>
                <p><?= t('about.proj_p2') ?></p>
                <p><?= t('about.proj_p3') ?></p>
            </div>
        </div>

        <div class="rounded-3xl bg-page p-6 sm:p-8">
            <dl class="grid grid-cols-2 gap-4">
                <div class="card card-body text-center">
                    <dd class="stat-value">13+</dd>
                    <dt class="stat-label mt-1.5"><?= t('about.stat_venues') ?></dt>
                </div>
                <div class="card card-body text-center">
                    <dd class="stat-value">2</dd>
                    <dt class="stat-label mt-1.5"><?= t('about.stat_campuses') ?></dt>
                </div>
                <div class="card card-body text-center">
                    <dd class="stat-value">7/24</dd>
                    <dt class="stat-label mt-1.5"><?= t('about.stat_system') ?></dt>
                </div>
                <div class="card card-body text-center">
                    <dd class="stat-value">0₺</dd>
                    <dt class="stat-label mt-1.5"><?= t('about.stat_fee') ?></dt>
                </div>
            </dl>
            <p class="mt-5 text-center text-sm leading-relaxed text-slate-600"><?= t('about.active_note') ?></p>
        </div>
    </div>
</section>

<!-- Değerlerimiz -->
<section class="bg-page px-6 py-20">
    <div class="mx-auto max-w-6xl">
        <div class="mb-11 max-w-2xl">
            <p class="eyebrow mb-2.5"><?= t('about.values_tag') ?></p>
            <h2 class="text-3xl font-bold tracking-tight text-navy-950"><?= t('about.values_title') ?></h2>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <?php foreach ([1, 2, 3, 4] as $i): ?>
            <div class="card card-body about-value">
                <p class="about-value-num">0<?= $i ?></p>
                <h3 class="mb-2.5 text-base font-bold text-navy-950"><?= t('about.val' . $i . '_title') ?></h3>
                <p class="text-sm leading-relaxed text-slate-600"><?= t('about.val' . $i . '_desc') ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="px-6 py-20">
    <div class="on-dark relative mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-7 overflow-hidden rounded-[28px] bg-navy-800 p-8 sm:p-[52px]">
        <div class="arch-lines arch-lines-sm" aria-hidden="true"></div>
        <div class="relative min-w-0 flex-1 basis-96">
            <p class="eyebrow eyebrow-light mb-3"><?= t('about.join_tag') ?></p>
            <h2 class="mb-2.5 text-3xl font-bold leading-tight tracking-tight text-white"><?= t('about.cta_title') ?></h2>
            <p class="max-w-lg text-[17px] leading-relaxed text-navy-200"><?= t('about.cta_desc') ?></p>
        </div>
        <div class="relative flex flex-wrap gap-3">
            <a href="<?= url('misafir-bagis') ?>" class="btn btn-gold btn-lg"><?= t('about.cta_btn_donate') ?></a>
            <a href="<?= url('ogrenci-kayit') ?>" class="btn btn-outline-light btn-lg"><?= t('about.cta_btn_reg') ?></a>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
