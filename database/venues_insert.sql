-- AYBU İktisadi İşletmeler — Gerçek işletmeler
-- Encoding: UTF-8  |  mysql ... --default-character-set=utf8mb4 ile çalıştırın
USE askida_kampus;

INSERT INTO venues (name, campus_name, slug, description, location, opens_at, closes_at, is_active) VALUES
('Külliye A',      'AYBU Külliye Kampüsü',  'kulliye-a',     'Külliye A Kafeterya',      'Külliye A Binası',       '08:00', '20:00', 1),
('Külliye B',      'AYBU Külliye Kampüsü',  'kulliye-b',     'Külliye B Kafeterya',      'Külliye B Binası',       '08:00', '20:00', 1),
('Külliye C',      'AYBU Külliye Kampüsü',  'kulliye-c',     'Külliye C Kafeterya',      'Külliye C Binası',       '08:00', '20:00', 1),
('Külliye D',      'AYBU Külliye Kampüsü',  'kulliye-d',     'Külliye D Kafeterya',      'Külliye D Binası',       '08:00', '20:00', 1),
('Bilkent Yeni',   'AYBU Bilkent Kampüsü',  'bilkent-yeni',  'Bilkent Yeni Kafeterya',   'Bilkent Yeni Bina',      '08:00', '20:00', 1),
('Bilkent',        'AYBU Bilkent Kampüsü',  'bilkent',       'Bilkent Kafeterya',        'Bilkent Bina',           '08:00', '20:00', 1),
('Doğu',           'AYBU Merkez Kampüsü',   'dogu',          'Doğu Kafeterya',           'Doğu Blok',              '08:00', '20:00', 1),
('Batı Giriş',     'AYBU Merkez Kampüsü',   'bati-giris',    'Batı Giriş Kafeterya',     'Batı Giriş Kapısı',      '08:00', '20:00', 1),
('Batı Bahçe',     'AYBU Merkez Kampüsü',   'bati-bahce',    'Batı Bahçe Kafeterya',     'Batı Bahçe Alanı',       '08:00', '20:00', 1),
('Batı Restoran',  'AYBU Merkez Kampüsü',   'bati-restoran', 'Batı Restoran',            'Batı Blok Restoran',     '08:00', '20:00', 1),
('Ovacık',         'AYBU Ovacık Kampüsü',   'ovacik',        'Ovacık Kafeterya',         'Ovacık Yerleşkesi',      '08:00', '20:00', 1),
('Cinnah 1',       'AYBU Cinnah Kampüsü',   'cinnah-1',      'Cinnah 1 Kafeterya',       'Cinnah Cad. No:16',      '08:00', '20:00', 1),
('Cinnah 2',       'AYBU Cinnah Kampüsü',   'cinnah-2',      'Cinnah 2 Kafeterya',       'Cinnah Cad. No:16',      '08:00', '20:00', 1);
