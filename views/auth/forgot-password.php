<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifremi Unuttum — Askıda Kampüs</title>
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
            <h1 class="text-gray-800 text-lg font-semibold">Şifremi Unuttum</h1>
            <p class="text-gray-500 text-sm mt-2">E-posta adresinize şifre sıfırlama linki göndereceğiz</p>
        </div>

        <?php $flashSuccess = flash('success'); ?>
        <?php if ($flashSuccess): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            <?= e($flashSuccess) ?>
        </div>
        <?php endif; ?>

        <?php $flashError = flash('error'); ?>
        <?php if ($flashError): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            <?= e($flashError) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?= url('sifremi-unuttum') ?>" class="space-y-5">
            <?= csrf_field() ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2" for="email">E-posta Adresi</label>
                <input type="email" id="email" name="email" value="<?= old('email') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-[#00A3B4] text-sm"
                    placeholder="ornek@aybu.edu.tr" autocomplete="email" required>
                <?= error_msg($errors, 'email') ?>
            </div>

            <button type="submit"
                class="w-full py-3 bg-[#00A3B4] hover:bg-[#008899] text-white font-medium rounded-lg transition-colors text-sm">
                Sıfırlama Linki Gönder
            </button>

            <div class="text-center">
                <a href="<?= url('giris') ?>" class="text-sm text-[#00A3B4] hover:underline">← Giriş Sayfasına Dön</a>
            </div>
        </form>
    </div>
</div>

<script src="<?= url('assets/js/app.js') ?>"></script>
</body>
</html>
