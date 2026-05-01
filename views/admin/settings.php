<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Sistem Ayarları</h1>
    <p class="text-gray-500 text-sm mt-1">Email, SMTP ve rezervasyon limitlerini yönetin</p>
</div>

<?php if (flash('success')): ?>
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
    <?= e(flash('success')) ?>
</div>
<?php endif; ?>

<!-- Tabs -->
<div class="mb-6 border-b border-gray-200">
    <nav class="-mb-px flex gap-6">
        <button type="button" onclick="showTab('smtp')" id="tab-smtp" class="tab-button py-4 px-1 border-b-2 border-[#00A3B4] font-medium text-sm text-[#00A3B4]">
            SMTP Ayarları
        </button>
        <button type="button" onclick="showTab('email')" id="tab-email" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            Email İçerikleri
        </button>
        <button type="button" onclick="showTab('limits')" id="tab-limits" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            Rezervasyon Limitleri
        </button>
    </nav>
</div>

<!-- SMTP Tab -->
<div id="content-smtp" class="tab-content bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="<?= url('admin/ayarlar') ?>" class="space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="tab" value="smtp">

        <div class="border-b border-gray-200 pb-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">SMTP Email Ayarları</h2>
            <p class="text-sm text-gray-500">Şifre sıfırlama ve bağış teşekkür emaillerinin gönderimi için gereklidir</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- SMTP Host -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Sunucu Adresi</label>
                <input type="text" name="mail_host" value="<?= e($mailSettings['host'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                    placeholder="mail.yourdomain.com" required>
                <p class="text-xs text-gray-500 mt-1">Sunucunuzun SMTP adresi</p>
            </div>

            <!-- SMTP Port -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Port</label>
                <input type="number" name="mail_port" value="<?= e($mailSettings['port'] ?? '587') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                    placeholder="587" required>
                <p class="text-xs text-gray-500 mt-1">Genellikle TLS için 587, SSL için 465</p>
            </div>

            <!-- SMTP Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Kullanıcı Adı</label>
                <input type="text" name="mail_username" value="<?= e($mailSettings['username'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                    placeholder="noreply@aybu.edu.tr" required>
                <p class="text-xs text-gray-500 mt-1">SMTP sunucusu için kullanıcı adı (genellikle email adresi)</p>
            </div>

            <!-- SMTP Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Şifresi</label>
                <input type="password" name="mail_password" value="<?= e($mailSettings['password'] ?? '') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                    placeholder="••••••••" required>
                <p class="text-xs text-gray-500 mt-1">Email hesabınızın şifresi</p>
            </div>

            <!-- Encryption -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Şifreleme Türü</label>
                <select name="mail_encryption"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]">
                    <option value="tls" <?= ($mailSettings['encryption'] ?? 'tls') === 'tls' ? 'selected' : '' ?>>TLS (Önerilen)</option>
                    <option value="ssl" <?= ($mailSettings['encryption'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                </select>
            </div>

            <!-- From Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gönderen Email Adresi</label>
                <input type="email" name="mail_from_address" value="<?= e($mailSettings['from_address'] ?? 'noreply@askidakampus.com') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                    placeholder="noreply@askidakampus.com" required>
            </div>

            <!-- From Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gönderen Adı</label>
                <input type="text" name="mail_from_name" value="<?= e($mailSettings['from_name'] ?? 'AYBÜ Askıda Kampüs') ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                    placeholder="AYBÜ Askıda Kampüs" required>
                <p class="text-xs text-gray-500 mt-1">Email'lerde görünecek gönderen adı</p>
            </div>
        </div>

        <!-- SMTP Bilgilendirme -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-blue-800 mb-2">ℹ️ SMTP Ayarları Hakkında</h3>
            <div class="text-sm text-blue-700 space-y-2">
                <p><strong>SMTP Sunucu Bilgileri:</strong> Email sunucunuzun yöneticisinden SMTP sunucu adresi, port, kullanıcı adı ve şifre bilgilerini alın.</p>
                <p><strong>Şifreleme:</strong> Güvenli bağlantı için TLS (587 port) veya SSL (465 port) kullanılması önerilir.</p>
                <p><strong>Test:</strong> Ayarları kaydettikten sonra "Şifremi Unuttum" özelliğini kullanarak email gönderimini test edebilirsiniz.</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                class="px-6 py-2.5 bg-[#00A3B4] hover:bg-[#008899] text-white font-medium rounded-lg transition">
                SMTP Ayarlarını Kaydet
            </button>
        </div>
    </form>
</div>

<!-- Email Content Tab -->
<div id="content-email" class="tab-content hidden bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="<?= url('admin/ayarlar') ?>" class="space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="tab" value="email">

        <div class="border-b border-gray-200 pb-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Bağış Teşekkür Emaili</h2>
            <p class="text-sm text-gray-500">Bağışçılara gönderilecek teşekkür emailinin içeriğini düzenleyin</p>
        </div>

        <!-- Email Subject -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email Konusu</label>
            <input type="text" name="email_donation_subject" 
                value="<?= e($emailSettings['donation_subject'] ?? 'Bağışınız İçin Teşekkür Ederiz - AYBÜ Askıda Kampüs') ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                required>
        </div>

        <!-- Greeting -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Selamlama</label>
            <input type="text" name="email_donation_greeting" 
                value="<?= e($emailSettings['donation_greeting'] ?? 'Sayın {{donor_name}},') ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                required>
            <p class="text-xs text-gray-500 mt-1">{{donor_name}} bağışçının adını gösterir</p>
        </div>

        <!-- Body -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Ana İçerik</label>
            <textarea name="email_donation_body" rows="6"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                required><?= e($emailSettings['donation_body'] ?? 'Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü olarak, Askıda Kampüs projemize yapmış olduğunuz değerli bağış için en içten teşekkürlerimizi sunarız.

Göstermiş olduğunuz bu duyarlılık ve sosyal sorumluluk bilinci, öğrencilerimizin kampüs yaşamına anlamlı bir katkı sağlamaktadır. Bağışınız, ihtiyaç sahibi öğrencilerimizin kampüs içerisindeki işletmelerden faydalanabilmesine vesile olacaktır.') ?></textarea>
        </div>

        <!-- Footer Text -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Alt Bilgi Metni</label>
            <textarea name="email_donation_footer_text" rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                required><?= e($emailSettings['donation_footer_text'] ?? 'Bağışınız onaylandıktan sonra, belirlediğiniz ürünler işletme stoğuna eklenecek ve öğrencilerimiz tarafından rezerve edilebilecektir.

Destekleriniz için tekrar teşekkür eder, saygılarımızı sunarız.') ?></textarea>
        </div>

        <!-- Signature -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">İmza</label>
            <textarea name="email_donation_signature" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                required><?= e($emailSettings['donation_signature'] ?? 'Ankara Yıldırım Beyazıt Üniversitesi
İktisadi İşletmeler Müdürlüğü
Askıda Kampüs Projesi') ?></textarea>
        </div>

        <!-- Placeholders Info -->
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-amber-800 mb-2">📝 Kullanılabilir Değişkenler</h3>
            <div class="text-sm text-amber-700 space-y-1">
                <p><code class="bg-amber-100 px-2 py-0.5 rounded">{{donor_name}}</code> - Bağışçının adı</p>
                <p><code class="bg-amber-100 px-2 py-0.5 rounded">{{venue_name}}</code> - İşletme adı</p>
                <p><code class="bg-amber-100 px-2 py-0.5 rounded">{{total_amount}}</code> - Toplam tutar</p>
                <p><code class="bg-amber-100 px-2 py-0.5 rounded">{{donation_date}}</code> - Bağış tarihi</p>
                <p class="text-xs mt-2">Bu değişkenler email gönderilirken otomatik olarak gerçek değerlerle değiştirilir.</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                class="px-6 py-2.5 bg-[#00A3B4] hover:bg-[#008899] text-white font-medium rounded-lg transition">
                Email İçeriklerini Kaydet
            </button>
        </div>
    </form>
</div>

<!-- Limits Tab -->
<div id="content-limits" class="tab-content hidden bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="<?= url('admin/ayarlar') ?>" class="space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="tab" value="limits">

        <div class="border-b border-gray-200 pb-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Rezervasyon Limitleri</h2>
            <p class="text-sm text-gray-500">Öğrencilerin ne kadar rezervasyon yapabileceğini belirleyin</p>
        </div>

        <div class="max-w-sm space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Haftalık Rezervasyon Limiti</label>
                <input type="number" name="student_weekly_limit" min="1" max="50"
                       value="<?= (int)($weeklyLimit ?? 5) ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4]"
                       required>
                <p class="text-xs text-gray-500 mt-1">Bir öğrencinin haftada (Pazartesi–Pazar) yapabileceği maksimum rezervasyon sayısı.</p>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-blue-800 mb-1">Nasıl çalışır?</h3>
            <ul class="text-sm text-blue-700 space-y-1 list-disc list-inside">
                <li>Her öğrenci için ayrı ayrı günlük limit de uygulanmaya devam eder (kullanıcı profilinden değiştirilebilir).</li>
                <li>Haftalık limit her Pazartesi günü otomatik olarak sıfırlanır.</li>
                <li>Sadece "teslim alındı" ve "aktif" rezervasyonlar sayıya dahildir; iptal ve süresi dolanlar sayılmaz.</li>
            </ul>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
            <button type="submit"
                class="px-6 py-2.5 bg-[#00A3B4] hover:bg-[#008899] text-white font-medium rounded-lg transition">
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
        btn.classList.remove('border-[#00A3B4]', 'text-[#00A3B4]');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active state to selected button
    const activeBtn = document.getElementById('tab-' + tabName);
    activeBtn.classList.remove('border-transparent', 'text-gray-500');
    activeBtn.classList.add('border-[#00A3B4]', 'text-[#00A3B4]');
}
</script>

<?php include ROOT . '/views/layout/footer.php'; ?>
