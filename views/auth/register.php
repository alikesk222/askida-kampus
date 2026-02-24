<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bağışçı Hesabı Oluştur — Askıda Kampüs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

<!-- Header -->
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

<div class="flex-1 flex items-center justify-center p-6 bg-gradient-to-br from-[#00A3B4]/10 to-[#007A8A]/10">
<div class="w-full max-w-md">

    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-green-500 rounded-2xl shadow-lg mb-3">
            <span class="text-white text-2xl">🤝</span>
        </div>
        <h1 class="text-gray-800 text-xl font-bold">Bağışçı Hesabı Oluştur</h1>
        <p class="text-gray-500 text-sm mt-0.5">Ücretsiz, 30 saniyede tamamlanır</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-8">

        <?php $flashError = flash('error'); ?>
        <?php if ($flashError): ?>
        <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm"><?= e($flashError) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= url('kayit') ?>">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ad Soyad</label>
                <input type="text" name="name" value="<?= e($old['name'] ?? '') ?>"
                    class="w-full px-4 py-2.5 border <?= isset($errors['name']) ? 'border-red-400' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] text-sm"
                    placeholder="Adınız Soyadınız" required autocomplete="name">
                <?= error_msg($errors, 'name') ?>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">E-posta</label>
                <input type="email" name="email" value="<?= e($old['email'] ?? '') ?>"
                    class="w-full px-4 py-2.5 border <?= isset($errors['email']) ? 'border-red-400' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] text-sm"
                    placeholder="ornek@mail.com" required autocomplete="email">
                <?= error_msg($errors, 'email') ?>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Şifre</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2.5 border <?= isset($errors['password']) ? 'border-red-400' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00A3B4] text-sm"
                    placeholder="En az 8 karakter" required autocomplete="new-password">
                <?= error_msg($errors, 'password') ?>
            </div>

            <button type="submit"
                class="w-full py-2.5 bg-[#00A3B4] hover:bg-[#007A8A] text-white font-semibold rounded-lg transition text-sm">
                Hesap Oluştur ve Bağış Yap
            </button>
        </form>

        <p class="text-center text-gray-500 text-sm mt-5">
            Zaten hesabınız var mı?
            <a href="<?= url('giris') ?>" class="text-[#00A3B4] font-semibold hover:underline">Giriş Yap</a>
        </p>
        <p class="text-center text-gray-400 text-xs mt-3">
            Hesap açmak istemiyorsanız
            <a href="<?= url('misafir-bagis') ?>" class="text-gray-500 hover:underline">misafir olarak bağış yapın</a>.
        </p>
    </div>

    <p class="text-center text-gray-400 text-xs mt-6">
        &copy; <?= date('Y') ?> AYBU — Askıda Kampüs Sistemi
    </p>
</div>
</div>

<script src="<?= url('assets/js/app.js') ?>"></script>
</body>
</html>
