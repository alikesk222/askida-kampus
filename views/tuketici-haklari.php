<?php
$pageTitle  = 'Tüketici Hakları ve İptal/İade Politikası';
$activePage = '';
$metaDesc   = 'Askıda Kampüs tüketici hakları, iptal ve iade politikası bilgilendirmesi.';
include ROOT . '/views/layout/public-header.php';
?>

<!-- Hero -->
<header class="legal-hero on-dark relative overflow-hidden bg-navy-800">
    <div class="arch-lines arch-lines-sm" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-5xl px-6 py-14 sm:py-16">
        <p class="eyebrow eyebrow-light mb-3">Yasal Bilgilendirme</p>
        <h1 class="text-3xl sm:text-4xl font-bold text-white leading-tight">Tüketici Hakları ve İptal/İade Politikası</h1>
        <p class="mt-4 max-w-2xl text-base leading-relaxed text-navy-200">6502 sayılı Tüketicinin Korunması Hakkında Kanun ve ilgili mevzuat kapsamında haklarınız ve katkı işlemlerine ilişkin politikalarımız.</p>
    </div>
</header>

<div class="legal-body">
<article class="prose-legal">

    <!-- Platform Tanımı -->
    <section class="legal-section legal-section-accent">
        <h2><span class="legal-num">ℹ</span>Platform Hakkında Önemli Bilgi</h2>
        <p><strong>Askıda Kampüs</strong>, Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü tarafından işletilen bir <strong>sosyal dayanışma platformudur</strong>. Platform üzerinden gerçekleştirilen işlemler ticari ürün satışı değil; öğrencilere yönelik gönüllülük esasına dayalı <strong>bağış/katkı</strong> niteliği taşımaktadır.</p>
        <div class="legal-note">
            <svg class="w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <p>Bu platform bir e-ticaret veya perakende satış sitesi değildir. Gerçekleştirilen ödemeler, kampüs öğrencilerine yönelik dayanışma katkısı niteliği taşımaktadır.</p>
        </div>
    </section>

    <!-- Katkı Süreci -->
    <section class="legal-section">
        <h2><span class="legal-num">1</span>Katkı/Bağış Süreci</h2>
        <div class="legal-steps">
            <div class="legal-step">
                <div class="legal-step-num">1</div>
                <div class="legal-step-body">
                    <strong>Katkı Talebi Oluşturma</strong>
                    <p>Katkı sağlayan, katılımcı işletme ve ürünleri seçerek katkı talebini oluşturur.</p>
                </div>
            </div>
            <div class="legal-step">
                <div class="legal-step-num">2</div>
                <div class="legal-step-body">
                    <strong>Ödeme</strong>
                    <p>Ödeme, Halkbank Sanal POS altyapısı üzerinden kredi/banka kartı veya IBAN havale/EFT yöntemiyle gerçekleştirilir.</p>
                </div>
            </div>
            <div class="legal-step">
                <div class="legal-step-num">3</div>
                <div class="legal-step-body">
                    <strong>Yönetici Onayı</strong>
                    <p>Ödeme bildirimi sistem yöneticisi tarafından incelenir ve onaylanır. Onay sonrasında ürünler öğrenci rezervasyon stokuna eklenir.</p>
                </div>
            </div>
            <div class="legal-step">
                <div class="legal-step-num">4</div>
                <div class="legal-step-body">
                    <strong>Öğrenci Teslimi</strong>
                    <p>Öğrenci, sisteme giriş yaparak rezervasyon oluşturur ve işletme görevlisine teslim kodu göstererek ürünü teslim alır.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- İptal Koşulları -->
    <section class="legal-section">
        <h2><span class="legal-num">2</span>İptal Koşulları</h2>
        <table>
            <thead>
                <tr>
                    <th>Durum</th>
                    <th>İptal İmkânı</th>
                    <th>Açıklama</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Ödeme tamamlanmadan önce</strong></td>
                    <td class="legal-ok">✔ Mümkün</td>
                    <td>Ödeme sayfasını kapatarak işlemi sonlandırabilirsiniz.</td>
                </tr>
                <tr>
                    <td><strong>Ödeme yapıldı, yönetici onayı bekleniyor</strong></td>
                    <td class="legal-warn">⚠ Başvuru gerekli</td>
                    <td>İletişim formu veya e-posta ile en geç 24 saat içinde başvuruda bulunun.</td>
                </tr>
                <tr>
                    <td><strong>Yönetici onayladı, stok eklendi</strong></td>
                    <td class="legal-bad">✘ Mümkün değil</td>
                    <td>Ürünler stoğa eklendiğinden iptal işlemi gerçekleştirilememektedir.</td>
                </tr>
                <tr>
                    <td><strong>Öğrenci teslim aldı</strong></td>
                    <td class="legal-bad">✘ Mümkün değil</td>
                    <td>İşlem kesinleşmiştir.</td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- İade Koşulları -->
    <section class="legal-section">
        <h2><span class="legal-num">3</span>İade Koşulları</h2>
        <p>Askıda Kampüs platformu üzerinden gerçekleştirilen katkılar, gönüllülük esasına dayalı sosyal dayanışma ödemeleri niteliğinde olduğundan aşağıdaki koşullarda iade değerlendirilebilir:</p>
        <ul>
            <li><strong>Teknik Hata:</strong> Ödeme başarılı görünmesine rağmen katkı talebi sisteme işlenmemişse tam iade yapılır.</li>
            <li><strong>Çift Ödeme:</strong> Aynı talep için iki kez ödeme gerçekleşmişse ikinci ödeme iade edilir.</li>
            <li><strong>Yönetici Onayı Öncesi Talepler:</strong> Onay öncesinde iletişime geçilmesi hâlinde iade değerlendirmeye alınır.</li>
        </ul>
        <div class="legal-note">
            <svg class="w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <p>İade talepleri, katkı sağlayan kişinin ödeme yaptığı kart veya banka hesabına, bankanın işlem süreleri çerçevesinde (genellikle 5–10 iş günü) yansıtılır.</p>
        </div>
    </section>

    <!-- Cayma Hakkı -->
    <section class="legal-section">
        <h2><span class="legal-num">4</span>Cayma Hakkı</h2>
        <p>6502 sayılı Tüketicinin Korunması Hakkında Kanun'un 48. maddesi ve Mesafeli Sözleşmeler Yönetmeliği kapsamında genel cayma hakkı bilgilendirmesi:</p>
        <ul>
            <li>Mesafeli sözleşmelerde tüketicilerin 14 günlük cayma hakkı mevcuttur.</li>
            <li>Ancak bağış/katkı niteliğindeki gönüllü ödemeler, kural olarak ticari mal veya hizmet satışına ilişkin sözleşme hükümleri kapsamında değerlendirilmemektedir.</li>
            <li>Öte yandan platformumuz, teknik hata veya onay öncesi durumlarda iade işlemini kolaylaştırma yükümlülüğünü benimsemektedir.</li>
        </ul>
        <p>Cayma hakkına ilişkin sorularınız için iletişim bilgilerimizden bize ulaşabilirsiniz.</p>
    </section>

    <!-- Uyuşmazlık Çözümü -->
    <section class="legal-section">
        <h2><span class="legal-num">5</span>Şikâyet ve Uyuşmazlık Çözümü</h2>
        <p>Herhangi bir sorun veya şikâyet durumunda başvurabileceğiniz yollar:</p>
        <ul>
            <li><strong>Öncelikli Başvuru:</strong> <a href="<?= url('iletisim') ?>">İletişim Formu</a> veya <a href="mailto:basin@aybu.edu.tr">basin@aybu.edu.tr</a> — En geç 5 iş günü içinde yanıt verilmektedir.</li>
            <li><strong>Tüketici Hakem Heyeti:</strong> 6502 sayılı Kanun kapsamında yetkili Tüketici Hakem Heyeti'ne başvurabilirsiniz.</li>
            <li><strong>Tüketici Mahkemesi:</strong> Uyuşmazlığın çözümünde yetkili Ankara Tüketici Mahkemesi'ne başvurabilirsiniz.</li>
            <li><strong>e-Devlet:</strong> <a href="https://www.tuketicisikayeti.gov.tr" target="_blank" rel="noopener">tuketicisikayeti.gov.tr</a> üzerinden Ticaret Bakanlığı şikâyet portalına başvurabilirsiniz.</li>
        </ul>
    </section>

    <!-- İletişim -->
    <section class="legal-section legal-section-accent">
        <h2><span class="legal-num">6</span>İletişim Bilgileri</h2>
        <ul>
            <li><strong>Kurum:</strong> Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü</li>
            <li><strong>Adres:</strong> Esenboğa Külliyesi, Esenboğa / ANKARA</li>
            <li><strong>E-posta:</strong> <a href="mailto:basin@aybu.edu.tr">basin@aybu.edu.tr</a></li>
            <li><strong>Telefon:</strong> <a href="tel:+903129061000">+90 312 906 10 00</a></li>
            <li><strong>Çalışma Saatleri:</strong> Pazartesi – Cuma, 08:30 – 17:30</li>
        </ul>
    </section>

    <p class="legal-updated">Bu politika en son Haziran 2026 tarihinde güncellenmiştir.</p>

</article>
</div>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
