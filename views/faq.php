<?php
$pageTitle  = t('faq.hero_title');
$activePage = 'faq';
$metaDesc   = t('faq.hero_desc');
include ROOT . '/views/layout/public-header.php';

$lang = $_SESSION['lang'] ?? 'tr';

// Kategorilere göre grupla
$cats = [
    'donors'   => ['label_tr' => 'Katkı Sağlayanlar', 'label_en' => 'Donors',   'badge' => 'badge-gold-soft'],
    'students' => ['label_tr' => 'Öğrenciler',        'label_en' => 'Students', 'badge' => 'badge-info'],
    'general'  => ['label_tr' => 'Genel',             'label_en' => 'General',  'badge' => 'badge-muted'],
];
$grouped = [];
foreach ($faqItems as $it) { $grouped[$it['category']][] = $it; }
$faqIdx = 0;
?>

<!-- Hero -->
<header class="on-dark relative overflow-hidden bg-navy-800">
    <div class="arch-lines" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-6xl px-6 py-14 sm:py-[72px]">
        <p class="eyebrow eyebrow-light mb-3"><?= t('faq.hero_tag') ?></p>
        <h1 class="text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl"><?= t('faq.hero_title') ?></h1>
        <p class="mt-5 max-w-xl text-lg leading-relaxed text-navy-200"><?= t('faq.hero_desc') ?></p>
    </div>
</header>

<section class="bg-page px-6 py-16">
    <div class="mx-auto max-w-3xl">

        <?php foreach ($cats as $catKey => $catMeta): ?>
        <?php if (empty($grouped[$catKey])): continue; endif; ?>
        <div class="mb-10">
            <div class="mb-5 flex items-center gap-2.5">
                <span class="badge <?= $catMeta['badge'] ?>">
                    <?= $lang === 'en' ? $catMeta['label_en'] : $catMeta['label_tr'] ?>
                </span>
            </div>
            <div class="flex flex-col gap-2.5">
                <?php foreach ($grouped[$catKey] as $item): ?>
                <?php $faqIdx++; ?>
                <div class="faq-item">
                    <button type="button" class="faq-question" id="faq-q-<?= $faqIdx ?>"
                            aria-expanded="false" aria-controls="faq-a-<?= $faqIdx ?>" onclick="toggleFaq(this)">
                        <span><?= e($lang === 'en' ? $item['question_en'] : $item['question_tr']) ?></span>
                        <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                    <div class="faq-answer" id="faq-a-<?= $faqIdx ?>" role="region" aria-labelledby="faq-q-<?= $faqIdx ?>" hidden>
                        <?= nl2br(e($lang === 'en' ? $item['answer_en'] : $item['answer_tr'])) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($faqItems)): ?>
        <p class="text-center text-sm text-slate-500"><?= t('faq.empty') ?></p>
        <?php endif; ?>

        <!-- Hâlâ sorunuz var mı? -->
        <div class="card-navy on-dark mt-12 p-8 text-center">
            <div class="arch-lines arch-lines-sm" aria-hidden="true"></div>
            <div class="relative">
                <span class="icon-chip icon-chip-dark mx-auto mb-3" aria-hidden="true">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </span>
                <h3 class="mb-1.5 text-lg font-bold text-white"><?= t('faq.still_question') ?></h3>
                <p class="mb-5 text-sm text-navy-200"><?= t('faq.still_desc') ?></p>
                <a href="<?= url('iletisim') ?>" class="btn btn-gold"><?= t('faq.contact_btn') ?></a>
            </div>
        </div>

    </div>
</section>

<script>
function toggleFaq(btn) {
    const answer = document.getElementById(btn.getAttribute('aria-controls'));
    const isOpen = btn.classList.contains('open');
    document.querySelectorAll('.faq-question.open').forEach(b => {
        b.classList.remove('open');
        b.setAttribute('aria-expanded', 'false');
        const a = document.getElementById(b.getAttribute('aria-controls'));
        a.classList.remove('open');
        a.hidden = true;
    });
    if (!isOpen) {
        btn.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
        answer.classList.add('open');
        answer.hidden = false;
    }
}
</script>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
