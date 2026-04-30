    <footer style="background:#0d1f3c;color:#cdd8e8;font-family:'Inter','Segoe UI',sans-serif;padding:48px 0 0;">

        <div style="max-width:1200px;margin:0 auto;padding:0 32px 40px;display:grid;grid-template-columns:1fr 1px 1fr 1px 1fr;gap:0;">

            <!-- Marka -->
            <div style="padding-right:40px;display:flex;flex-direction:column;gap:16px;">
                <div style="display:flex;align-items:center;gap:14px;">
                    <img src="<?= asset('aybu.png') ?>" alt="AYBU" style="height:48px;filter:brightness(0) invert(1);opacity:0.9;">
                    <div>
                        <div style="font-size:11px;color:#90a4be;font-weight:500;letter-spacing:0.3px;">ANKARA YILDIRIM BEYAZIT ÜNİVERSİTESİ</div>
                        <div style="font-size:18px;font-weight:700;color:#fff;margin-top:2px;">Askıda Kampüs</div>
                    </div>
                </div>
                <p style="font-size:13px;line-height:1.7;color:#90a4be;">
                    <?= t('footer.brand_desc') ?>
                </p>
                <div style="display:flex;gap:10px;">
                    <a href="<?= url('misafir-bagis') ?>" style="padding:8px 16px;background:#009999;color:#fff;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;"><?= t('nav.donate') ?></a>
                    <a href="<?= url('giris') ?>"          style="padding:8px 16px;background:rgba(255,255,255,0.1);color:#fff;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;border:1px solid rgba(255,255,255,0.15);"><?= t('nav.login') ?></a>
                </div>
            </div>

            <div style="background:rgba(255,255,255,0.1);width:1px;"></div>

            <!-- Hızlı Erişim -->
            <div style="padding:0 40px;">
                <div style="font-size:11px;font-weight:700;color:#00bcd4;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:18px;"><?= t('footer.quick_access') ?></div>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:10px;">
                    <li><a href="<?= url('/') ?>"           style="color:#90a4be;text-decoration:none;font-size:13.5px;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='#90a4be'"><?= t('nav.home') ?></a></li>
                    <li><a href="<?= url('hakkimizda') ?>"  style="color:#90a4be;text-decoration:none;font-size:13.5px;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='#90a4be'"><?= t('nav.about') ?></a></li>
                    <li><a href="<?= url('sss') ?>"         style="color:#90a4be;text-decoration:none;font-size:13.5px;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='#90a4be'"><?= t('nav.faq') ?></a></li>
                    <li><a href="<?= url('iletisim') ?>"    style="color:#90a4be;text-decoration:none;font-size:13.5px;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='#90a4be'"><?= t('nav.contact') ?></a></li>
                    <li><a href="<?= url('misafir-bagis') ?>" style="color:#90a4be;text-decoration:none;font-size:13.5px;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='#90a4be'"><?= t('nav.donate') ?></a></li>
                    <li><a href="<?= url('kayit') ?>"       style="color:#90a4be;text-decoration:none;font-size:13.5px;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='#90a4be'"><?= t('footer.student_reg') ?></a></li>
                </ul>
            </div>

            <div style="background:rgba(255,255,255,0.1);width:1px;"></div>

            <!-- İletişim -->
            <div style="padding-left:40px;">
                <div style="font-size:11px;font-weight:700;color:#00bcd4;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:18px;"><?= t('footer.contact') ?></div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <svg style="width:15px;height:15px;flex-shrink:0;margin-top:1px;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span style="font-size:13px;color:#90a4be;line-height:1.6;">Ankara Yıldırım Beyazıt Üniversitesi<br>Esenboğa Külliyesi, Esenboğa / ANKARA</span>
                    </div>
                    <div style="display:flex;gap:10px;align-items:center;">
                        <svg style="width:15px;height:15px;flex-shrink:0;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:basin@aybu.edu.tr" style="font-size:13px;color:#90a4be;text-decoration:none;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='#90a4be'">basin@aybu.edu.tr</a>
                    </div>
                    <div style="display:flex;gap:10px;align-items:center;">
                        <svg style="width:15px;height:15px;flex-shrink:0;color:#009999;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:+903129061000" style="font-size:13px;color:#90a4be;text-decoration:none;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='#90a4be'">+90 312 906 10 00</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alt bar -->
        <div style="border-top:1px solid rgba(255,255,255,0.08);max-width:1200px;margin:0 auto;padding:16px 32px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
            <span style="font-size:12px;color:rgba(255,255,255,0.35);"><?= t('footer.rights', ['year' => date('Y')]) ?></span>
            <div style="display:flex;gap:20px;">
                <a href="<?= url('iletisim') ?>" style="color:rgba(255,255,255,0.4);font-size:12px;text-decoration:none;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='rgba(255,255,255,0.4)'"><?= t('footer.privacy') ?></a>
                <a href="<?= url('iletisim') ?>" style="color:rgba(255,255,255,0.4);font-size:12px;text-decoration:none;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='rgba(255,255,255,0.4)'"><?= t('footer.kvkk') ?></a>
                <a href="<?= url('iletisim') ?>" style="color:rgba(255,255,255,0.4);font-size:12px;text-decoration:none;" onmouseover="this.style.color='#00bcd4'" onmouseout="this.style.color='rgba(255,255,255,0.4)'"><?= t('footer.accessibility') ?></a>
            </div>
        </div>
    </footer>

</body>
</html>
