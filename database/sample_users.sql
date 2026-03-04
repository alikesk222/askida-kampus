-- ============================================================
-- Sample Data: Üniversite adminleri, işletme yöneticileri, öğrenciler
-- Çalıştırmadan önce mevcut kullanıcıları görmek için:
--   SELECT id, name, email, role FROM users;
-- ============================================================
USE askida_kampus;

-- Tüm şifreler: Test1234!
-- Hash: $2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa

-- ── Üniversite Adminleri (her kampüs grubu için bir tane) ──────────────────

INSERT INTO users (name, email, password, role, university_verified, is_active) VALUES
-- Esenboğa / Kızılcahamam / Ovacık kampüsleri
('Mehmet Yıldız',     'mehmet.yildiz@aybu.edu.tr',    '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'university-admin', 1, 1),
-- Bilkent / Doğu / Batı kampüsleri
('Fatma Arslan',      'fatma.arslan@aybu.edu.tr',     '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'university-admin', 1, 1),
-- Cinnah kampüsleri
('Hasan Demir',       'hasan.demir@aybu.edu.tr',      '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'university-admin', 1, 1);

-- ── İşletme Yöneticileri (her işletme için bir tane) ──────────────────────

INSERT INTO users (name, email, password, role, university_verified, is_active) VALUES
-- Külliye A (id=4)
('Zeynep Koç',        'yonetici.kulliyek.a@aybu.edu.tr', '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Külliye B (id=5)
('Mustafa Şahin',     'yonetici.kulliyek.b@aybu.edu.tr', '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Külliye C (id=6)
('Ayşe Erdoğan',      'yonetici.kulliyek.c@aybu.edu.tr', '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Külliye D (id=7)
('İbrahim Çelik',     'yonetici.kulliyek.d@aybu.edu.tr', '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Bilkent Yeni (id=8)
('Elif Aydın',        'yonetici.bilkent.yeni@aybu.edu.tr','$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Bilkent (id=9)
('Serkan Polat',      'yonetici.bilkent@aybu.edu.tr',    '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Doğu (id=10)
('Hülya Yıldırım',    'yonetici.dogu@aybu.edu.tr',       '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Batı Girişi (id=11)
('Burak Kaya',        'yonetici.bati.giris@aybu.edu.tr', '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Batı Bahçe (id=12)
('Selin Güneş',       'yonetici.bati.bahce@aybu.edu.tr', '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Batı Restoran (id=13)
('Cengiz Yılmaz',     'yonetici.bati.rest@aybu.edu.tr',  '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Ovacık (id=14)
('Nurcan Öztürk',     'yonetici.ovacik@aybu.edu.tr',     '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Cinnah 1 (id=15)
('Taner Doğan',       'yonetici.cinnah1@aybu.edu.tr',    '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1),
-- Cinnah 2 (id=16)
('Merve Avcı',        'yonetici.cinnah2@aybu.edu.tr',    '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'venue-admin', 1, 1);

-- ── Örnek Öğrenciler ──────────────────────────────────────────────────────

INSERT INTO users (name, email, password, role, university_verified, daily_limit, student_number, is_active) VALUES
('Ahmet Karahan',   'ahmet.karahan@ogr.aybu.edu.tr',   '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'student', 1, 3, '20210001', 1),
('Buse Demirci',    'buse.demirci@ogr.aybu.edu.tr',    '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'student', 1, 3, '20210002', 1),
('Emre Kılıç',      'emre.kilic@ogr.aybu.edu.tr',      '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'student', 1, 3, '20220001', 1),
('Seda Güler',      'seda.guler@ogr.aybu.edu.tr',      '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'student', 1, 3, '20220002', 1),
('Onur Başaran',    'onur.basaran@ogr.aybu.edu.tr',    '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'student', 1, 3, '20230001', 1),
('Tuğba Yüksel',    'tugba.yuksel@ogr.aybu.edu.tr',    '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'student', 1, 3, '20230002', 1),
('Furkan Ateş',     'furkan.ates@ogr.aybu.edu.tr',     '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'student', 1, 3, '20240001', 1),
('Yasemin Bulut',   'yasemin.bulut@ogr.aybu.edu.tr',   '$2y$10$UQLdaFGYBjXpRynHW5i3k.5nSwGY6VyO.KRKrE3A9lKhQJVrmpOSa', 'student', 1, 3, '20240002', 1);

-- ── İşletme Atamalarını Yap ───────────────────────────────────────────────
-- Kullanıcı ID'leri dinamik olarak alınır

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 4 FROM users u WHERE u.email = 'yonetici.kulliyek.a@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 5 FROM users u WHERE u.email = 'yonetici.kulliyek.b@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 6 FROM users u WHERE u.email = 'yonetici.kulliyek.c@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 7 FROM users u WHERE u.email = 'yonetici.kulliyek.d@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 8 FROM users u WHERE u.email = 'yonetici.bilkent.yeni@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 9 FROM users u WHERE u.email = 'yonetici.bilkent@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 10 FROM users u WHERE u.email = 'yonetici.dogu@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 11 FROM users u WHERE u.email = 'yonetici.bati.giris@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 12 FROM users u WHERE u.email = 'yonetici.bati.bahce@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 13 FROM users u WHERE u.email = 'yonetici.bati.rest@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 14 FROM users u WHERE u.email = 'yonetici.ovacik@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 15 FROM users u WHERE u.email = 'yonetici.cinnah1@aybu.edu.tr';

INSERT INTO venue_user (user_id, venue_id)
SELECT u.id, 16 FROM users u WHERE u.email = 'yonetici.cinnah2@aybu.edu.tr';

-- ── Doğrulama ─────────────────────────────────────────────────────────────
SELECT
    u.name,
    u.email,
    u.role,
    v.name AS atanan_isletme
FROM users u
LEFT JOIN venue_user vu ON vu.user_id = u.id
LEFT JOIN venues v ON v.id = vu.venue_id
WHERE u.role IN ('university-admin', 'venue-admin', 'student')
ORDER BY u.role, u.id;
