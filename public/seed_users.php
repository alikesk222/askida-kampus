<?php
// Bu script bir kez çalıştırılıp silinebilir
require __DIR__ . '/src/bootstrap.php';

use Core\Database;
$db = Database::getInstance();

$hash = password_hash('Test1234!', PASSWORD_BCRYPT, ['cost' => 10]);

$usersToInsert = [
    // Üniversite adminleri
    ['Mehmet Yıldız', 'mehmet.yildiz@aybu.edu.tr', $hash, 'university-admin', 1, 3, null],
    ['Fatma Arslan', 'fatma.arslan@aybu.edu.tr', $hash, 'university-admin', 1, 3, null],
    ['Hasan Demir', 'hasan.demir@aybu.edu.tr', $hash, 'university-admin', 1, 3, null],

    // İşletme yöneticileri (venue_id => 4..16 sırası ile)
    ['Zeynep Koç', 'yonetici.kulliyek.a@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 4
    ['Mustafa Şahin', 'yonetici.kulliyek.b@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 5
    ['Ayşe Erdoğan', 'yonetici.kulliyek.c@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 6
    ['İbrahim Çelik', 'yonetici.kulliyek.d@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 7
    ['Elif Aydın', 'yonetici.bilkent.yeni@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 8
    ['Serkan Polat', 'yonetici.bilkent@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 9
    ['Hülya Yıldırım', 'yonetici.dogu@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 10
    ['Burak Kaya', 'yonetici.bati.giris@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 11
    ['Selin Güneş', 'yonetici.bati.bahce@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 12
    ['Cengiz Yılmaz', 'yonetici.bati.rest@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 13
    ['Nurcan Öztürk', 'yonetici.ovacik@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 14
    ['Taner Doğan', 'yonetici.cinnah1@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 15
    ['Merve Avcı', 'yonetici.cinnah2@aybu.edu.tr', $hash, 'venue-admin', 1, 3, null],  // venue 16

    // Örnek öğrenciler
    ['Ahmet Karahan', 'ahmet.karahan@ogr.aybu.edu.tr', $hash, 'student', 1, 3, '20210001'],
    ['Buse Demirci', 'buse.demirci@ogr.aybu.edu.tr', $hash, 'student', 1, 3, '20210002'],
    ['Emre Kılıç', 'emre.kilic@ogr.aybu.edu.tr', $hash, 'student', 1, 3, '20220001'],
    ['Seda Güler', 'seda.guler@ogr.aybu.edu.tr', $hash, 'student', 1, 3, '20220002'],
    ['Onur Başaran', 'onur.basaran@ogr.aybu.edu.tr', $hash, 'student', 1, 3, '20230001'],
    ['Tuğba Yüksel', 'tugba.yuksel@ogr.aybu.edu.tr', $hash, 'student', 1, 3, '20230002'],
    ['Furkan Ateş', 'furkan.ates@ogr.aybu.edu.tr', $hash, 'student', 1, 3, '20240001'],
    ['Yasemin Bulut', 'yasemin.bulut@ogr.aybu.edu.tr', $hash, 'student', 1, 3, '20240002'],
];

$stmt = $db->prepare(
    'INSERT IGNORE INTO users (name, email, password, role, university_verified, daily_limit, student_number, is_active)
     VALUES (?, ?, ?, ?, ?, ?, ?, 1)'
);

$inserted = 0;
$skipped = 0;
foreach ($usersToInsert as [$name, $email, $pw, $role, $univ, $limit, $stuNo]) {
    $stmt->execute([$name, $email, $pw, $role, $univ, $limit, $stuNo]);
    if ($stmt->rowCount() > 0) {
        $inserted++;
        echo "✓ Eklendi: $email ($role)\n";
    } else {
        $skipped++;
        echo "- Atlandı (zaten var): $email\n";
    }
}

// İşletme yöneticilerini ata (email => venue_id eşleşmesi)
$venueMap = [
    'yonetici.kulliyek.a@aybu.edu.tr' => 4,
    'yonetici.kulliyek.b@aybu.edu.tr' => 5,
    'yonetici.kulliyek.c@aybu.edu.tr' => 6,
    'yonetici.kulliyek.d@aybu.edu.tr' => 7,
    'yonetici.bilkent.yeni@aybu.edu.tr' => 8,
    'yonetici.bilkent@aybu.edu.tr' => 9,
    'yonetici.dogu@aybu.edu.tr' => 10,
    'yonetici.bati.giris@aybu.edu.tr' => 11,
    'yonetici.bati.bahce@aybu.edu.tr' => 12,
    'yonetici.bati.rest@aybu.edu.tr' => 13,
    'yonetici.ovacik@aybu.edu.tr' => 14,
    'yonetici.cinnah1@aybu.edu.tr' => 15,
    'yonetici.cinnah2@aybu.edu.tr' => 16,
];

echo "\n--- İşletme Atamaları ---\n";
foreach ($venueMap as $email => $venueId) {
    $row = $db->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $row->execute([$email]);
    $user = $row->fetch();
    if (!$user) {
        echo "! Kullanıcı bulunamadı: $email\n";
        continue;
    }
    $assign = $db->prepare('INSERT IGNORE INTO venue_user (user_id, venue_id) VALUES (?, ?)');
    $assign->execute([$user['id'], $venueId]);
    echo "✓ Venue $venueId → {$user['id']} ($email)\n";
}

echo "\n--- ÖZET ---\n";
echo "Eklenen: $inserted | Atlanan: $skipped\n";

// Geçici dosyayı temizle
@unlink(__FILE__);
echo "Script silindi.\n";
