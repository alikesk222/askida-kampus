<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap — Askıda Kampüs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

<!-- Kurumsal Header -->
<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 flex items-center h-[72px]">
        <a href="<?= url() ?>" class="flex items-center gap-3">
            <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-12 w-auto">
            <div class="border-l border-gray-300 pl-3">
                <p class="text-[13px] font-semibold text-gray-800 leading-tight">Ankara Yıldırım Beyazıt Üniversitesi</p>
                <p class="text-[12px] text-gray-500 leading-tight">İktisadi İşletmeler Müdürlüğü</p>
            </div>
        </a>
    </div>
</header>

<!-- İçerik -->
<div class="flex-1 flex items-center justify-center p-6 bg-gradient-to-br from-[#00A3B4]/10 to-[#007A8A]/10">
<div class="w-full max-w-md">
    <!-- Başlık -->
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-[#00A3B4] rounded-2xl shadow-lg mb-3">
            <span class="text-white font-bold text-xl">A</span>
        </div>
        <h1 class="text-gray-800 text-xl font-bold">Askıda Kampüs</h1>
        <p class="text-gray-500 text-sm mt-0.5">Sisteme giriş yapın</p>
    </div>

    <!-- Kart -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-gray-800 text-xl font-semibold mb-6">Hesabınıza Giriş Yapın</h2>

        <?php $flashError = flash('error'); ?>
        <?php if ($flashError): ?>
        <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm">
            <?= e($flashError) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?= url('giris') ?>">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="email">E-posta</label>
                <input type="email" id="email" name="email" value="<?= old('email') ?>"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-transparent text-sm"
                    placeholder="ornek@mail.com" autocomplete="email" required>
                <?= error_msg($errors, 'email') ?>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Şifre</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] focus:border-transparent text-sm"
                    placeholder="••••••••" autocomplete="current-password" required>
                <?= error_msg($errors, 'password') ?>
            </div>

            <button type="submit"
                class="w-full py-2.5 bg-[#00A3B4] hover:bg-[#007A8A] text-white font-semibold rounded-lg transition text-sm">
                Giriş Yap
            </button>
        </form>
    </div>

    <p class="text-center text-gray-400 text-xs mt-6">
        &copy; <?= date('Y') ?> AYBU — Askıda Kampüs Sistemi
    </p>
</div>
</div>

<script src="<?= url('assets/js/app.js') ?>"></script>
</body>
</html>
