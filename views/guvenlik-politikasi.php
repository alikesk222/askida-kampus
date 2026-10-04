<?php
$pageTitle  = 'Güvenlik Politikası';
$activePage = '';
$metaDesc   = 'Askıda Kampüs güvenlik politikası, SSL şifreleme ve kişisel veri güvenliği hakkında bilgi.';
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
.sec-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 999px; font-size: 12px; font-weight: 700; margin-bottom: 6px; }
.sec-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-top: 16px; }
.sec-card { background: #f8fafc; border: 1px solid #e8edf2; border-radius: 10px; padding: 20px; display: flex; flex-direction: column; gap: 8px; }
.sec-card .icon-wrap { width: 40px; height: 40px; border-radius: 10px; background: #e0f7fa; display: flex; align-items: center; justify-content: center; }
.sec-card strong { font-size: 13.5px; color: #0d1f3c; }
.sec-card p { font-size: 12.5px; color: #6b7280; line-height: 1.6; margin: 0; }
</style>

<!-- Hero -->
<div class="policy-hero">
    <p style="font-size:12px;font-weight:600;color:#7dd8f0;letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;">Bilgi Güvenliği</p>
    <h1 style="font-size:clamp(26px,4vw,38px);font-weight:800;color:#fff;margin-bottom:14px;">Güvenlik Politikası</h1>
    <p style="font-size:15px;color:rgba(255,255,255,0.7);max-width:560px;margin:0 auto;line-height:1.7;">
        Verilerinizin ve ödeme işlemlerinizin güvenliği için uygulanan teknik ve idari tedbirler.
    </p>
</div>

<div class="policy-body">

    <div style="text-align:center;margin-bottom:36px;display:flex;flex-wrap:wrap;justify-content:center;gap:10px;">
        <span class="sec-badge" style="background:#e0f7fa;color:#007a7a;border:1px solid #b2ebf2;">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            SSL 256-bit Şifreleme
        </span>
        <span class="sec-badge" style="background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Cloudflare Koruması
        </span>
        <span class="sec-badge" style="background:#fefce8;color:#854d0e;border:1px solid #fde68a;">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            3D Secure Ödeme
        </span>
        <span class="sec-badge" style="background:#f5f3ff;color:#5b21b6;border:1px solid #ddd6fe;">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            Güçlü Şifre Zorunluluğu
        </span>
    </div>

    <!-- Ağ ve Bağlantı Güvenliği -->
    <div class="policy-section">
        <h2><span class="num">1</span> Ağ ve Bağlantı Güvenliği</h2>
        <div class="sec-grid">
            <div class="sec-card">
                <div class="icon-wrap">
                    <svg style="width:20px;height:20px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <strong>TLS 1.2 / 1.3 Şifreleme</strong>
                <p>Tüm bağlantılar HTTPS üzerinden 256-bit SSL/TLS şifreleme ile korunmaktadır.</p>
            </div>
            <div class="sec-card">
                <div class="icon-wrap">
                    <svg style="width:20px;height:20px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <strong>Cloudflare WAF</strong>
                <p>Web uygulama güvenlik duvarı (WAF) ile SQL enjeksiyonu ve XSS saldırılarına karşı koruma.</p>
            </div>
            <div class="sec-card">
                <div class="icon-wrap">
                    <svg style="width:20px;height:20px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <strong>DDoS Koruması</strong>
                <p>Cloudflare altyapısı üzerinden otomatik DDoS saldırı tespiti ve engelleme.</p>
            </div>
            <div class="sec-card">
                <div class="icon-wrap">
                    <svg style="width:20px;height:20px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                </div>
                <strong>HSTS</strong>
                <p>HTTP Strict Transport Security ile tarayıcı düzeyinde zorunlu HTTPS bağlantısı.</p>
            </div>
        </div>
    </div>

    <!-- Ödeme Güvenliği -->
    <div class="policy-section">
        <h2><span class="num">2</span> Ödeme Güvenliği</h2>
        <p>Askıda Kampüs üzerinden gerçekleştirilen tüm ödeme işlemleri aşağıdaki güvenlik standartlarına uygun olarak işlenmektedir:</p>
        <ul>
            <li><strong>3D Secure:</strong> Tüm kartlı ödemeler banka tarafından 3D Secure doğrulamasına tabi tutulur.</li>
            <li><strong>Kart Bilgisi Saklanmaz:</strong> Kart numarası, CVV veya kart sahibi bilgileri sistemimiz üzerinde hiçbir şekilde saklanmaz.</li>
            <li><strong>Tokenization:</strong> Ödeme işlemleri Halkbank Sanal POS altyapısı üzerinden gerçekleştirilmekte olup kart verileri doğrudan banka sistemine iletilmektedir.</li>
            <li><strong>PCI-DSS Uyumu:</strong> Ödeme altyapısı PCI-DSS standartlarını karşılayan Halkbank sistemi üzerinden yürütülmektedir.</li>
        </ul>
    </div>

    <!-- Hesap Güvenliği -->
    <div class="policy-section">
        <h2><span class="num">3</span> Hesap ve Kimlik Doğrulama Güvenliği</h2>
        <ul>
            <li><strong>Şifre Güvenliği:</strong> Şifreler endüstri standardı kriptografik hash yöntemiyle tek yönlü olarak saklanmakta; düz metin olarak asla tutulmamaktadır.</li>
            <li><strong>Şifre Karmaşıklığı:</strong> Büyük harf, küçük harf, rakam ve özel karakter zorunludur.</li>
            <li><strong>E-posta Doğrulama:</strong> Yeni hesaplarda tek kullanımlık kod (OTP) ile e-posta doğrulaması yapılmaktadır.</li>
            <li><strong>Kaba Kuvvet Koruması:</strong> Art arda gerçekleşen başarısız giriş denemelerinde IP tabanlı geçici erişim kısıtlaması uygulanmaktadır.</li>
            <li><strong>CSRF Koruması:</strong> Tüm form işlemleri oturum bazlı token doğrulaması ile güvence altındadır.</li>
            <li><strong>Bot Koruması:</strong> Kayıt ve giriş formları çok katmanlı otomatik tehdit algılama yöntemleriyle bot saldırılarına karşı korunmaktadır.</li>
        </ul>
    </div>

    <!-- Veri Güvenliği -->
    <div class="policy-section">
        <h2><span class="num">4</span> Veri Güvenliği</h2>
        <ul>
            <li><strong>Veri Tabanı Güvenliği:</strong> Tüm veritabanı işlemleri parametrik sorgular aracılığıyla gerçekleştirilmekte, SQL enjeksiyonuna karşı koruma sağlanmaktadır.</li>
            <li><strong>Oturum Güvenliği:</strong> Oturum çerezleri <code>Secure</code>, <code>HttpOnly</code> ve <code>SameSite=Lax</code> bayrakları ile korunmaktadır.</li>
            <li><strong>Erişim Kontrolü:</strong> Rol tabanlı yetkilendirme sistemi; her kullanıcı yalnızca kendi yetkisi dahilindeki verilere erişebilmektedir.</li>
            <li><strong>Yüklenen Dosyalar:</strong> Öğrenci belgeleri MIME türü doğrulamasından geçirilmekte ve herkese açık olmayan güvenli dizinde saklanmaktadır.</li>
        </ul>
    </div>

    <!-- Güvenlik Açığı Bildirimi -->
    <div class="policy-section" style="border-color:#e0f7fa;background:#f0fdfe;">
        <h2><span class="num">5</span> Güvenlik Açığı Bildirimi</h2>
        <p>Sistemimizde bir güvenlik açığı keşfederseniz lütfen <strong>basin@aybu.edu.tr</strong> adresine sorumlu ifşa (responsible disclosure) ilkesiyle bildirin. Bildirimin ardından en geç <strong>5 iş günü</strong> içinde geri dönüş yapılacaktır.</p>
        <p style="margin-top:10px;"><strong>Lütfen şunları yapmayın:</strong> Açığı kamuoyuna açıklamak, sisteme zarar vermek veya kullanıcı verilerine yetkisiz erişim sağlamak.</p>
    </div>

    <!-- Son Güncelleme -->
    <p style="text-align:center;font-size:12px;color:#9ca3af;margin-top:8px;">Bu politika en son Haziran 2026 tarihinde güncellenmiştir.</p>

</div>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
