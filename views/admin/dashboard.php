<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
    <p class="text-gray-500 text-sm mt-1">Sistem genel bakış</p>
</div>

<!-- İstatistik Kartları -->
<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-[#00A3B4]">
        <p class="text-sm text-gray-500">Toplam Kullanıcı</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?= e($stats['total_users']) ?></p>
        <p class="text-xs text-gray-400 mt-1"><?= e($stats['students']) ?> öğrenci · <?= e($stats['donors']) ?> bağışçı</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-indigo-500">
        <p class="text-sm text-gray-500">İşletmeler</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?= e($stats['total_venues']) ?></p>
        <p class="text-xs text-gray-400 mt-1">Aktif kampüs işletmesi</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-400">
        <p class="text-sm text-gray-500">Bekleyen Bağış</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?= e($stats['waiting_donations']) ?></p>
        <p class="text-xs text-gray-400 mt-1">Toplam onaylı: ₺<?= number_format($stats['total_paid'], 2, ',', '.') ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Aktif Rezervasyon</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?= e($stats['active_reservations']) ?></p>
        <p class="text-xs text-gray-400 mt-1"><?= e($stats['claimed_today']) ?> teslim alındı</p>
    </div>
</div>

<!-- Hızlı Erişim -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <a href="<?= url('admin/isletmeler') ?>" class="flex items-center gap-4 bg-white p-5 rounded-lg border border-gray-200 hover:border-[#009999] transition" style="border-left:3px solid #009999;">
        <div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-800 text-sm">İşletmeler</p>
            <p class="text-xs text-gray-400">Ekle, düzenle, ürün yönet</p>
        </div>
    </a>
    <a href="<?= url('admin/bagislar') ?>" class="flex items-center gap-4 bg-white p-5 rounded-lg border border-gray-200 hover:border-[#009999] transition" style="border-left:3px solid #0d1f3c;">
        <div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-800 text-sm">Bağışlar</p>
            <p class="text-xs text-gray-400">Onayla, reddet, listele</p>
        </div>
    </a>
    <a href="<?= url('admin/kullanicilar') ?>" class="flex items-center gap-4 bg-white p-5 rounded-lg border border-gray-200 hover:border-[#009999] transition" style="border-left:3px solid #009999;">
        <div class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-gray-800 text-sm">Kullanıcılar</p>
            <p class="text-xs text-gray-400">Ekle, aktif/pasif yap</p>
        </div>
    </a>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
