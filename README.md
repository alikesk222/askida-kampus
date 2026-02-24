# Askıda Kampüs 🎓☕

**Ankara Yıldırım Beyazıt Üniversitesi — İktisadi İşletmeler Müdürlüğü**

Askıda Kampüs, üniversite kampüsündeki dayanışma ekonomisini dijitalleştiren bir bağış & rezervasyon sistemidir. Bağışçılar ürün bağışlar, öğrenciler QR kod ile teslim alır.

---

## 🌟 Özellikler

- **Misafir bağış** — Hesap açmadan isim + e-posta ile bağış yapılabilir
- **Bağışçı hesabı** — Kayıt olarak geçmiş bağışlar takip edilebilir
- **QR kod ile teslim** — Öğrenci rezervasyon oluşturur, kasiyer QR ile doğrular
- **Rol tabanlı erişim** — 6 farklı rol: süper admin, üniversite admin, işletme admin, kasiyer, öğrenci, bağışçı
- **Çoklu işletme** — Farklı kampüslerdeki kafeterya/kantin/büfe desteği
- **IBAN ödeme akışı** — Bağış onay mekanizması ile stok yönetimi
- **Kurumsal tasarım** — AYBU markası ile uyumlu, mobil duyarlı arayüz

---

## 🏗️ Teknoloji Yığını

| Katman | Teknoloji |
|--------|-----------|
| Backend | PHP 8.2+ (saf MVC, framework yok) |
| Veritabanı | MySQL 8.0+ (PDO) |
| Frontend | Tailwind CSS (CDN) |
| Sunucu | Apache (XAMPP) + mod_rewrite |
| Auth | Session tabanlı, bcrypt şifre |
| Güvenlik | CSRF token, XSS kaçışı, rol kontrolü |

---

## 📁 Proje Yapısı

```
askida/
├── public/               # Web root — sadece burası dışarıya açık
│   ├── index.php         # Front controller
│   ├── .htaccess         # URL rewrite
│   └── assets/           # CSS, JS, görseller
├── src/
│   ├── bootstrap.php     # Uygulama başlatıcı
│   ├── config/           # Uygulama konfigürasyonu
│   ├── core/             # Router, Database, Auth, CSRF, Validator
│   ├── controllers/      # HTTP katmanı
│   ├── models/           # Veritabanı katmanı
│   ├── services/         # İş mantığı
│   └── helpers.php       # url(), asset(), view(), flash()...
├── views/
│   ├── layout/           # header.php, footer.php
│   ├── auth/             # login.php, register.php
│   ├── admin/            # Süper/üniversite admin sayfaları
│   ├── venue/            # İşletme admin sayfaları
│   ├── student/          # Öğrenci sayfaları
│   ├── donor/            # Bağışçı sayfaları (giriş gerekli)
│   ├── guest/            # Misafir bağış sayfaları
│   └── home.php          # Ana sayfa (landing)
├── database/
│   ├── schema.sql        # Veritabanı şeması
│   └── seed.sql          # Örnek veriler
├── cron/
│   └── expire_reservations.php
├── .env.example          # Ortam değişkeni şablonu
└── .gitignore
```

---

## 🚀 Kurulum

### Gereksinimler
- PHP 8.2+
- MySQL 8.0+
- Apache + mod_rewrite (XAMPP önerilir)

### Adımlar

```bash
# 1. Repoyu klonla
git clone https://github.com/alikesk222/askida-kampus.git
cd askida-kampus

# 2. Ortam dosyasını oluştur
cp .env.example .env
# .env dosyasını düzenle (DB bilgileri, APP_URL vb.)

# 3. Veritabanını oluştur
mysql -u root -p < database/schema.sql
mysql -u root -p askida_kampus < database/seed.sql
```

### `.env` Yapılandırması

```ini
APP_NAME="Askıda Kampüs"
APP_ENV=development
APP_SECRET=en_az_32_karakter_rastgele_anahtar
APP_URL=http://localhost/askida/public

DB_HOST=localhost
DB_PORT=3306
DB_NAME=askida_kampus
DB_USER=root
DB_PASS=
```

---

## 👤 Test Kullanıcıları

| Rol | E-posta | Şifre |
|-----|---------|-------|
| Süper Admin | admin@askidakampus.com | Admin@1234! |
| İşletme Admin | isletme@askidakampus.com | Admin@1234! |
| Kasiyer | kasiyer@askidakampus.com | Admin@1234! |
| Öğrenci | ogrenci@askidakampus.com | Admin@1234! |
| Bağışçı | bagisci@askidakampus.com | Admin@1234! |

---

## 🔗 Kullanıcı Akışları

### Bağışçı (Misafir)
```
Ana Sayfa → Bağış Yap → İşletme Seç → Ürün & Miktar Seç → IBAN ile Ödeme
```

### Bağışçı (Hesaplı)
```
Kayıt Ol → Bağış Yap → İşletme Seç → Ürün & Miktar Seç → Bağışlarım
```

### Öğrenci
```
Giriş → İşletmeler → Ürün Seç → Rezervasyon Oluştur → QR Kod → Kasiyere Göster
```

### Admin
```
Giriş → Dashboard → İşletme / Kullanıcı / Bağış Yönetimi → Bağışı Onayla → Stoka Ekle
```

---

## 🔒 Güvenlik

- Tüm formlarda **CSRF token** doğrulaması
- Tüm çıktılarda **XSS kaçışı** (`e()` helper)
- **Rol bazlı erişim kontrolü** — her controller constructor'da `Auth::requireRole()`
- Şifreler **bcrypt** (cost=12) ile hash'lenir
- `.env` dosyası `.gitignore`'da, asla commit edilmez

---

## 📋 Cron Job

Süresi dolan rezervasyonları temizlemek için:

```bash
# Her 5 dakikada bir çalıştır
*/5 * * * * php /path/to/askida/cron/expire_reservations.php
```

---

## 📄 Lisans

Bu proje Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü için geliştirilmiştir.
