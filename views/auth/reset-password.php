<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Şifre Oluştur — Askıda Kampüs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen overflow-hidden relative">

<!-- Arka plan görseli - Tüm sayfa -->
<div class="fixed inset-0 bg-cover bg-center" style="background-image: url('<?= asset('images/login-bg.jpeg') ?>');"></div>
<div class="fixed inset-0 bg-black/40"></div>

<div class="min-h-screen flex items-center justify-center p-4 relative z-10">
    <!-- Form Panel -->
    <div class="w-full max-w-md bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8 lg:p-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="<?= url() ?>" class="inline-block">
                <img src="<?= asset('aybu.png') ?>" alt="AYBU Logo" class="h-16 w-auto mx-auto mb-4 hover:opacity-80 transition">
            </a>
            <h1 class="text-gray-800 text-lg font-semibold">Yeni Şifre Oluştur</h1>
            <p class="text-gray-500 text-sm mt-2">Lütfen yeni şifrenizi belirleyin</p>
        </div>

        <?php $flashError = flash('error'); ?>
        <?php if ($flashError): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            <?= e($flashError) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?= url('sifre-sifirla') ?>" class="space-y-5">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= e($token) ?>">
            <input type="hidden" name="email" value="<?= e($email) ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Yeni Şifre</label>
                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] text-sm"
                        placeholder="En az 8 karakter" autocomplete="new-password" required>
                    <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg id="eye-icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eye-slash-icon-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                <?= error_msg($errors, 'password') ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2" for="password_confirmation">Yeni Şifre (Tekrar)</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] text-sm"
                        placeholder="Şifrenizi tekrar girin" autocomplete="new-password" required>
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg id="eye-icon-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eye-slash-icon-password_confirmation" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                <?= error_msg($errors, 'password_confirmation') ?>
            </div>

            <button type="submit"
                class="w-full py-3 bg-[#00A3B4] hover:bg-[#008899] text-white font-medium rounded-lg transition-colors text-sm">
                Şifremi Güncelle
            </button>

            <div class="text-center">
                <a href="<?= url('giris') ?>" class="text-sm text-[#00A3B4] hover:underline">← Giriş Sayfasına Dön</a>
            </div>
        </form>
    </div>
</div>

<script src="<?= url('assets/js/app.js') ?>"></script>
<script>
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const eyeIcon = document.getElementById('eye-icon-' + fieldId);
    const eyeSlashIcon = document.getElementById('eye-slash-icon-' + fieldId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeSlashIcon.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');
    }
}
</script>
</body>
</html>
