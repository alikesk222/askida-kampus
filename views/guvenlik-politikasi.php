<?php
$pageTitle  = 'Güvenlik Politikası';
$activePage = '';
$metaDesc   = 'Askıda Kampüs güvenlik politikası, SSL şifreleme ve kişisel veri güvenliği hakkında bilgi.';
include ROOT . '/views/layout/public-header.php';
?>

<!-- Hero -->
<header class="legal-hero on-dark relative overflow-hidden bg-navy-800">
    <div class="arch-lines arch-lines-sm" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-5xl px-6 py-14 sm:py-16">
        <p class="eyebrow eyebrow-light mb-3">Bilgi Güvenliği</p>
        <h1 class="text-3xl sm:text-4xl font-bold text-white leading-tight">Güvenlik Politikası</h1>
        <p class="mt-4 max-w-2xl text-base leading-relaxed text-navy-200">Verilerinizin ve ödeme işlemlerinizin güvenliği için uygulanan teknik ve idari tedbirler.</p>
    </div>
</header>

<div class="legal-body">
<article class="prose-legal">

    <div class="mb-8 flex flex-wrap gap-2.5">
        <span class="badge badge-plain legal-chip">
            <svg class="w-3.5 h-3.5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            SSL 256-bit Şifreleme
        </span>
        <span class="badge badge-plain legal-chip">
            <svg class="w-3.5 h-3.5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Cloudflare Koruması
        </span>
        <span class="badge badge-plain legal-chip">
            <svg class="w-3.5 h-3.5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            3D Secure Ödeme
        </span>
        <span class="badge badge-plain legal-chip">
            <svg class="w-3.5 h-3.5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            Güçlü Şifre Zorunluluğu
        </span>
    </div>

    <!-- Ağ ve Bağlantı Güvenliği -->
    <section class="legal-section">
        <h2><span class="legal-num">1</span>Ağ ve Bağlantı Güvenliği</h2>
        <div class="legal-grid">
            <div class="legal-card">
                <div class="icon-chip">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <strong>TLS 1.2 / 1.3 Şifreleme</strong>
                <p>Tüm bağlantılar HTTPS üzerinden 256-bit SSL/TLS şifreleme ile korunmaktadır.</p>
            </div>
            <div class="legal-card">
                <div class="icon-chip">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <strong>Cloudflare WAF</strong>
                <p>Web uygulama güvenlik duvarı (WAF) ile SQL enjeksiyonu ve XSS saldırılarına karşı koruma.</p>
            </div>
            <div class="legal-card">
                <div class="icon-chip">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <strong>DDoS Koruması</strong>
                <p>Cloudflare altyapısı üzerinden otomatik DDoS saldırı tespiti ve engelleme.</p>
            </div>
            <div class="legal-card">
                <div class="icon-chip">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                </div>
                <strong>HSTS</strong>
                <p>HTTP Strict Transport Security ile tarayıcı düzeyinde zorunlu HTTPS bağlantısı.</p>
            </div>
        </div>
    </section>

    <!-- Ödeme Güvenliği -->
    <section class="legal-section">
        <h2><span class="legal-num">2</span>Ödeme Güvenliği</h2>
        <p>Askıda Kampüs üzerinden gerçekleştirilen tüm ödeme işlemleri aşağıdaki güvenlik standartlarına uygun olarak işlenmektedir:</p>
        <ul>
            <li><strong>3D Secure:</strong> Tüm kartlı ödemeler banka tarafından 3D Secure doğrulamasına tabi tutulur.</li>
            <li><strong>Kart Bilgisi Saklanmaz:</strong> Kart numarası, CVV veya kart sahibi bilgileri sistemimiz üzerinde hiçbir şekilde saklanmaz.</li>
            <li><strong>Tokenization:</strong> Ödeme işlemleri Halkbank Sanal POS altyapısı üzerinden gerçekleştirilmekte olup kart verileri doğrudan banka sistemine iletilmektedir.</li>
            <li><strong>PCI-DSS Uyumu:</strong> Ödeme altyapısı PCI-DSS standartlarını karşılayan Halkbank sistemi üzerinden yürütülmektedir.</li>
        </ul>
    </section>

    <!-- Hesap Güvenliği -->
    <section class="legal-section">
        <h2><span class="legal-num">3</span>Hesap ve Kimlik Doğrulama Güvenliği</h2>
        <ul>
            <li><strong>Şifre Güvenliği:</strong> Şifreler endüstri standardı kriptografik hash yöntemiyle tek yönlü olarak saklanmakta; düz metin olarak asla tutulmamaktadır.</li>
            <li><strong>Şifre Karmaşıklığı:</strong> Büyük harf, küçük harf, rakam ve özel karakter zorunludur.</li>
            <li><strong>E-posta Doğrulama:</strong> Yeni hesaplarda tek kullanımlık kod (OTP) ile e-posta doğrulaması yapılmaktadır.</li>
            <li><strong>Kaba Kuvvet Koruması:</strong> Art arda gerçekleşen başarısız giriş denemelerinde IP tabanlı geçici erişim kısıtlaması uygulanmaktadır.</li>
            <li><strong>CSRF Koruması:</strong> Tüm form işlemleri oturum bazlı token doğrulaması ile güvence altındadır.</li>
            <li><strong>Bot Koruması:</strong> Kayıt ve giriş formları çok katmanlı otomatik tehdit algılama yöntemleriyle bot saldırılarına karşı korunmaktadır.</li>
        </ul>
    </section>

    <!-- Veri Güvenliği -->
    <section class="legal-section">
        <h2><span class="legal-num">4</span>Veri Güvenliği</h2>
        <ul>
            <li><strong>Veri Tabanı Güvenliği:</strong> Tüm veritabanı işlemleri parametrik sorgular aracılığıyla gerçekleştirilmekte, SQL enjeksiyonuna karşı koruma sağlanmaktadır.</li>
            <li><strong>Oturum Güvenliği:</strong> Oturum çerezleri <code>Secure</code>, <code>HttpOnly</code> ve <code>SameSite=Lax</code> bayrakları ile korunmaktadır.</li>
            <li><strong>Erişim Kontrolü:</strong> Rol tabanlı yetkilendirme sistemi; her kullanıcı yalnızca kendi yetkisi dahilindeki verilere erişebilmektedir.</li>
            <li><strong>Yüklenen Dosyalar:</strong> Öğrenci belgeleri MIME türü doğrulamasından geçirilmekte ve herkese açık olmayan güvenli dizinde saklanmaktadır.</li>
        </ul>
    </section>

    <!-- Güvenlik Açığı Bildirimi -->
    <section class="legal-section legal-section-accent">
        <h2><span class="legal-num">5</span>Güvenlik Açığı Bildirimi</h2>
        <p>Sistemimizde bir güvenlik açığı keşfederseniz lütfen <strong>basin@aybu.edu.tr</strong> adresine sorumlu ifşa (responsible disclosure) ilkesiyle bildirin. Bildirimin ardından en geç <strong>5 iş günü</strong> içinde geri dönüş yapılacaktır.</p>
        <p><strong>Lütfen şunları yapmayın:</strong> Açığı kamuoyuna açıklamak, sisteme zarar vermek veya kullanıcı verilerine yetkisiz erişim sağlamak.</p>
    </section>

    <!-- Son Güncelleme -->
    <p class="legal-updated">Bu politika en son Haziran 2026 tarihinde güncellenmiştir.</p>

</article>
</div>

<?php include ROOT . '/views/layout/public-footer.php'; ?>
