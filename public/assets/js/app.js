// Askıda Kampüs — App JS (tüm sayfalarda ortak; sayfaya özel kod view içinde kalır)

document.addEventListener('DOMContentLoaded', function () {

    // ── Flash mesajları: 5 sn sonra kapanır (tek yer). data-flash="sticky" kapanmaz.
    document.querySelectorAll('[data-flash]').forEach(function (el) {
        var dismiss = function () {
            el.style.transition = 'opacity .4s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 400);
        };
        var closeBtn = el.querySelector('[data-flash-close]');
        if (closeBtn) closeBtn.addEventListener('click', dismiss);
        if (el.dataset.flash !== 'sticky') setTimeout(dismiss, 5000);
    });

    // ── Silme / onay diyaloğu
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(el.dataset.confirm || 'Emin misiniz?')) {
                e.preventDefault();
            }
        });
    });

    // ── Mobil menü toggle (public header)
    var menuBtn = document.getElementById('mobile-menu-btn');
    var mobileMenu = document.getElementById('mobile-menu');
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function () {
            var open = mobileMenu.classList.toggle('hidden') === false;
            menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    // ── Panoya kopyala
    //   <button type="button" data-copy="TR00 ..." data-copied-text="Kopyalandı">
    //       <span data-copy-label>Kopyala</span></button>
    //   veya data-copy-target="#iban" (hedef elemanın textContent / value'su kopyalanır)
    document.querySelectorAll('[data-copy], [data-copy-target]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var text = btn.dataset.copy;
            if (!text && btn.dataset.copyTarget) {
                var target = document.querySelector(btn.dataset.copyTarget);
                if (target) text = ('value' in target && target.value) ? target.value : target.textContent;
            }
            text = (text || '').trim();
            if (!text) return;

            var done = function () {
                var label = btn.querySelector('[data-copy-label]') || btn;
                if (!btn.dataset.copyOriginal) btn.dataset.copyOriginal = label.textContent;
                label.textContent = btn.dataset.copiedText || 'Kopyalandı';
                btn.classList.add('is-copied');
                clearTimeout(btn._copyTimer);
                btn._copyTimer = setTimeout(function () {
                    label.textContent = btn.dataset.copyOriginal;
                    btn.classList.remove('is-copied');
                }, 2000);
            };
            var fallback = function () {
                var ta = document.createElement('textarea');
                ta.value = text;
                ta.setAttribute('readonly', '');
                ta.style.position = 'fixed';
                ta.style.opacity = '0';
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); done(); } catch (e) { /* yoksay */ }
                ta.remove();
            };
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(done, fallback);
            } else {
                fallback();
            }
        });
    });

    // ── Geri sayım
    //   <div data-countdown data-countdown-end="UNIX_SN" [data-countdown-start="UNIX_SN"]
    //        [data-countdown-now="SUNUCU_UNIX_SN"] [data-countdown-expired-text="Süresi doldu"]>
    //       <span data-countdown-text></span>
    //       <div class="progress"><div class="progress-bar" data-countdown-bar></div></div>
    //       <p data-countdown-show-when-expired class="hidden">...</p>
    //       <div data-countdown-hide-when-expired>...</div>
    //   </div>
    //   Bitince: kapsayıcıya .is-expired eklenir ve 'countdown:expired' olayı tetiklenir.
    document.querySelectorAll('[data-countdown]').forEach(function (box) {
        var end = parseInt(box.dataset.countdownEnd, 10);
        if (!end) return;
        var start = parseInt(box.dataset.countdownStart, 10) || null;
        var serverNow = parseInt(box.dataset.countdownNow, 10);
        var skew = serverNow ? (serverNow * 1000 - Date.now()) : 0;
        var textEl = box.querySelector('[data-countdown-text]');
        var barEl = box.querySelector('[data-countdown-bar]');
        var pad = function (n) { return (n < 10 ? '0' : '') + n; };
        var timer = null;

        var tick = function () {
            var now = (Date.now() + skew) / 1000;
            var left = Math.max(0, Math.round(end - now));
            if (textEl) {
                var h = Math.floor(left / 3600), m = Math.floor((left % 3600) / 60), s = left % 60;
                textEl.textContent = left > 0
                    ? (h > 0 ? h + ':' + pad(m) + ':' + pad(s) : pad(m) + ':' + pad(s))
                    : (box.dataset.countdownExpiredText || '00:00');
            }
            if (barEl && start && end > start) {
                var pct = Math.max(0, Math.min(100, (left / (end - start)) * 100));
                barEl.style.width = pct + '%';
            }
            if (left <= 0) {
                if (timer) clearInterval(timer);
                if (!box.classList.contains('is-expired')) {
                    box.classList.add('is-expired');
                    box.querySelectorAll('[data-countdown-show-when-expired]').forEach(function (el) { el.classList.remove('hidden'); });
                    box.querySelectorAll('[data-countdown-hide-when-expired]').forEach(function (el) { el.classList.add('hidden'); });
                    box.dispatchEvent(new CustomEvent('countdown:expired', { bubbles: true }));
                }
            }
        };
        tick();
        timer = setInterval(tick, 1000);
    });
});
