#!/bin/bash
set -e

MYSQL_ROOT_PW="$1"
APP_DB_PW="$2"

if [ -z "$MYSQL_ROOT_PW" ] || [ -z "$APP_DB_PW" ]; then
  echo "Usage: $0 <root_pw> <app_pw>"; exit 1
fi

echo ">>> MySQL root parolasi ayarlaniyor ve hardening..."

# Ubuntu 22.04'te MySQL 8 auth_socket ile kurulu. root icin parolali caching_sha2_password'a geciyoruz.
sudo mysql <<SQL
ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY '$MYSQL_ROOT_PW';
DELETE FROM mysql.user WHERE User='';
DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');
DROP DATABASE IF EXISTS test;
DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';
FLUSH PRIVILEGES;
SQL

echo ">>> ~/.my.cnf olusturuluyor (ali icin)..."
cat > ~/.my.cnf <<EOF
[client]
user=root
password=$MYSQL_ROOT_PW
EOF
chmod 600 ~/.my.cnf

echo ">>> askida_kampus veritabani ve uygulama kullanicisi..."
mysql <<SQL
CREATE DATABASE IF NOT EXISTS askida_kampus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'askida'@'localhost' IDENTIFIED WITH caching_sha2_password BY '$APP_DB_PW';
GRANT ALL PRIVILEGES ON askida_kampus.* TO 'askida'@'localhost';
FLUSH PRIVILEGES;
SQL

# Bind-address sadece localhost olsun (MySQL disaridan erisim kapali)
sudo sed -i 's/^bind-address.*/bind-address = 127.0.0.1/' /etc/mysql/mysql.conf.d/mysqld.cnf
sudo systemctl restart mysql

echo ""
echo "=== DOGRULAMA ==="
mysql -e "SHOW DATABASES;"
mysql -e "SELECT user, host, plugin FROM mysql.user;"
sudo ss -tlnp | grep mysql || true

echo ""
echo "MYSQL KURULUM TAMAM"
