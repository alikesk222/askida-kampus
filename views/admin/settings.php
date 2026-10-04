<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Sayfa yolu">
            <a href="<?= url('admin') ?>">Dashboard</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span>Ayarlar</span>
        </nav>
        <h1 class="page-title">Sistem Ayarları</h1>
        <p class="page-desc">Email, SMTP ve rezervasyon limitlerini yönetin</p>
    </div>
</div>

<?php if (flash('success')): ?>
<div class="flash flash-success mb-6" role="status">
    <div class="flash-body"><?= e(flash('success')) ?></div>
</div>
<?php endif; ?>

<!-- Tabs -->
<div class="admin-tabs" role="tablist">
    <button type="button" onclick="showTab('smtp')" id="tab-smtp" class="tab-button admin-tab is-active">
        SMTP Ayarları
    </button>
    <button type="button" onclick="showTab('email')" id="tab-email" class="tab-button admin-tab">
        Email İçerikleri
    </button>
    <button type="button" onclick="showTab('limits')" id="tab-limits" class="tab-button admin-tab">
        Rezervasyon Limitleri
    </button>
</div>

<!-- SMTP Tab -->
<div id="content-smtp" class="tab-content">
    <form method="POST" action="<?= url('admin/ayarlar') ?>" class="space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="tab" value="smtp">

        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">SMTP Email Ayarları</h2>
                    <p class="form-help">Şifre sıfırlama ve katkı teşekkür emaillerinin gönderimi için gereklidir</p>
                </div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- SMTP Host -->
                    <div>
                        <label class="form-label">SMTP Sunucu Adresi</label>
                        <input type="text" name="mail_host" value="<?= e($mailSettings['host'] ?? '') ?>"
                            class="form-input"
                            placeholder="mail.yourdomain.com" required>
                        <p class="form-help">Sunucunuzun SMTP adresi</p>
                    </div>

                    <!-- SMTP Port -->
                    <div>
                        <label class="form-label">SMTP Port</label>
                        <input type="number" name="mail_port" value="<?= e($mailSettings['port'] ?? '587') ?>"
                            class="form-input"
                            placeholder="587" required>
                        <p class="form-help">Genellikle TLS için 587, SSL için 465</p>
                    </div>

                    <!-- SMTP Username -->
                    <div>
                        <label class="form-label">SMTP Kullanıcı Adı</label>
                        <input type="text" name="mail_username" value="<?= e($mailSettings['username'] ?? '') ?>"
                            class="form-input"
                            placeholder="noreply@aybu.edu.tr" required>
                        <p class="form-help">SMTP sunucusu için kullanıcı adı (genellikle email adresi)</p>
                    </div>

                    <!-- SMTP Password -->
                    <div>
                        <label class="form-label">SMTP Şifresi</label>
                        <input type="password" name="mail_password" value="<?= e($mailSettings['password'] ?? '') ?>"
                            class="form-input"
                            placeholder="••••••••" required>
                        <p class="form-help">Email hesabınızın şifresi</p>
                    </div>

                    <!-- Encryption -->
                    <div>
                        <label class="form-label">Şifreleme Türü</label>
                        <select name="mail_encryption" class="form-select">
                            <option value="tls" <?= ($mailSettings['encryption'] ?? 'tls') === 'tls' ? 'selected' : '' ?>>TLS (Önerilen)</option>
                            <option value="ssl" <?= ($mailSettings['encryption'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                        </select>
                    </div>

                    <!-- From Address -->
                    <div>
                        <label class="form-label">Gönderen Email Adresi</label>
                        <input type="email" name="mail_from_address" value="<?= e($mailSettings['from_address'] ?? 'noreply@askidakampus.com') ?>"
                            class="form-input"
                            placeholder="noreply@askidakampus.com" required>
                    </div>

                    <!-- From Name -->
                    <div>
                        <label class="form-label">Gönderen Adı</label>
                        <input type="text" name="mail_from_name" value="<?= e($mailSettings['from_name'] ?? 'AYBÜ Askıda Kampüs') ?>"
                            class="form-input"
                            placeholder="AYBÜ Askıda Kampüs" required>
                        <p class="form-help">Email'lerde görünecek gönderen adı</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SMTP Bilgilendirme -->
        <div class="flash flash-info">
            <div class="flash-body">
                <h3 class="text-sm font-semibold mb-2">SMTP Ayarları Hakkında</h3>
                <div class="text-sm space-y-2">
                    <p><strong>SMTP Sunucu Bilgileri:</strong> Email sunucunuzun yöneticisinden SMTP sunucu adresi, port, kullanıcı adı ve şifre bilgilerini alın.</p>
                    <p><strong>Şifreleme:</strong> Güvenli bağlantı için TLS (587 port) veya SSL (465 port) kullanılması önerilir.</p>
                    <p><strong>Test:</strong> Ayarları kaydettikten sonra "Şifremi Unuttum" özelliğini kullanarak email gönderimini test edebilirsiniz.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button type="submit" class="btn btn-primary">
                SMTP Ayarlarını Kaydet
            </button>
        </div>
    </form>
</div>

<!-- Email Content Tab -->
<div id="content-email" class="tab-content hidden">
    <form method="POST" action="<?= url('admin/ayarlar') ?>" class="space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="tab" value="email">

        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Katkı Teşekkür Emaili</h2>
                    <p class="form-help">Katkı sağlayanlara gönderilecek teşekkür emailinin içeriğini düzenleyin</p>
                </div>
            </div>
            <div class="card-body space-y-6">
                <!-- Email Subject -->
                <div>
                    <label class="form-label">Email Konusu</label>
                    <input type="text" name="email_donation_subject"
                        value="<?= e($emailSettings['donation_subject'] ?? 'Katkınız İçin Teşekkür Ederiz - AYBÜ Askıda Kampüs') ?>"
                        class="form-input"
                        required>
                </div>

                <!-- Greeting -->
                <div>
                    <label class="form-label">Selamlama</label>
                    <input type="text" name="email_donation_greeting"
                        value="<?= e($emailSettings['donation_greeting'] ?? 'Sayın {{donor_name}},') ?>"
                        class="form-input"
                        required>
                    <p class="form-help">{{donor_name}} katkı sağlayanın adını gösterir</p>
                </div>

                <!-- Body -->
                <div>
                    <label class="form-label">Ana İçerik</label>
                    <textarea name="email_donation_body" rows="6"
                        class="form-textarea"
                        required><?= e($emailSettings['donation_body'] ?? 'Askıda Kampüs projesine sağlamış olduğunuz değerli katkı için en içten teşekkürlerimizi sunarız.

Göstermiş olduğunuz bu duyarlılık ve sosyal sorumluluk bilinci, öğrencilerimizin kampüs yaşamına anlamlı bir destek olmaktadır. Katkınız, öğrencilerimizin kampüs içerisindeki işletmelerden yararlanabilmesine vesile olacaktır.') ?></textarea>
                </div>

                <!-- Footer Text -->
                <div>
                    <label class="form-label">Alt Bilgi Metni</label>
                    <textarea name="email_donation_footer_text" rows="4"
                        class="form-textarea"
                        required><?= e($emailSettings['donation_footer_text'] ?? 'Katkınız onaylandıktan sonra, belirlediğiniz ürünler işletme stoğuna eklenecek ve öğrencilerimiz tarafından rezerve edilebilecektir.

Destekleriniz için tekrar teşekkür eder, saygılarımızı sunarız.') ?></textarea>
                </div>

                <!-- Signature -->
                <div>
                    <label class="form-label">İmza</label>
                    <textarea name="email_donation_signature" rows="3"
                        class="form-textarea"
                        required><?= e($emailSettings['donation_signature'] ?? 'Ankara Yıldırım Beyazıt Üniversitesi
İktisadi İşletmeler Müdürlüğü
Askıda Kampüs Projesi') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Placeholders Info -->
        <div class="flash flash-warning">
            <div class="flash-body">
                <h3 class="text-sm font-semibold mb-2">Kullanılabilir Değişkenler</h3>
                <div class="text-sm space-y-1">
                    <p><code class="bg-white/60 px-2 py-0.5 rounded">{{donor_name}}</code> - Katkı sağlayanın adı</p>
                    <p><code class="bg-white/60 px-2 py-0.5 rounded">{{venue_name}}</code> - İşletme adı</p>
                    <p><code class="bg-white/60 px-2 py-0.5 rounded">{{total_amount}}</code> - Toplam tutar</p>
                    <p><code class="bg-white/60 px-2 py-0.5 rounded">{{donation_date}}</code> - Katkı tarihi</p>
                    <p class="text-xs mt-2">Bu değişkenler email gönderilirken otomatik olarak gerçek değerlerle değiştirilir.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button type="submit" class="btn btn-primary">
                Email İçeriklerini Kaydet
            </button>
        </div>
    </form>
</div>

<!-- Limits Tab -->
<div id="content-limits" class="tab-content hidden">
    <form method="POST" action="<?= url('admin/ayarlar') ?>" class="space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="tab" value="limits">

        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Rezervasyon Limitleri</h2>
                    <p class="form-help">Öğrencilerin ne kadar rezervasyon yapabileceğini belirleyin</p>
                </div>
            </div>
            <div class="card-body">
                <div class="max-w-sm space-y-6">
                    <div>
                        <label class="form-label">Haftalık Rezervasyon Limiti</label>
                        <input type="number" name="student_weekly_limit" min="1" max="50"
                               value="<?= (int)($weeklyLimit ?? 5) ?>"
                               class="form-input"
                               required>
                        <p class="form-help">Bir öğrencinin haftada (Pazartesi–Pazar) yapabileceği maksimum rezervasyon sayısı.</p>
                    </div>
                    <div>
                        <label class="form-label">Belge Onayı Başına Ek Hak</label>
                        <?php
                            $sm = new Models\SettingsModel();
                            $bonusQuota = (int) $sm->get('document_bonus_quota', 2);
                        ?>
                        <input type="number" name="document_bonus_quota" min="0" max="20"
                               value="<?= $bonusQuota ?>"
                               class="form-input"
                               required>
                        <p class="form-help">Öğrencinin burs belgesi onaylanınca haftalık limitine eklenecek ürün hakkı sayısı.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flash flash-info">
            <div class="flash-body">
                <h3 class="text-sm font-semibold mb-1">Nasıl çalışır?</h3>
                <ul class="text-sm space-y-1 list-disc list-inside">
                    <li>Her öğrenci için ayrı ayrı günlük limit de uygulanmaya devam eder (kullanıcı profilinden değiştirilebilir).</li>
                    <li>Haftalık limit her Pazartesi günü otomatik olarak sıfırlanır.</li>
                    <li>Sadece "teslim alındı" ve "aktif" rezervasyonlar sayıya dahildir; iptal ve süresi dolanlar sayılmaz.</li>
                </ul>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button type="submit" class="btn btn-primary">
                Limitleri Kaydet
            </button>
        </div>
    </form>
</div>

<script>
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });

    // Remove active state from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('is-active');
    });

    // Show selected tab
    document.getElementById('content-' + tabName).classList.remove('hidden');

    // Add active state to selected button
    document.getElementById('tab-' + tabName).classList.add('is-active');
}
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
