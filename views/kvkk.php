<?php
$pageTitle  = 'KVKK ve Gizlilik Politikası';
$activePage = '';
$metaDesc   = 'Askıda Kampüs kişisel verilerin korunması ve gizlilik politikası.';
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
.updated-badge { display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 999px; margin-bottom: 8px; }
</style>

<!-- Hero -->
<div class="policy-hero">
    <p style="font-size:12px;font-weight:600;color:#7dd8f0;letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;">Yasal Bilgilendirme</p>
    <h1 style="font-size:clamp(26px,4vw,38px);font-weight:800;color:#fff;margin-bottom:14px;">KVKK ve Gizlilik Politikası</h1>
    <p style="font-size:15px;color:rgba(255,255,255,0.7);max-width:560px;margin:0 auto;line-height:1.7;">
        6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında kişisel verilerinizin işlenmesi hakkında bilgilendirme.
    </p>
</div>

<div class="policy-body">

    <div style="text-align:center;margin-bottom:36px;">
        <span class="updated-badge">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Son Güncelleme: Haziran 2026
        </span>
    </div>

    <!-- Veri Sorumlusu -->
    <div class="policy-section">
        <h2><span class="num">1</span> Veri Sorumlusu</h2>
        <p>Bu aydınlatma metni, <strong>Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü</strong> tarafından işletilen <strong>Askıda Kampüs</strong> platformu (aybu.askidakampus.com) kapsamında 6698 sayılı Kişisel Verilerin Korunması Kanunu'nun 10. maddesi uyarınca hazırlanmıştır.</p>
        <ul style="margin-top:12px;">
            <li><strong>Veri Sorumlusu:</strong> Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü</li>
            <li><strong>Adres:</strong> Esenboğa Külliyesi, Esenboğa / ANKARA</li>
            <li><strong>E-posta:</strong> basin@aybu.edu.tr</li>
            <li><strong>Telefon:</strong> +90 312 906 10 00</li>
        </ul>
    </div>

    <!-- İşlenen Veriler -->
    <div class="policy-section">
        <h2><span class="num">2</span> İşlenen Kişisel Veriler</h2>
        <table>
            <thead>
                <tr>
                    <th>Veri Kategorisi</th>
                    <th>Veriler</th>
                    <th>Toplama Yöntemi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Kimlik</strong></td>
                    <td>Ad, soyad</td>
                    <td>Kayıt formu</td>
                </tr>
                <tr>
                    <td><strong>İletişim</strong></td>
                    <td>E-posta adresi, telefon numarası</td>
                    <td>Kayıt formu</td>
                </tr>
                <tr>
                    <td><strong>Ödeme</strong></td>
                    <td>Ödeme tutarı, işlem tarihi (kart bilgileri sistemimizde saklanmaz)</td>
                    <td>Ödeme işlemi sırasında</td>
                </tr>
                <tr>
                    <td><strong>İşlem Güvenliği</strong></td>
                    <td>IP adresi, oturum bilgileri, başarısız giriş kayıtları</td>
                    <td>Sistem logları</td>
                </tr>
                <tr>
                    <td><strong>Kullanım</strong></td>
                    <td>Rezervasyon ve katkı geçmişi</td>
                    <td>Platform kullanımı</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- İşleme Amaçları -->
    <div class="policy-section">
        <h2><span class="num">3</span> Kişisel Verilerin İşlenme Amaçları</h2>
        <p>Kişisel verileriniz aşağıdaki amaçlarla işlenmektedir:</p>
        <ul>
            <li>Öğrenci ve katkı sağlayan hesaplarının oluşturulması ve yönetilmesi</li>
            <li>Rezervasyon ve katkı işlemlerinin gerçekleştirilmesi</li>
            <li>E-posta doğrulama ve güvenlik bildirimleri gönderilmesi</li>
            <li>Ödeme işlemlerinin doğrulanması ve kayıt altına alınması</li>
            <li>Hizmet kalitesinin iyileştirilmesi ve istatistiksel analiz yapılması</li>
            <li>Yetkisiz erişim ve dolandırıcılık girişimlerinin önlenmesi</li>
            <li>Yasal yükümlülüklerin yerine getirilmesi</li>
        </ul>
    </div>

    <!-- Hukuki Dayanak -->
    <div class="policy-section">
        <h2><span class="num">4</span> İşlemenin Hukuki Dayanakları</h2>
        <ul>
            <li><strong>Sözleşmenin kurulması/ifası:</strong> Üyelik ve işlem süreçleri için kimlik ve iletişim verileri</li>
            <li><strong>Meşru menfaat:</strong> Güvenlik logları ve dolandırıcılık önleme kayıtları</li>
            <li><strong>Açık rıza:</strong> Pazarlama amaçlı iletişim (ileride uygulanabilir)</li>
            <li><strong>Yasal yükümlülük:</strong> Muhasebe ve vergi mevzuatı kapsamındaki kayıtlar</li>
        </ul>
    </div>

    <!-- Aktarım -->
    <div class="policy-section">
        <h2><span class="num">5</span> Kişisel Verilerin Aktarılması</h2>
        <p>Kişisel verileriniz, yalnızca aşağıdaki taraflarla ve belirtilen amaçlarla paylaşılmaktadır:</p>
        <ul>
            <li><strong>Halkbank:</strong> Ödeme işlemlerinin gerçekleştirilmesi amacıyla zorunlu ödeme verileri</li>
            <li><strong>Cloudflare:</strong> İnternet güvenliği ve DDoS koruması kapsamında teknik bağlantı verileri</li>
            <li><strong>AYBU İlgili Birimleri:</strong> Mevzuat gereği bilgilendirme ve denetim süreçleri</li>
            <li><strong>Yetkili Kamu Kurumları:</strong> Yasal yükümlülük çerçevesinde talep üzerine</li>
        </ul>
        <p style="margin-top:12px;">Kişisel verileriniz, yukarıda belirtilen durumlar dışında herhangi bir üçüncü tarafla paylaşılmamaktadır.</p>
    </div>

    <!-- Saklama Süreleri -->
    <div class="policy-section">
        <h2><span class="num">6</span> Saklama Süreleri</h2>
        <table>
            <thead>
                <tr><th>Veri</th><th>Saklama Süresi</th></tr>
            </thead>
            <tbody>
                <tr><td>Hesap ve işlem verileri</td><td>Üyelik süresince + 5 yıl</td></tr>
                <tr><td>Ödeme kayıtları</td><td>Yasal süre olan 10 yıl</td></tr>
                <tr><td>Güvenlik logları</td><td>1 yıl</td></tr>
                <tr><td>E-posta doğrulama tokenları</td><td>10 dakika (otomatik silinir)</td></tr>
            </tbody>
        </table>
    </div>

    <!-- Haklarınız -->
    <div class="policy-section">
        <h2><span class="num">7</span> KVKK Kapsamındaki Haklarınız</h2>
        <p>6698 sayılı Kanun'un 11. maddesi uyarınca aşağıdaki haklara sahipsiniz:</p>
        <ul>
            <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
            <li>İşlenmişse buna ilişkin bilgi talep etme</li>
            <li>İşlenme amacını ve amacına uygun kullanılıp kullanılmadığını öğrenme</li>
            <li>Yurt içinde veya yurt dışında aktarıldığı üçüncü kişileri bilme</li>
            <li>Eksik veya yanlış işlenmiş verilerin düzeltilmesini isteme</li>
            <li>KVKK'nın 7. maddesinde öngörülen şartlar çerçevesinde silinmesini isteme</li>
            <li>İşlemenin sonuçlarına itiraz etme</li>
            <li>Zarara uğramanız hâlinde zararın giderilmesini talep etme</li>
        </ul>
        <p style="margin-top:12px;">Haklarınızı kullanmak için <a href="mailto:basin@aybu.edu.tr" style="color:#009999;font-weight:600;">basin@aybu.edu.tr</a> adresine yazılı olarak başvurabilirsiniz.</p>
    </div>

    <!-- Çerezler -->
    <div class="policy-section">
        <h2><span class="num">8</span> Çerez (Cookie) Politikası</h2>
        <p>Askıda Kampüs yalnızca aşağıdaki zorunlu çerezleri kullanmaktadır:</p>
        <table>
            <thead>
                <tr><th>Çerez Adı</th><th>Amaç</th><th>Süre</th></tr>
            </thead>
            <tbody>
                <tr><td>Oturum Çerezi</td><td>Giriş durumunun korunması; güvenli ve sadece HTTP erişimine açık olarak ayarlanmıştır</td><td>Tarayıcı kapanınca</td></tr>
            </tbody>
        </table>
        <p style="margin-top:12px;">Pazarlama, izleme veya üçüncü taraf analitik çerezleri kullanılmamaktadır.</p>
    </div>

    <!-- İletişim -->
    <div class="policy-section" style="border-color:#e0f7fa;background:#f0fdfe;">
        <h2><span class="num" style="background:#c7f5fb;">9</span> İletişim</h2>
        <p>Bu politikaya ilişkin sorularınız için:</p>
        <ul style="margin-top:10px;">
            <li><strong>E-posta:</strong> <a href="mailto:basin@aybu.edu.tr" style="color:#009999;">basin@aybu.edu.tr</a></li>
            <li><strong>Adres:</strong> AYBU İktisadi İşletmeler Müdürlüğü, Esenboğa Külliyesi, ANKARA</li>
            <li><strong>Web:</strong> <a href="<?= url('iletisim') ?>" style="color:#009999;">İletişim Formu</a></li>
        </ul>
    </div>

</div>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
