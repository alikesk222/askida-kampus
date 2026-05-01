<?php
$pageTitle  = t('faq.hero_title');
$activePage = 'faq';
$metaDesc   = t('faq.hero_desc');
include ROOT . '/views/layout/public-header.php';

$lang = $_SESSION['lang'] ?? 'tr';

// Kategorilere göre grupla
$cats = [
    'donors'   => ['label_tr' => 'Bağışçılar',  'label_en' => 'Donors',   'color' => '#e0f7fa', 'text' => '#007a7a'],
    'students' => ['label_tr' => 'Öğrenciler',  'label_en' => 'Students', 'color' => '#dbeafe', 'text' => '#1d4ed8'],
    'general'  => ['label_tr' => 'Genel',        'label_en' => 'General',  'color' => '#f3f4f6', 'text' => '#374151'],
];
$grouped = [];
foreach ($faqItems as $it) { $grouped[$it['category']][] = $it; }
?>

<style>
    .page-hero { background: linear-gradient(135deg, #0d1f3c 0%, #003a6e 50%, #005f7a 100%); padding: 64px 24px; text-align: center; }
    .faq-item { background: #fff; border: 1px solid #e8edf2; border-radius: 10px; overflow: hidden; }
    .faq-question {
        width: 100%; text-align: left; padding: 18px 20px;
        background: none; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: space-between;
        font-size: 14px; font-weight: 600; color: #1f2937;
        transition: background 0.15s;
    }
    .faq-question:hover { background: #f8f9fa; }
    .faq-question.open { color: #009999; }
    .faq-icon { width: 20px; height: 20px; flex-shrink: 0; transition: transform 0.3s; color: #9ca3af; }
    .faq-question.open .faq-icon { transform: rotate(45deg); color: #009999; }
    .faq-answer { display: none; padding: 14px 20px 18px; font-size: 13.5px; color: #4b5563; line-height: 1.75; border-top: 1px solid #f3f4f6; }
    .faq-answer.open { display: block; }
    .faq-tag { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 600; margin-bottom: 16px; }
</style>

<!-- Hero -->
<div class="page-hero">
    <p style="font-size:12px;font-weight:600;color:#7dd8f0;letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;"><?= t('faq.hero_tag') ?></p>
    <h1 style="font-size:clamp(28px,5vw,44px);font-weight:800;color:#fff;line-height:1.2;margin-bottom:16px;"><?= t('faq.hero_title') ?></h1>
    <p style="font-size:15px;color:rgba(255,255,255,0.7);max-width:480px;margin:0 auto;line-height:1.7;">
        <?= t('faq.hero_desc') ?>
    </p>
</div>

<section style="background:#f8f9fa;padding:64px 24px;">
    <div style="max-width:760px;margin:0 auto;">

        <?php foreach ($cats as $catKey => $catMeta): ?>
        <?php if (empty($grouped[$catKey])): continue; endif; ?>
        <div style="margin-bottom:40px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <span class="faq-tag" style="background:<?= $catMeta['color'] ?>;color:<?= $catMeta['text'] ?>;">
                    <?= $lang === 'en' ? $catMeta['label_en'] : $catMeta['label_tr'] ?>
                </span>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <?php foreach ($grouped[$catKey] as $item): ?>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <?= e($lang === 'en' ? $item['question_en'] : $item['question_tr']) ?>
                        <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <?= $lang === 'en' ? $item['answer_en'] : $item['answer_tr'] ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (empty($faqItems)): ?>
        <p style="text-align:center;color:#9ca3af;font-size:14px;">Henüz içerik eklenmemiş.</p>
        <?php endif; ?>

        <!-- Hâlâ sorunuz var mı? -->
        <div style="margin-top:48px;background:#fff;border:1px solid #e8edf2;border-radius:12px;padding:28px;text-align:center;">
            <svg style="width:36px;height:36px;color:#009999;margin:0 auto 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <h3 style="font-size:16px;font-weight:700;color:#0d1f3c;margin-bottom:6px;"><?= t('faq.still_question') ?></h3>
            <p style="font-size:13px;color:#6b7280;margin-bottom:16px;"><?= t('faq.still_desc') ?></p>
            <a href="<?= url('iletisim') ?>" style="display:inline-block;padding:10px 24px;background:#009999;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;"><?= t('faq.contact_btn') ?></a>
        </div>

    </div>
</section>

<script>
function toggleFaq(btn) {
    const answer = btn.nextElementSibling;
    const isOpen = btn.classList.contains('open');
    document.querySelectorAll('.faq-question.open').forEach(b => {
        b.classList.remove('open');
        b.nextElementSibling.classList.remove('open');
    });
    if (!isOpen) {
        btn.classList.add('open');
        answer.classList.add('open');
    }
}
</script>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
