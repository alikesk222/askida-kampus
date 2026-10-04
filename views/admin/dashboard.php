<?php include ROOT . '/views/layout/header.php'; ?>

<div class="page-header">
    <div>
        <nav class="breadcrumb" aria-label="Sayfa yolu">
            <span>Dashboard</span>
        </nav>
        <h1 class="page-title">Genel Bakış</h1>
        <p class="page-desc">Sistem özeti — <?= date('d.m.Y') ?></p>
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="card card-body">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="stat-label">Toplam Kullanıcı</p>
                <p class="stat-value mt-1"><?= e($stats['total_users']) ?></p>
            </div>
            <span class="icon-chip" aria-hidden="true">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-2"><?= e($stats['students']) ?> öğrenci · <?= e($stats['donors']) ?> katkı sağlayan</p>
    </div>
    <div class="card card-body">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="stat-label">İşletmeler</p>
                <p class="stat-value mt-1"><?= e($stats['total_venues']) ?></p>
            </div>
            <span class="icon-chip" aria-hidden="true">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-2">Aktif kampüs işletmesi</p>
    </div>
    <div class="card card-body">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="stat-label">Bekleyen Katkı</p>
                <p class="stat-value mt-1"><?= e($stats['waiting_donations']) ?></p>
            </div>
            <span class="icon-chip" aria-hidden="true">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-2">Toplam onaylı: ₺<?= number_format($stats['total_paid'], 2, ',', '.') ?></p>
    </div>
    <div class="card card-body">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="stat-label">Aktif Rezervasyon</p>
                <p class="stat-value mt-1"><?= e($stats['active_reservations']) ?></p>
            </div>
            <span class="icon-chip" aria-hidden="true">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-2"><?= e($stats['claimed_today']) ?> teslim alındı</p>
    </div>
</div>

<!-- Hızlı Erişim -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <a href="<?= url('admin/isletmeler') ?>" class="card card-body flex items-center gap-4 hover:shadow-lift transition">
        <span class="icon-chip" aria-hidden="true">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </span>
        <div>
            <p class="font-semibold text-slate-900 text-sm">İşletmeler</p>
            <p class="text-xs text-slate-500">Ekle, düzenle, ürün yönet</p>
        </div>
    </a>
    <a href="<?= url('admin/bagislar') ?>" class="card card-body flex items-center gap-4 hover:shadow-lift transition">
        <span class="icon-chip" aria-hidden="true">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </span>
        <div>
            <p class="font-semibold text-slate-900 text-sm">Katkılar</p>
            <p class="text-xs text-slate-500">Onayla, reddet, listele</p>
        </div>
    </a>
    <a href="<?= url('admin/kullanicilar') ?>" class="card card-body flex items-center gap-4 hover:shadow-lift transition">
        <span class="icon-chip" aria-hidden="true">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </span>
        <div>
            <p class="font-semibold text-slate-900 text-sm">Kullanıcılar</p>
            <p class="text-xs text-slate-500">Ekle, aktif/pasif yap</p>
        </div>
    </a>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
