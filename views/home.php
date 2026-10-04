<?php
$pageTitle  = t('nav.home') . ' — Askıda Kampüs';
$activePage = 'home';
$metaDesc   = t('home.slide1_desc');
include ROOT . '/views/layout/public-header.php';
?>

<!-- Hero -->
<section class="on-dark relative overflow-hidden bg-navy-800 text-white">
    <div class="mx-auto flex max-w-6xl flex-col items-center gap-14 px-6 pb-36 pt-14 lg:flex-row lg:pt-[72px]">
        <div class="flex min-w-0 flex-1 flex-col gap-6">
            <span class="inline-flex w-fit items-center gap-2 rounded-full bg-white/10 px-3.5 py-1.5 text-[13px] font-semibold text-navy-100">
                <span class="h-2 w-2 rounded-full bg-gold-500" aria-hidden="true"></span>
                <?= t('home.badge') ?>
            </span>
            <h1 class="text-4xl font-bold leading-[1.08] tracking-tight text-white sm:text-5xl lg:text-[54px]"><?= t('home.slide1_title') ?></h1>
            <p class="max-w-xl text-lg leading-relaxed text-navy-200"><?= t('home.slide1_desc') ?></p>
            <div class="flex flex-wrap gap-3">
                <a href="<?= url('misafir-bagis') ?>" class="btn btn-gold btn-lg">
                    <?= t('home.btn_donate') ?>
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                </a>
                <a href="<?= url('ogrenci-kayit') ?>" class="btn btn-outline-light btn-lg"><?= t('home.btn_student_reg') ?></a>
            </div>
            <ul class="flex flex-wrap gap-x-7 gap-y-2.5 text-sm font-medium text-navy-200">
                <li class="inline-flex items-center gap-2">
                    <svg class="h-[18px] w-[18px] text-gold-500" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z"/><path d="m9 12 2 2 4-4"/></svg>
                    <?= t('home.trust_identity') ?>
                </li>
                <li class="inline-flex items-center gap-2">
                    <svg class="h-[18px] w-[18px] text-gold-500" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h3v3h-3zM20 14v.01M14 20h.01M20 20h.01M17 20v.01"/></svg>
                    <?= t('home.trust_code') ?>
                </li>
            </ul>
        </div>
        <div class="flex w-full min-w-0 flex-1 justify-center">
            <div class="arch-frame home-hero-photo">
                <img src="<?= asset('slide1.jpg') ?>" alt="<?= t('home.hero_img_alt') ?>" fetchpriority="high">
            </div>
        </div>
    </div>
</section>

<!-- İstatistikler -->
<section class="relative -mt-[72px] px-6" aria-label="<?= t('home.stats_label') ?>">
    <div class="mx-auto max-w-6xl overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-lift">
        <dl class="grid grid-cols-2 lg:grid-cols-4">
            <div class="home-stat">
                <dd class="stat-value"><?= e($stats['venues']) ?>+</dd>
                <dt class="stat-label"><?= t('home.stat_venues') ?></dt>
            </div>
            <div class="home-stat">
                <dd class="stat-value"><?= e($stats['donations']) ?>+</dd>
                <dt class="stat-label"><?= t('home.stat_donations') ?></dt>
            </div>
            <div class="home-stat">
                <dd class="stat-value"><?= e($stats['reservations']) ?>+</dd>
                <dt class="stat-label"><?= t('home.stat_deliveries') ?></dt>
            </div>
            <div class="home-stat">
                <dd class="stat-value"><?= e($stats['stock']) ?>+</dd>
                <dt class="stat-label"><?= t('home.stat_stock') ?></dt>
            </div>
        </dl>
    </div>
</section>

<!-- Nasıl Çalışır -->
<section id="nasil-calisir" class="px-6 pb-20 pt-24">
    <div class="mx-auto flex max-w-6xl flex-col gap-12">
        <div class="mx-auto flex max-w-2xl flex-col gap-3 text-center">
            <span class="eyebrow"><?= t('home.how_title') ?></span>
            <h2 class="text-3xl font-bold leading-tight tracking-tight text-navy-950 sm:text-4xl"><?= t('home.how_subtitle') ?></h2>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="flex flex-col gap-6 rounded-3xl bg-page p-8 sm:p-9">
                <div class="flex items-center gap-3.5">
                    <span class="icon-chip" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M19 14c1.5-1.5 3-3.2 3-5.5A5.5 5.5 0 0 0 12 6a5.5 5.5 0 0 0-10 2.5c0 2.3 1.5 4 3 5.5l7 7z"/></svg>
                    </span>
                    <div>
                        <h3 class="text-xl font-bold text-navy-950"><?= t('home.how_donors') ?></h3>
                        <p class="text-sm text-slate-600"><?= t('home.how_donors_sub') ?></p>
                    </div>
                </div>
                <ol class="flex flex-col gap-4">
                    <li class="flex items-start gap-3.5">
                        <span class="home-step-num">1</span>
                        <p class="pt-1 text-[15px] leading-relaxed text-slate-700"><?= t('home.how_donors_step1') ?></p>
                    </li>
                    <li class="flex items-start gap-3.5">
                        <span class="home-step-num">2</span>
                        <p class="pt-1 text-[15px] leading-relaxed text-slate-700"><?= t('home.how_donors_step2') ?></p>
                    </li>
                    <li class="flex items-start gap-3.5">
                        <span class="home-step-num">3</span>
                        <p class="pt-1 text-[15px] leading-relaxed text-slate-700"><?= t('home.how_donors_step3') ?></p>
                    </li>
                </ol>
                <a href="<?= url('misafir-bagis') ?>" class="btn btn-primary w-fit"><?= t('home.how_donors_cta') ?></a>
            </div>
            <div class="flex flex-col gap-6 rounded-3xl bg-page p-8 sm:p-9">
                <div class="flex items-center gap-3.5">
                    <span class="icon-chip icon-chip-gold" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 10 12 5 2 10l10 5z"/><path d="M6 12v5c3 2 9 2 12 0v-5"/></svg>
                    </span>
                    <div>
                        <h3 class="text-xl font-bold text-navy-950"><?= t('home.how_students') ?></h3>
                        <p class="text-sm text-slate-600"><?= t('home.how_students_sub') ?></p>
                    </div>
                </div>
                <ol class="flex flex-col gap-4">
                    <li class="flex items-start gap-3.5">
                        <span class="home-step-num home-step-num-gold">1</span>
                        <p class="pt-1 text-[15px] leading-relaxed text-slate-700"><?= t('home.how_students_step1') ?></p>
                    </li>
                    <li class="flex items-start gap-3.5">
                        <span class="home-step-num home-step-num-gold">2</span>
                        <p class="pt-1 text-[15px] leading-relaxed text-slate-700"><?= t('home.how_students_step2') ?></p>
                    </li>
                    <li class="flex items-start gap-3.5">
                        <span class="home-step-num home-step-num-gold">3</span>
                        <p class="pt-1 text-[15px] leading-relaxed text-slate-700"><?= t('home.how_students_step3') ?></p>
                    </li>
                </ol>
                <a href="<?= url('giris') ?>" class="btn btn-primary w-fit"><?= t('home.how_students_cta') ?></a>
            </div>
        </div>
    </div>
</section>

<!-- İşletmeler -->
<?php if (!empty($venues)): ?>
<section id="isletmeler" class="bg-page px-6 py-20">
    <div class="mx-auto flex max-w-6xl flex-col gap-9">
        <div class="flex flex-col gap-2.5">
            <span class="eyebrow"><?= t('home.venues_title') ?></span>
            <h2 class="text-2xl font-bold tracking-tight text-navy-950 sm:text-3xl"><?= t('home.venues_subtitle') ?></h2>
        </div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($venues as $v): ?>
                <a href="<?= url('isletme/' . $v['id']) ?>" class="home-venue-card group">
                    <div class="flex items-start gap-3.5">
                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-navy-800 text-base font-bold text-white">
                            <?= mb_strtoupper(mb_substr(e($v['name']), 0, 1)) ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-base font-bold text-slate-900 group-hover:text-navy-800"><?= e($v['name']) ?></p>
                            <p class="mt-0.5 text-sm text-slate-600"><?= e($v['campus_name']) ?></p>
                            <?php if ($v['location']): ?>
                                <p class="mt-1.5 flex items-center gap-1 truncate text-xs text-slate-500">
                                    <svg class="h-3.5 w-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?= e($v['location']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <span class="mt-auto inline-flex items-center gap-1.5 text-sm font-bold text-navy-800">
                        <?= t('home.venue_view') ?>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA bandı -->
<section class="px-6 py-20">
    <div class="on-dark relative mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-7 overflow-hidden rounded-[28px] bg-navy-800 p-8 sm:p-[52px]">
        <div class="arch-lines arch-lines-sm" aria-hidden="true"></div>
        <div class="relative flex min-w-0 flex-1 basis-96 flex-col gap-2.5">
            <h2 class="text-3xl font-bold leading-tight tracking-tight text-white"><?= t('home.cta_title') ?></h2>
            <p class="text-[17px] leading-relaxed text-navy-200"><?= t('home.cta_desc') ?></p>
        </div>
        <div class="relative flex flex-wrap gap-3">
            <a href="<?= url('misafir-bagis') ?>" class="btn btn-gold btn-lg"><?= t('home.btn_donate') ?></a>
            <a href="#nasil-calisir" class="btn btn-outline-light btn-lg"><?= t('home.slide2_title') ?></a>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
