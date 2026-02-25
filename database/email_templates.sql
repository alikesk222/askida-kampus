-- Email template ayarları
INSERT INTO settings (setting_key, setting_value, description) VALUES
('email_donation_subject', 'Bağışınız İçin Teşekkür Ederiz - AYBÜ Askıda Kampüs', 'Bağış teşekkür emailinin konu başlığı'),
('email_donation_greeting', 'Sayın {{donor_name}},', 'Email selamlama metni'),
('email_donation_body', 'Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü olarak, Askıda Kampüs projemize yapmış olduğunuz değerli bağış için en içten teşekkürlerimizi sunarız.

Göstermiş olduğunuz bu duyarlılık ve sosyal sorumluluk bilinci, öğrencilerimizin kampüs yaşamına anlamlı bir katkı sağlamaktadır. Bağışınız, ihtiyaç sahibi öğrencilerimizin kampüs içerisindeki işletmelerden faydalanabilmesine vesile olacaktır.', 'Email ana içerik metni'),
('email_donation_footer_text', 'Bağışınız onaylandıktan sonra, belirlediğiniz ürünler işletme stoğuna eklenecek ve öğrencilerimiz tarafından rezerve edilebilecektir.

Destekleriniz için tekrar teşekkür eder, saygılarımızı sunarız.', 'Email alt bilgi metni'),
('email_donation_signature', 'Ankara Yıldırım Beyazıt Üniversitesi
İktisadi İşletmeler Müdürlüğü
Askıda Kampüs Projesi', 'Email imza')
ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value);
