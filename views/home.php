<?php
$pageTitle  = t('nav.home') . ' — Askıda Kampüs';
$activePage = 'home';
$metaDesc   = t('home.slide1_desc');
include ROOT . '/views/layout/public-header.php';
?>

<style>
    .hero-slider {
        position: relative; width: 100%; height: 420px;
        overflow: hidden; background: #1a2a3a; border-top: 3px solid #009999;
    }
    @media (max-width: 768px) {
        .hero-slider { height: 520px; }
        .slider-btn { width: 38px; height: 38px; }
        .slider-btn.prev { left: 10px; }
        .slider-btn.next { right: 10px; }
        .slider-progress { display: none; }
        .slide-desc { font-size: 13px; }
        .slide-actions a { padding: 9px 18px; font-size: 13px; }
    }
    .slides { display: flex; height: 100%; transition: transform 0.6s cubic-bezier(0.77, 0, 0.175, 1); }
    .slide { min-width: 100%; height: 100%; overflow: hidden; position: relative; }
    .slide img { width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; }
    .slide-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(0,58,110,0.82) 0%, rgba(0,100,140,0.55) 50%, rgba(0,153,153,0.35) 100%);
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 40px 20px; text-align: center;
    }
    .slide-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
        color: #fff; font-size: 13px; font-weight: 500;
        padding: 6px 18px; border-radius: 999px; margin-bottom: 20px;
    }
    .slide-badge .dot { width: 8px; height: 8px; background: #4ade80; border-radius: 50%; animation: pulse 2s infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(0.85); } }
    .slide-title { font-size: clamp(28px, 5vw, 52px); font-weight: 900; color: #fff; line-height: 1.15; margin-bottom: 16px; letter-spacing: -0.5px; }
    .slide-title span { color: #7dd8f0; }
    .slide-desc { font-size: 15px; color: rgba(255,255,255,0.80); max-width: 560px; line-height: 1.65; margin-bottom: 28px; font-weight: 300; }
    .slide-actions { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; }
    .slide-actions a { padding: 11px 26px; border-radius: 6px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.2s; }
    .slide-actions .btn-primary { background: #fff; color: #003a6e; box-shadow: 0 4px 20px rgba(0,0,0,0.25); }
    .slide-actions .btn-primary:hover { background: #f0f4f8; }
    .slide-actions .btn-secondary { background: #009999; color: #fff; box-shadow: 0 4px 20px rgba(0,153,153,0.4); }
    .slide-actions .btn-secondary:hover { background: #007a7a; }
    .slide-actions .btn-ghost { background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(4px); }
    .slide-actions .btn-ghost:hover { background: rgba(255,255,255,0.25); }
    .slider-btn {
        position: absolute; top: 50%; transform: translateY(-50%);
        width: 48px; height: 48px; border-radius: 50%;
        background: #009999; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        z-index: 10; transition: background 0.2s, transform 0.2s;
        box-shadow: 0 2px 12px rgba(0,0,0,0.3);
    }
    .slider-btn:hover { background: #007a7a; transform: translateY(-50%) scale(1.08); }
    .slider-btn svg { width: 20px; height: 20px; fill: none; stroke: #fff; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
    .slider-btn.prev { left: 24px; }
    .slider-btn.next { right: 24px; }
    .slider-counter {
        position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
        background: #fff; border-radius: 50% 50% 0 0; width: 80px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 500; color: #444; letter-spacing: 1px;
        z-index: 10; box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    }
    .slider-progress {
        position: absolute; right: 78px; top: 50%; transform: translateY(-50%);
        width: 3px; height: 80px; background: rgba(255,255,255,0.25);
        border-radius: 2px; z-index: 10; overflow: hidden;
    }
    .slider-progress-fill { width: 100%; background: #fff; border-radius: 2px; transition: height 0.5s ease; }
    .stat-card { transition: transform 0.2s, box-shadow 0.2s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,58,110,0.12); }
    .venue-card { transition: all 0.2s; }
    .venue-card:hover { transform: translateY(-2px); border-color: #009999; box-shadow: 0 8px 25px rgba(0,153,153,0.12); }
    .section-title { color: #003a6e; }
</style>

<!-- HERO SLIDER -->
<section class="hero-slider">
    <div class="slides" id="slidesTrack">

        <div class="slide">
            <img src="<?= asset('slide1.jpg') ?>" alt="Askıda Kampüs">
            <div class="slide-overlay">
                <div class="slide-badge">
                    <span class="dot"></span>
                    <?= t('home.badge') ?>
                </div>
                <h1 class="slide-title">
                    <?= t('home.slide1_title') ?>
                </h1>
                <p class="slide-desc"><?= t('home.slide1_desc') ?></p>
                <div class="slide-actions">
                    <a href="<?= url('misafir-bagis') ?>" class="btn-primary"><?= t('home.btn_donate') ?></a>
                    <a href="<?= url('kayit') ?>" class="btn-secondary"><?= t('home.btn_student_reg') ?></a>
                    <a href="<?= url('giris') ?>" class="btn-ghost"><?= t('home.btn_login') ?></a>
                </div>
            </div>
        </div>

        <div class="slide">
            <img src="<?= asset('slide2.jpg') ?>" alt="Askıda Kampüs">
            <div class="slide-overlay">
                <h1 class="slide-title">
                    <?= t('home.slide2_title') ?>
                </h1>
                <p class="slide-desc"><?= t('home.slide2_desc') ?></p>
                <div class="slide-actions">
                    <a href="#nasil-calisir" class="btn-primary"><?= t('home.slide2_btn_detail') ?></a>
                    <a href="#isletmeler" class="btn-ghost"><?= t('home.slide2_btn_venues') ?></a>
                </div>
            </div>
        </div>

    </div>

    <button class="slider-btn prev" onclick="changeSlide(-1)" aria-label="Önceki">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <button class="slider-btn next" onclick="changeSlide(1)" aria-label="Sonraki">
        <svg viewBox="0 0 24 24"><polyline points="9 6 15 12 9 18"/></svg>
    </button>

    <div class="slider-counter"><span id="slideCounter">1 / 2</span></div>
    <div class="slider-progress"><div class="slider-progress-fill" id="progressFill" style="height:50%"></div></div>
</section>

<script>
(function() {
    const track   = document.getElementById('slidesTrack');
    const counter = document.getElementById('slideCounter');
    const fill    = document.getElementById('progressFill');
    const slides  = track.querySelectorAll('.slide');
    const total   = slides.length;
    let current = 0, timer;
    function goTo(i) {
        current = (i + total) % total;
        track.style.transform = 'translateX(-' + (current * 100) + '%)';
        counter.textContent = (current + 1) + ' / ' + total;
        fill.style.height = (((current + 1) / total) * 100) + '%';
    }
    window.changeSlide = function(dir) { clearInterval(timer); goTo(current + dir); startAuto(); };
    function startAuto() { timer = setInterval(function() { goTo(current + 1); }, 5000); }
    goTo(0); startAuto();
})();
</script>

<!-- İstatistikler -->
<section class="bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 py-8 grid grid-cols-2 sm:grid-cols-4 gap-px bg-gray-100">
        <div class="stat-card text-center p-6 bg-white">
            <div class="flex justify-center mb-2">
                <svg class="w-7 h-7" style="color:#0d1f3c" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <p class="text-3xl font-bold text-[#0d1f3c]"><?= e($stats['venues']) ?>+</p>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-medium"><?= t('home.stat_venues') ?></p>
        </div>
        <div class="stat-card text-center p-6 bg-white">
            <div class="flex justify-center mb-2">
                <svg class="w-7 h-7" style="color:#009999" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold" style="color:#009999"><?= e($stats['donations']) ?>+</p>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-medium"><?= t('home.stat_donations') ?></p>
        </div>
        <div class="stat-card text-center p-6 bg-white">
            <div class="flex justify-center mb-2">
                <svg class="w-7 h-7" style="color:#0d1f3c" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold text-[#0d1f3c]"><?= e($stats['reservations']) ?>+</p>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-medium"><?= t('home.stat_deliveries') ?></p>
        </div>
        <div class="stat-card text-center p-6 bg-white">
            <div class="flex justify-center mb-2">
                <svg class="w-7 h-7" style="color:#009999" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg>
            </div>
            <p class="text-3xl font-bold" style="color:#009999"><?= e($stats['stock']) ?>+</p>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide font-medium"><?= t('home.stat_stock') ?></p>
        </div>
    </div>
</section>

<!-- Nasıl Çalışır -->
<section id="nasil-calisir" class="py-16 px-4 bg-gray-50">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold section-title mb-2"><?= t('home.how_title') ?></h2>
            <div style="width:40px;height:3px;background:#009999;margin:8px auto 12px;border-radius:2px;"></div>
            <p class="text-gray-500 text-sm"><?= t('home.how_subtitle') ?></p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white border border-gray-200 rounded-lg p-8" style="border-top:3px solid #009999;">
                <div class="mb-6 pb-4 border-b border-gray-100">
                    <h3 class="font-bold text-[#0d1f3c] text-base uppercase tracking-wide"><?= t('home.how_donors') ?></h3>
                    <p class="text-xs text-gray-400 mt-1"><?= t('home.how_donors_sub') ?></p>
                </div>
                <ol class="space-y-5">
                    <li class="flex items-start gap-4">
                        <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#009999;">1</span>
                        <p class="text-gray-600 text-sm leading-relaxed"><?= t('home.how_donors_step1') ?></p>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#009999;">2</span>
                        <p class="text-gray-600 text-sm leading-relaxed"><?= t('home.how_donors_step2') ?></p>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#009999;">3</span>
                        <p class="text-gray-600 text-sm leading-relaxed"><?= t('home.how_donors_step3') ?></p>
                    </li>
                </ol>
                <a href="<?= url('misafir-bagis') ?>" class="mt-7 inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded transition" style="background:#009999;">
                    <?= t('home.how_donors_cta') ?>
                </a>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-8" style="border-top:3px solid #0d1f3c;">
                <div class="mb-6 pb-4 border-b border-gray-100">
                    <h3 class="font-bold text-[#0d1f3c] text-base uppercase tracking-wide"><?= t('home.how_students') ?></h3>
                    <p class="text-xs text-gray-400 mt-1"><?= t('home.how_students_sub') ?></p>
                </div>
                <ol class="space-y-5">
                    <li class="flex items-start gap-4">
                        <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#0d1f3c;">1</span>
                        <p class="text-gray-600 text-sm leading-relaxed"><?= t('home.how_students_step1') ?></p>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#0d1f3c;">2</span>
                        <p class="text-gray-600 text-sm leading-relaxed"><?= t('home.how_students_step2') ?></p>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white mt-0.5" style="background:#0d1f3c;">3</span>
                        <p class="text-gray-600 text-sm leading-relaxed"><?= t('home.how_students_step3') ?></p>
                    </li>
                </ol>
                <a href="<?= url('giris') ?>" class="mt-7 inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded transition" style="background:#0d1f3c;">
                    <?= t('home.how_students_cta') ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- İşletmeler -->
<?php if (!empty($venues)): ?>
<section id="isletmeler" class="bg-white py-14 px-4 border-t border-gray-100">
    <div class="max-w-5xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold section-title mb-2"><?= t('home.venues_title') ?></h2>
            <div style="width:40px;height:3px;background:#009999;margin-top:8px;border-radius:2px;"></div>
            <p class="text-gray-500 text-sm mt-3"><?= t('home.venues_subtitle') ?></p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($venues as $v): ?>
                <a href="<?= url('isletme/' . $v['id']) ?>"
                    class="venue-card border border-gray-200 rounded-lg p-5 block bg-white group"
                    style="border-left:3px solid #009999;">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 text-white text-sm font-bold shadow-sm" style="background:#0d1f3c;">
                            <?= mb_strtoupper(mb_substr(e($v['name']), 0, 1)) ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-sm group-hover:text-[#009999] transition-colors"><?= e($v['name']) ?></p>
                            <p class="text-xs text-gray-400 mt-0.5"><?= e($v['campus_name']) ?></p>
                            <?php if ($v['location']): ?>
                                <p class="text-xs text-gray-400 mt-1 truncate flex items-center gap-1">
                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?= e($v['location']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-[#009999] flex-shrink-0 mt-0.5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
