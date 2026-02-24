<?php include ROOT . '/views/layout/header.php'; ?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Kasa — Teslim Al</h1>
    <p class="text-gray-500 text-sm mt-1"><?= e($venue['name'] ?? '') ?></p>
</div>

<div class="max-w-lg">
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <div class="flex items-center justify-center mb-6">
            <div class="w-16 h-16 bg-[#E0F7FA] rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-[#00A3B4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <h2 class="text-center text-lg font-semibold text-gray-700 mb-6">
            Teslim Kodunu veya QR'ı Girin
        </h2>

        <form method="POST" action="<?= url('kasa/teslim') ?>">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">8 Haneli Teslim Kodu</label>
                <input type="text" name="claim_code" maxlength="8" minlength="8"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl text-center text-2xl font-mono font-bold tracking-[0.4em] uppercase
                           focus:outline-none focus:border-[#00A3B4] transition"
                    placeholder="XXXXXXXX" autofocus autocomplete="off">
                <?= error_msg($errors, 'claim_code') ?>
            </div>
            <button type="submit"
                class="w-full py-3 bg-[#00A3B4] hover:bg-[#007A8A] text-white font-semibold rounded-xl transition text-base">
                Teslim Al
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-gray-400 mt-4">
        Öğrenci QR kodunu göstermişse, kodu kasiyer paneline girin.
    </p>
</div>

<?php include ROOT . '/views/layout/footer.php'; ?>
