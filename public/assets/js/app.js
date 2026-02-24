// Askıda Kampüs — App JS

document.addEventListener('DOMContentLoaded', function () {
    // Flash mesajlarını 4 saniye sonra kapat
    const flashMessages = document.querySelectorAll('[data-flash]');
    flashMessages.forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 500);
        }, 4000);
    });

    // Silme onay diyaloğu
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(el.dataset.confirm || 'Emin misiniz?')) {
                e.preventDefault();
            }
        });
    });

    // Mobil menü toggle
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
