-- Güvenlik düzeltmeleri için şema güncellemesi.
-- Mevcut kurulumda bir kez çalıştırın:
--   mysql -u ... -p askida_kampus < database/migrate_security.sql
--
-- email_verify_token artık 6 haneli kodun kendisini değil SHA-256 özetini tutar.

ALTER TABLE users
    MODIFY email_verify_token VARCHAR(64) NULL;

-- Bekleyen düz metin kodlar özet ile eşleşmez. Kullanıcı yeni kod isteyebilir.
UPDATE users
   SET email_verify_token = NULL,
       email_verify_expires = NULL
 WHERE email_verify_token IS NOT NULL
   AND CHAR_LENGTH(email_verify_token) < 64;
