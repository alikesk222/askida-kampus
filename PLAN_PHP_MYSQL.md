# Askıda Kampüs — Düz PHP + MySQL Yeniden Yazım Planı

> **Ankara Yıldırım Beyazıt Üniversitesi — İktisadi İşletmeler Müdürlüğü**  
> Teknoloji: **Düz PHP 8.2+ · MySQL 8.0 · HTML/CSS (Tailwind CDN)**

---

## İçindekiler
1. [Proje Özeti](#1-proje-özeti)
2. [Kullanıcı Rolleri](#2-kullanıcı-rolleri)
3. [İş Akışları](#3-iş-akışları)
4. [Mimari](#4-mimari)
5. [Klasör Yapısı](#5-klasör-yapısı)
6. [Veritabanı Şeması](#6-veritabanı-şeması)
7. [URL Yapısı](#7-url-yapısı)
8. [Güvenlik](#8-güvenlik)
9. [Sprint Planı](#9-sprint-planı)
10. [Kurulum](#10-kurulum)

---

## 1. Proje Özeti

| Kavram | Açıklama |
|---|---|
| **İşletme (Venue)** | Kafeterya, kantin, büfe gibi kampüs içi satış noktası |
| **Ürün (Product)** | İşletmeye ait ürün (çay, sandviç vb.) |
| **Askıda Stok** | Bağışçıların finanse ettiği, öğrencilerin rezerve edebildiği stok havuzu |
| **Bağış (Donation)** | Bağışçının IBAN ile yaptığı ödeme → admin onayı → stok artar |
| **Rezervasyon** | Öğrencinin stoktan ayırdığı ürün; 8 haneli kod + QR ile teslim alınır |
| **Teslim (Claim)** | Kasiyerin kodu/QR'ı okuyarak rezervasyonu kapatması |

---

## 2. Kullanıcı Rolleri

| Rol | Kısıtlama | Yetkiler |
|---|---|---|
| `super-admin` | — | Her şey |
| `university-admin` | Kullanıcı silme yok | super-admin ile aynı |
| `venue-admin` | Sadece atandığı işletme | Stok görüntüleme, bağış onaylama, rezervasyon görüntüleme |
| `cashier` | Sadece atandığı işletme | QR / kod ile teslim alma |
| `student` | Günlük limit (varsayılan: 3) | İşletme listesi, rezervasyon oluşturma, QR görüntüleme |
| `donor` | — | İşletme listesi, bağış yapma, bağış geçmişi |

> `venue_user` pivot tablosu: `venue-admin` ve `cashier` hangi işletmeye atanmış bunu tutar.

---

## 3. İş Akışları

### Bağış Akışı
```
Bağışçı → İşletme seçer → Ürün + miktar seçer → Tutar hesaplanır
  → IBAN bilgisi gösterilir → "Bağış Yaptım" der
  → donations.status = 'waiting_approval'
  → Admin / VenueAdmin onaylar
  → donations.status = 'paid'
  → suspended_stocks.available_quantity += miktar
```

### Rezervasyon Akışı
```
Öğrenci → İşletme seçer → Ürün + miktar seçer
  → Günlük limit kontrolü (bugün reserved+claimed sayısı >= daily_limit?)
  → Stok kilitlenir (SELECT ... FOR UPDATE)
  → Serbest stok = available_quantity - reserved_quantity >= istek?
  → Rezervasyon oluşturulur: claim_code (8 hane) + qr_token + expires_at (+30 dk)
  → suspended_stocks.reserved_quantity += miktar
  → Öğrenci QR'ı kasiyere gösterir
  → Kasiyer kodu / QR girer → status = 'claimed'
  → reserved_quantity -= miktar, available_quantity -= miktar
```

### Süresi Dolma (Cron — her 5 dk)
```
WHERE status = 'reserved' AND expires_at < NOW()
  → status = 'expired'
  → reserved_quantity geri iade edilir
```

---

## 4. Mimari

```
┌──────────────────────────────────────────────┐
│            public/index.php                  │
│         (Front Controller)                   │
└──────────────────┬───────────────────────────┘
                   │
        ┌──────────▼──────────┐
        │    src/core/        │
        │  Router.php         │  URL → Controller
        │  Auth.php           │  Session kimlik doğrulama
        │  CSRF.php           │  Token üretme/doğrulama
        │  Validator.php      │  Form doğrulama
        │  Database.php       │  PDO singleton
        └──────────┬──────────┘
                   │
      ┌────────────┼────────────┐
      │            │            │
┌─────▼──────┐ ┌──▼──────┐ ┌──▼──────┐
│controllers/│ │services/│ │ models/ │
│ Auth       │ │Donation │ │ User    │
│ Admin      │ │Reservat.│ │ Venue   │
│ VenueAdmin │ │QrService│ │ Stock   │
│ Cashier    │ └─────────┘ │ Donation│
│ Student    │             │ Reserv. │
│ Donor      │             └─────────┘
└─────┬──────┘
      │
┌─────▼──────┐
│  views/    │  Saf HTML + PHP echo, iş mantığı yok
└────────────┘
```

**Katman sorumlulukları:**

| Katman | Sorumluluk |
|---|---|
| `controllers/` | HTTP al → doğrula → servisi çağır → view render et |
| `services/` | İş mantığı + PDO transaction'lar |
| `models/` | Sadece SQL sorguları (prepared statements) |
| `views/` | Saf HTML şablonları |
| `core/` | Router, Auth, CSRF, Validator, DB |

---

## 5. Klasör Yapısı

```
askida_kampus/
│
├── public/                        ← Web root (Apache/Nginx buraya işaret eder)
│   ├── index.php                  ← Front controller: tüm istekler buradan geçer
│   ├── assets/
│   │   ├── css/app.css            ← AYBU renk paleti (#00A3B4 vb.)
│   │   ├── js/app.js
│   │   └── img/
│   │       ├── aybu-logo.png
│   │       └── aybu-logo-white.png
│   └── qrcodes/                   ← Üretilen QR PNG'leri (chmod 775)
│
├── src/
│   ├── bootstrap.php              ← .env yükleme, session başlatma, autoload
│   ├── helpers.php                ← e(), redirect(), flash(), view(), auth()
│   │
│   ├── config/
│   │   ├── database.php           ← MySQL bağlantı sabitleri
│   │   └── app.php                ← APP_NAME, EXPIRE_MINUTES vb.
│   │
│   ├── core/
│   │   ├── Database.php           ← PDO singleton
│   │   ├── Router.php             ← GET/POST URL eşleştirme
│   │   ├── Auth.php               ← login(), logout(), user(), requireRole()
│   │   ├── Validator.php          ← required, email, min, max, numeric
│   │   └── CSRF.php               ← token(), verify()
│   │
│   ├── models/
│   │   ├── UserModel.php
│   │   ├── VenueModel.php
│   │   ├── ProductModel.php
│   │   ├── StockModel.php
│   │   ├── DonationModel.php
│   │   ├── ReservationModel.php
│   │   └── AuditLogModel.php
│   │
│   ├── services/
│   │   ├── DonationService.php    ← create(), approve() — transaction'lı
│   │   ├── ReservationService.php ← create(), claim(), expire() — transaction'lı
│   │   └── QrService.php          ← token üretme, PNG oluşturma
│   │
│   └── controllers/
│       ├── AuthController.php
│       ├── AdminController.php
│       ├── VenueAdminController.php
│       ├── CashierController.php
│       ├── StudentController.php
│       └── DonorController.php
│
├── views/
│   ├── layout/
│   │   ├── header.php             ← AYBU header + role'e göre nav menüsü
│   │   └── footer.php
│   ├── auth/login.php
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── venues/index.php
│   │   ├── venues/create.php
│   │   ├── venues/edit.php
│   │   ├── venues/show.php
│   │   ├── users/index.php
│   │   ├── donations/index.php
│   │   └── reservations/index.php
│   ├── venue_admin/
│   │   ├── dashboard.php
│   │   ├── stock.php
│   │   ├── donations.php
│   │   └── reservations.php
│   ├── cashier/dashboard.php
│   ├── student/
│   │   ├── venues.php
│   │   ├── reserve.php
│   │   ├── reservations.php
│   │   └── qr.php
│   ├── donor/
│   │   ├── venues.php
│   │   ├── donate.php
│   │   └── donations.php
│   └── errors/
│       ├── 403.php
│       └── 404.php
│
├── database/
│   ├── schema.sql                 ← Tüm CREATE TABLE ifadeleri
│   └── seed.sql                   ← Test verileri
│
├── cron/
│   └── expire_reservations.php    ← Cron job: süresi dolan rezervasyonları kapat
│
├── .env
├── .env.example
├── .htaccess                      ← Apache rewrite kuralları
└── PLAN_PHP_MYSQL.md
```

---

## 6. Veritabanı Şeması

```sql
CREATE DATABASE IF NOT EXISTS askida_kampus
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE askida_kampus;

-- KULLANICILAR
CREATE TABLE users (
    id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name                VARCHAR(255) NOT NULL,
    email               VARCHAR(255) NOT NULL UNIQUE,
    password            VARCHAR(255) NOT NULL,          -- password_hash() ile saklanır
    role                ENUM('super-admin','university-admin','venue-admin',
                             'cashier','student','donor') NOT NULL,
    university_verified TINYINT(1) NOT NULL DEFAULT 0,
    daily_limit         TINYINT UNSIGNED NOT NULL DEFAULT 3,
    student_number      VARCHAR(50) NULL UNIQUE,
    phone               VARCHAR(20) NULL,
    is_active           TINYINT(1) NOT NULL DEFAULT 1,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                          ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- İŞLETMELER
CREATE TABLE venues (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    campus_name VARCHAR(255) NOT NULL,
    slug        VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    location    VARCHAR(255) NULL,
    phone       VARCHAR(20) NULL,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    opens_at    TIME NULL,
    closes_at   TIME NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                  ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- KULLANICI ↔ İŞLETME (venue-admin ve cashier ataması için)
CREATE TABLE venue_user (
    user_id  INT UNSIGNED NOT NULL,
    venue_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, venue_id),
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ÜRÜNLER
CREATE TABLE products (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venue_id       INT UNSIGNED NOT NULL,
    name           VARCHAR(255) NOT NULL,
    category       VARCHAR(100) NULL,
    price_snapshot DECIMAL(10,2) NOT NULL,
    description    TEXT NULL,
    is_active      TINYINT(1) NOT NULL DEFAULT 1,
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                     ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE,
    INDEX idx_venue_active (venue_id, is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ASKIDA STOK
-- Serbest stok = available_quantity - reserved_quantity
CREATE TABLE suspended_stocks (
    id                 INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venue_id           INT UNSIGNED NOT NULL,
    product_id         INT UNSIGNED NOT NULL,
    available_quantity INT UNSIGNED NOT NULL DEFAULT 0,
    reserved_quantity  INT UNSIGNED NOT NULL DEFAULT 0,
    updated_at         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                         ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_venue_product (venue_id, product_id),
    FOREIGN KEY (venue_id)   REFERENCES venues(id)   ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- BAĞIŞLAR
CREATE TABLE donations (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    donor_id          INT UNSIGNED NOT NULL,
    venue_id          INT UNSIGNED NOT NULL,
    total_amount      DECIMAL(10,2) NOT NULL,
    payment_method    ENUM('iban','pos') NOT NULL DEFAULT 'iban',
    status            ENUM('waiting_approval','paid','failed')
                        NOT NULL DEFAULT 'waiting_approval',
    payment_reference VARCHAR(255) NULL,
    notes             TEXT NULL,
    approved_by       INT UNSIGNED NULL,
    approved_at       DATETIME NULL,
    created_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                        ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (donor_id)    REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (venue_id)    REFERENCES venues(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id)  ON DELETE SET NULL,
    INDEX idx_status   (status),
    INDEX idx_donor_id (donor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- BAĞIŞ KALEMLERİ
CREATE TABLE donation_items (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    donation_id    INT UNSIGNED NOT NULL,
    product_id     INT UNSIGNED NOT NULL,
    quantity       INT UNSIGNED NOT NULL,
    price_snapshot DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (donation_id) REFERENCES donations(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id)  REFERENCES products(id)  ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- REZERVASYONLAR
CREATE TABLE reservations (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id INT UNSIGNED NOT NULL,
    venue_id   INT UNSIGNED NOT NULL,
    status     ENUM('reserved','claimed','expired','cancelled')
                 NOT NULL DEFAULT 'reserved',
    qr_token   VARCHAR(512) NOT NULL UNIQUE,
    claim_code CHAR(8)      NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    claimed_at DATETIME NULL,
    claimed_by INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                 ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (venue_id)   REFERENCES venues(id) ON DELETE CASCADE,
    FOREIGN KEY (claimed_by) REFERENCES users(id)  ON DELETE SET NULL,
    INDEX idx_student_status (student_id, status),
    INDEX idx_expires_at     (expires_at),
    INDEX idx_claim_code     (claim_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- REZERVASYON KALEMLERİ
CREATE TABLE reservation_items (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT UNSIGNED NOT NULL,
    product_id     INT UNSIGNED NOT NULL,
    quantity       INT UNSIGNED NOT NULL,
    price_snapshot DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id)     REFERENCES products(id)     ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DENETİM KAYITLARI
CREATE TABLE audit_logs (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    INT UNSIGNED NULL,
    action     VARCHAR(100) NOT NULL,
    model_type VARCHAR(100) NULL,
    model_id   INT UNSIGNED NULL,
    old_values JSON NULL,
    new_values JSON NULL,
    ip_address VARCHAR(45) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_action (action),
    INDEX idx_model  (model_type, model_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Tablo İlişkileri (ER Özeti)

```
users
  ├──< donations (donor_id) >──< donation_items >──< products >──< venues
  ├──< reservations (student_id) >──< reservation_items >──< products
  └──< venue_user >──< venues
                              └──< suspended_stocks >──< products
```

---

## 7. URL Yapısı

```
# Kimlik Doğrulama
GET/POST  /giris                              AuthController::login()
POST      /cikis                              AuthController::logout()

# Admin (super-admin | university-admin)
GET       /admin                              AdminController::dashboard()
GET       /admin/isletmeler                   AdminController::venuesList()
GET/POST  /admin/isletmeler/yeni              AdminController::venueCreate()
GET       /admin/isletmeler/{id}              AdminController::venueShow()
GET/POST  /admin/isletmeler/{id}/duzenle      AdminController::venueEdit()
POST      /admin/isletmeler/{id}/urun-ekle    AdminController::productStore()
GET       /admin/bagislar                     AdminController::donationsList()
POST      /admin/bagislar/{id}/onayla         AdminController::donationApprove()
GET       /admin/kullanicilar                 AdminController::usersList()
POST      /admin/kullanicilar/{id}/toggle     AdminController::userToggle()
GET       /admin/rezervasyonlar               AdminController::reservationsList()

# Venue Admin
GET       /isletme                            VenueAdminController::dashboard()
GET       /isletme/stok                       VenueAdminController::stock()
GET       /isletme/bagislar                   VenueAdminController::donations()
POST      /isletme/bagislar/{id}/onayla       VenueAdminController::donationApprove()
GET       /isletme/rezervasyonlar             VenueAdminController::reservations()

# Kasiyer
GET       /kasa                               CashierController::dashboard()
POST      /kasa/teslim                        CashierController::claim()

# Öğrenci
GET       /isletmeler                         StudentController::venues()
GET       /isletmeler/{id}/rezerve            StudentController::reserveForm()
POST      /isletmeler/{id}/rezerve            StudentController::reserveStore()
GET       /rezervasyonlarim                   StudentController::reservations()
GET       /rezervasyonlarim/{id}/qr           StudentController::showQr()

# Bağışçı
GET       /bagis                              DonorController::venues()
GET       /bagis/{id}                         DonorController::donateForm()
POST      /bagis/{id}                         DonorController::donateStore()
GET       /bagislarim                         DonorController::donations()
```

---

## 8. Güvenlik

| Tehdit | Önlem |
|---|---|
| SQL Injection | PDO prepared statements — asla string birleştirme yok |
| XSS | Tüm çıktılarda `htmlspecialchars()` — `e()` helper fonksiyonu |
| CSRF | Her POST formunda gizli token, session ile `hash_equals()` doğrulama |
| Şifre | `password_hash(PASSWORD_BCRYPT, ['cost'=>12])` + `password_verify()` |
| Session fixation | Login sonrası `session_regenerate_id(true)` |
| Yetkisiz erişim | Her controller başında `Auth::requireRole(...)` kontrolü |
| Cookie | `httponly=true`, `samesite=Lax`, `secure=true` (HTTPS ortamında) |

---

## 9. Sprint Planı

### Sprint 1 — Altyapı (2-3 gün)
- [ ] Klasör yapısını oluştur
- [ ] `database/schema.sql` MySQL'e uygula
- [ ] `database/seed.sql` — test kullanıcıları ve işletmeler
- [ ] `.env` + `.env.example`
- [ ] `src/bootstrap.php` — .env yükleme, session, sınıf autoload
- [ ] `src/core/Database.php` — PDO singleton
- [ ] `src/core/Router.php` — GET/POST URL eşleştirme, parametre yakalama
- [ ] `src/core/Auth.php` — session auth, `requireRole()`
- [ ] `src/core/CSRF.php` — token üretme / `hash_equals()` doğrulama
- [ ] `src/helpers.php` — `e()`, `redirect()`, `flash()`, `view()`
- [ ] `public/index.php` — front controller
- [ ] `.htaccess` — Apache rewrite
- [ ] `views/layout/header.php` + `footer.php` — AYBU teması (Tailwind CDN)

### Sprint 2 — Auth + Admin Paneli (2-3 gün)
- [ ] `AuthController` + `views/auth/login.php`
- [ ] `AdminController::dashboard()` + view (istatistik kartları)
- [ ] `AdminController::venuesList/Create/Edit/Show()` + views
- [ ] `AdminController::productStore()` — işletmeye ürün ekleme
- [ ] `AdminController::usersList/Toggle()` + view
- [ ] `AdminController::donationsList()` + view
- [ ] `AdminController::reservationsList()` + view

### Sprint 3 — Bağış Akışı (2 gün)
- [ ] `DonationModel` — CRUD sorguları
- [ ] `DonationService::create()` — transaction: bağış + kalemler oluştur
- [ ] `DonationService::approve()` — transaction: onay + `available_quantity` artır
- [ ] `AdminController::donationApprove()` POST handler
- [ ] `DonorController::venues/donateForm/donateStore/donations()` + views
- [ ] `VenueAdminController::donations/donationApprove()` + view

### Sprint 4 — Rezervasyon Akışı (3 gün)
- [ ] `StockModel` — stok sorguları (`SELECT ... FOR UPDATE` dahil)
- [ ] `ReservationModel` — CRUD sorguları
- [ ] `ReservationService::create()` — transaction: günlük limit, stok kilidi, QR/kod üretimi
- [ ] `ReservationService::claim()` — transaction: stok düşürme, status güncelleme
- [ ] `QrService::generateToken()` + `generatePng()` (Google Chart API veya endroid/qr-code)
- [ ] `StudentController::venues/reserveForm/reserveStore/reservations/showQr()` + views
- [ ] `CashierController::dashboard/claim()` + view
- [ ] `VenueAdminController::dashboard/stock/reservations()` + views

### Sprint 5 — Cron + Audit + Son Rötuşlar (1-2 gün)
- [ ] `cron/expire_reservations.php` — süresi dolan rezervasyonları kapat, stok iade et
- [ ] `AuditLogModel` — kritik aksiyonları kaydet (bağış onay, rezervasyon teslim)
- [ ] Flash mesajları tüm formlarda (başarı / hata)
- [ ] Sayfalama — bağış, rezervasyon, kullanıcı listelerinde
- [ ] 403 / 404 hata sayfaları
- [ ] Form validasyon hata mesajları

### Sprint 6 — Test & Deployment (1-2 gün)
- [ ] Tüm rol akışlarını manuel test et (admin, venue-admin, cashier, student, donor)
- [ ] Güvenlik kontrolleri (CSRF, XSS, SQL injection denemeleri)
- [ ] Apache/Nginx yapılandırması
- [ ] Cron job kurulumu (`*/5 * * * *`)
- [ ] `.env` production değerleri, `APP_ENV=production`

---

## 10. Kurulum

### Gereksinimler
- PHP 8.2+ (`pdo_mysql`, `gd`, `mbstring`, `json`)
- MySQL 8.0+
- Apache (`mod_rewrite`) veya Nginx
- (Opsiyonel) Composer — QR kütüphanesi için

### Adımlar

```bash
# 1. Projeyi kopyala
git clone <repo_url> askida_kampus
cd askida_kampus

# 2. .env oluştur
cp .env.example .env
# DB_HOST, DB_NAME, DB_USER, DB_PASS, APP_SECRET değerlerini doldur

# 3. Veritabanını oluştur ve şemayı uygula
mysql -u root -p < database/schema.sql
mysql -u root -p askida_kampus < database/seed.sql

# 4. QR klasörü izni
chmod 775 public/qrcodes/

# 5. (Opsiyonel) Composer ile QR kütüphanesi
composer require endroid/qr-code

# 6. Cron job ekle
*/5 * * * * php /var/www/askida_kampus/cron/expire_reservations.php
```

### .env Örneği

```ini
APP_NAME="Askıda Kampüs"
APP_ENV=development
APP_SECRET=en_az_32_karakter_rastgele_bir_anahtar_buraya_yazin

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=askida_kampus
DB_USER=askida_user
DB_PASS=sifre_buraya

RESERVATION_EXPIRE_MINUTES=30
IBAN=TR00 0000 0000 0000 0000 0000 00
```

### .htaccess (Apache)

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

### Nginx

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

---

## Test Hesapları (seed.sql'den)

| Rol | E-posta | Şifre |
|---|---|---|
| super-admin | admin@askidakampus.com | Admin@1234! |
| university-admin | universite@askidakampus.com | UniAdmin@1234! |
| venue-admin | admin.merkez@askidakampus.com | VenueAdmin@1234! |
| cashier | kasiyer.merkez@askidakampus.com | Cashier@1234! |
| student | ogrenci@askidakampus.com | Student@1234! |
| donor | bagisci@askidakampus.com | Donor@1234! |
