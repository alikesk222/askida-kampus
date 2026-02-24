<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> — Askıda Kampüs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

<!-- Header -->
<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-[72px]">
        <a href="<?= url() ?>" class="flex items-center gap-3">
            <img src="<?= asset('aybu.png') ?>" alt="AYBU" class="h-12 w-auto">
            <div class="border-l border-gray-300 pl-3">
                <p class="text-[13px] font-semibold text-gray-800 leading-tight">Ankara Yıldırım Beyazıt Üniversitesi</p>
                <p class="text-[12px] text-gray-500 leading-tight">İktisadi İşletmeler Müdürlüğü</p>
            </div>
        </a>
        <div class="flex items-center gap-3 text-sm">
            <a href="<?= url('giris') ?>" class="text-gray-600 hover:text-[#00A3B4] transition">Giriş Yap</a>
            <a href="<?= url('kayit') ?>" class="px-4 py-1.5 bg-[#00A3B4] text-white rounded-lg hover:bg-[#007A8A] transition">Hesap Oluştur</a>
        </div>
    </div>
</header>

<div class="flex-1 max-w-5xl mx-auto w-full px-4 py-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Bağış Yapılacak İşletme Seçin</h1>
        <p class="text-gray-500 text-sm mt-1">Hesap oluşturmadan bağış yapabilirsiniz. Sadece adınızı ve e-postanızı girmeniz yeterli.</p>
    </div>

    <!-- Hesap avantajı -->
    <div class="bg-[#E0F7FA] border border-[#00A3B4]/30 rounded-xl p-4 flex items-start gap-3 mb-8">
        <span class="text-2xl">💡</span>
        <div>
            <p class="text-sm font-semibold text-[#007A8A]">Hesap açarak bağışlarınızı takip edin</p>
            <p class="text-sm text-gray-600 mt-0.5">Tüm geçmiş bağışlarınızı görmek ve kolayca tekrar bağış yapmak için
                <a href="<?= url('kayit') ?>" class="text-[#00A3B4] font-semibold hover:underline">ücretsiz hesap oluşturun</a>.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($venues as $v): ?>
        <a href="<?= url('misafir-bagis/' . $v['id']) ?>"
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-[#00A3B4]/40 transition group">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-11 h-11 bg-[#E0F7FA] rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-[#00A3B4] transition">
                    <span class="text-[#00A3B4] group-hover:text-white font-bold text-lg transition"><?= mb_substr(e($v['name']), 0, 1) ?></span>
                </div>
                <div>
                    <p class="font-semibold text-gray-800"><?= e($v['name']) ?></p>
                    <p class="text-xs text-gray-400"><?= e($v['campus_name']) ?></p>
                </div>
            </div>
            <?php if ($v['location']): ?>
            <p class="text-xs text-gray-400">📍 <?= e($v['location']) ?></p>
            <?php endif; ?>
            <?php if ($v['opens_at'] && $v['closes_at']): ?>
            <p class="text-xs text-gray-400 mt-1">🕐 <?= e($v['opens_at']) ?> – <?= e($v['closes_at']) ?></p>
            <?php endif; ?>
            <p class="mt-3 text-sm font-semibold text-[#00A3B4] group-hover:text-[#007A8A]">Bu işletmeye bağış yap →</p>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<footer class="bg-[#0d1b3e] text-white/50 text-xs text-center py-4 mt-auto">
    &copy; <?= date('Y') ?> Ankara Yıldırım Beyazıt Üniversitesi — İktisadi İşletmeler Müdürlüğü
</footer>
</body>
</html>
