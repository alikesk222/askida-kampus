<?php
$pageTitle  = 'Tüketici Hakları ve İptal/İade Politikası';
$activePage = '';
$metaDesc   = 'Askıda Kampüs tüketici hakları, iptal ve iade politikası bilgilendirmesi.';
include ROOT . '/views/layout/public-header.php';
?>

<style>
.policy-hero { background: linear-gradient(135deg, #0d1f3c 0%, #003a6e 50%, #005f7a 100%); padding: 64px 24px; text-align: center; }
.policy-body { max-width: 860px; margin: 0 auto; padding: 56px 24px; }
.policy-section { background: #fff; border: 1px solid #e8edf2; border-radius: 12px; padding: 32px 36px; margin-bottom: 20px; }
.policy-section h2 { font-size: 16px; font-weight: 700; color: #0d1f3c; margin-bottom: 14px; display: flex; align-items: center; gap: 10px; }
.policy-section h2 .num { width: 28px; height: 28px; background: #e0f7fa; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #009999; flex-shrink: 0; }
.policy-section p, .policy-section li { font-size: 13.5px; color: #4b5563; line-height: 1.8; }
.policy-section ul { margin-top: 10px; padding-left: 20px; display: flex; flex-direction: column; gap: 6px; }
.policy-section ul li::marker { color: #009999; }
.policy-section table { width: 100%; border-collapse: collapse; margin-top: 12px; font-size: 13px; }
.policy-section table th { background: #f8fafc; padding: 10px 14px; text-align: left; font-weight: 600; color: #374151; border-bottom: 2px solid #e8edf2; }
.policy-section table td { padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #4b5563; vertical-align: top; }
.policy-section table tr:last-child td { border-bottom: none; }
.info-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px 18px; margin-top: 14px; display: flex; gap: 10px; align-items: flex-start; }
.info-box svg { flex-shrink: 0; margin-top: 1px; }
.steps { display: flex; flex-direction: column; gap: 12px; margin-top: 14px; }
.step { display: flex; gap: 14px; align-items: flex-start; }
.step-num { width: 28px; height: 28px; background: #009999; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #fff; flex-shrink: 0; margin-top: 1px; }
.step-content strong { font-size: 13.5px; color: #0d1f3c; display: block; margin-bottom: 2px; }
.step-content p { font-size: 13px; color: #6b7280; margin: 0; }
</style>

<!-- Hero -->
<div class="policy-hero">
    <p style="font-size:12px;font-weight:600;color:#7dd8f0;letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;">Yasal Bilgilendirme</p>
    <h1 style="font-size:clamp(26px,4vw,38px);font-weight:800;color:#fff;margin-bottom:14px;">Tüketici Hakları ve İptal/İade Politikası</h1>
    <p style="font-size:15px;color:rgba(255,255,255,0.7);max-width:580px;margin:0 auto;line-height:1.7;">
        6502 sayılı Tüketicinin Korunması Hakkında Kanun ve ilgili mevzuat kapsamında haklarınız ve katkı işlemlerine ilişkin politikalarımız.
    </p>
</div>

<div class="policy-body">

    <!-- Platform Tanımı -->
    <div class="policy-section" style="border-color:#e0f7fa;background:#f0fdfe;">
        <h2><span class="num" style="background:#c7f5fb;">ℹ</span> Platform Hakkında Önemli Bilgi</h2>
        <p><strong>Askıda Kampüs</strong>, Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü tarafından işletilen bir <strong>sosyal dayanışma platformudur</strong>. Platform üzerinden gerçekleştirilen işlemler ticari ürün satışı değil; öğrencilere yönelik gönüllülük esasına dayalı <strong>bağış/katkı</strong> niteliği taşımaktadır.</p>
        <div class="info-box">
            <svg style="width:16px;height:16px;color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <p style="margin:0;">Bu platform bir e-ticaret veya perakende satış sitesi değildir. Gerçekleştirilen ödemeler, kampüs öğrencilerine yönelik dayanışma katkısı niteliği taşımaktadır.</p>
        </div>
    </div>

    <!-- Katkı Süreci -->
    <div class="policy-section">
        <h2><span class="num">1</span> Katkı/Bağış Süreci</h2>
        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-content">
                    <strong>Katkı Talebi Oluşturma</strong>
                    <p>Katkı sağlayan, katılımcı işletme ve ürünleri seçerek katkı talebini oluşturur.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-content">
                    <strong>Ödeme</strong>
                    <p>Ödeme, Halkbank Sanal POS altyapısı üzerinden kredi/banka kartı veya IBAN havale/EFT yöntemiyle gerçekleştirilir.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-content">
                    <strong>Yönetici Onayı</strong>
                    <p>Ödeme bildirimi sistem yöneticisi tarafından incelenir ve onaylanır. Onay sonrasında ürünler öğrenci rezervasyon stokuna eklenir.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num">4</div>
                <div class="step-content">
                    <strong>Öğrenci Teslimi</strong>
                    <p>Öğrenci, sisteme giriş yaparak rezervasyon oluşturur ve işletme görevlisine teslim kodu göstererek ürünü teslim alır.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- İptal Koşulları -->
    <div class="policy-section">
        <h2><span class="num">2</span> İptal Koşulları</h2>
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
                    <td style="color:#166534;font-weight:600;">✔ Mümkün</td>
                    <td>Ödeme sayfasını kapatarak işlemi sonlandırabilirsiniz.</td>
                </tr>
                <tr>
                    <td><strong>Ödeme yapıldı, yönetici onayı bekleniyor</strong></td>
                    <td style="color:#d97706;font-weight:600;">⚠ Başvuru gerekli</td>
                    <td>İletişim formu veya e-posta ile en geç 24 saat içinde başvuruda bulunun.</td>
                </tr>
                <tr>
                    <td><strong>Yönetici onayladı, stok eklendi</strong></td>
                    <td style="color:#dc2626;font-weight:600;">✘ Mümkün değil</td>
                    <td>Ürünler stoğa eklendiğinden iptal işlemi gerçekleştirilememektedir.</td>
                </tr>
                <tr>
                    <td><strong>Öğrenci teslim aldı</strong></td>
                    <td style="color:#dc2626;font-weight:600;">✘ Mümkün değil</td>
                    <td>İşlem kesinleşmiştir.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- İade Koşulları -->
    <div class="policy-section">
        <h2><span class="num">3</span> İade Koşulları</h2>
        <p>Askıda Kampüs platformu üzerinden gerçekleştirilen katkılar, gönüllülük esasına dayalı sosyal dayanışma ödemeleri niteliğinde olduğundan aşağıdaki koşullarda iade değerlendirilebilir:</p>
        <ul>
            <li><strong>Teknik Hata:</strong> Ödeme başarılı görünmesine rağmen katkı talebi sisteme işlenmemişse tam iade yapılır.</li>
            <li><strong>Çift Ödeme:</strong> Aynı talep için iki kez ödeme gerçekleşmişse ikinci ödeme iade edilir.</li>
            <li><strong>Yönetici Onayı Öncesi Talepler:</strong> Onay öncesinde iletişime geçilmesi hâlinde iade değerlendirmeye alınır.</li>
        </ul>
        <div class="info-box">
            <svg style="width:16px;height:16px;color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <p style="margin:0;">İade talepleri, katkı sağlayan kişinin ödeme yaptığı kart veya banka hesabına, bankanın işlem süreleri çerçevesinde (genellikle 5–10 iş günü) yansıtılır.</p>
        </div>
    </div>

    <!-- Cayma Hakkı -->
    <div class="policy-section">
        <h2><span class="num">4</span> Cayma Hakkı</h2>
        <p>6502 sayılı Tüketicinin Korunması Hakkında Kanun'un 48. maddesi ve Mesafeli Sözleşmeler Yönetmeliği kapsamında genel cayma hakkı bilgilendirmesi:</p>
        <ul>
            <li>Mesafeli sözleşmelerde tüketicilerin 14 günlük cayma hakkı mevcuttur.</li>
            <li>Ancak bağış/katkı niteliğindeki gönüllü ödemeler, kural olarak ticari mal veya hizmet satışına ilişkin sözleşme hükümleri kapsamında değerlendirilmemektedir.</li>
            <li>Öte yandan platformumuz, teknik hata veya onay öncesi durumlarda iade işlemini kolaylaştırma yükümlülüğünü benimsemektedir.</li>
        </ul>
        <p style="margin-top:12px;">Cayma hakkına ilişkin sorularınız için iletişim bilgilerimizden bize ulaşabilirsiniz.</p>
    </div>

    <!-- Uyuşmazlık Çözümü -->
    <div class="policy-section">
        <h2><span class="num">5</span> Şikâyet ve Uyuşmazlık Çözümü</h2>
        <p>Herhangi bir sorun veya şikâyet durumunda başvurabileceğiniz yollar:</p>
        <ul>
            <li><strong>Öncelikli Başvuru:</strong> <a href="<?= url('iletisim') ?>" style="color:#009999;font-weight:600;">İletişim Formu</a> veya <a href="mailto:basin@aybu.edu.tr" style="color:#009999;font-weight:600;">basin@aybu.edu.tr</a> — En geç 5 iş günü içinde yanıt verilmektedir.</li>
            <li><strong>Tüketici Hakem Heyeti:</strong> 6502 sayılı Kanun kapsamında yetkili Tüketici Hakem Heyeti'ne başvurabilirsiniz.</li>
            <li><strong>Tüketici Mahkemesi:</strong> Uyuşmazlığın çözümünde yetkili Ankara Tüketici Mahkemesi'ne başvurabilirsiniz.</li>
            <li><strong>e-Devlet:</strong> <a href="https://www.tuketicisikayeti.gov.tr" target="_blank" rel="noopener" style="color:#009999;">tuketicisikayeti.gov.tr</a> üzerinden Ticaret Bakanlığı şikâyet portalına başvurabilirsiniz.</li>
        </ul>
    </div>

    <!-- İletişim -->
    <div class="policy-section" style="border-color:#e0f7fa;background:#f0fdfe;">
        <h2><span class="num" style="background:#c7f5fb;">6</span> İletişim Bilgileri</h2>
        <ul>
            <li><strong>Kurum:</strong> Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü</li>
            <li><strong>Adres:</strong> Esenboğa Külliyesi, Esenboğa / ANKARA</li>
            <li><strong>E-posta:</strong> <a href="mailto:basin@aybu.edu.tr" style="color:#009999;">basin@aybu.edu.tr</a></li>
            <li><strong>Telefon:</strong> <a href="tel:+903129061000" style="color:#009999;">+90 312 906 10 00</a></li>
            <li><strong>Çalışma Saatleri:</strong> Pazartesi – Cuma, 08:30 – 17:30</li>
        </ul>
    </div>

    <p style="text-align:center;font-size:12px;color:#9ca3af;margin-top:8px;">Bu politika en son Haziran 2026 tarihinde güncellenmiştir.</p>

</div>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
