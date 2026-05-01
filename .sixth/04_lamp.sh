#!/bin/bash
set -e
export DEBIAN_FRONTEND=noninteractive

echo "======================================"
echo "  LAMP STACK KURULUMU"
echo "======================================"

# --- Apache ---
echo ">>> Apache2 kuruluyor..."
sudo -E apt-get update -y
sudo -E apt-get install -y apache2 apache2-utils

sudo a2enmod rewrite headers ssl http2 expires deflate
sudo systemctl enable apache2
sudo systemctl restart apache2

# --- PHP 8.2 (ondrej/php PPA) ---
echo ">>> PHP 8.2 PPA ekleniyor..."
sudo -E apt-get install -y software-properties-common ca-certificates lsb-release apt-transport-https gnupg
sudo add-apt-repository -y ppa:ondrej/php
sudo -E apt-get update -y

echo ">>> PHP 8.2 ve eklentileri kuruluyor..."
sudo -E apt-get install -y \
  php8.2 libapache2-mod-php8.2 \
  php8.2-cli php8.2-common php8.2-curl php8.2-mbstring \
  php8.2-xml php8.2-zip php8.2-gd php8.2-mysql php8.2-intl \
  php8.2-bcmath php8.2-opcache php8.2-readline

# PHP 8.2'yi varsayilan yap
sudo update-alternatives --set php /usr/bin/php8.2 || true

# Apache icin PHP 8.2'yi aktive et (baska PHP sürümleri varsa disable et)
for v in 7.4 8.0 8.1 8.3; do
  sudo a2dismod "php$v" 2>/dev/null || true
done
sudo a2enmod php8.2
sudo systemctl restart apache2

# --- PHP ayarlari (production) ---
echo ">>> PHP üretim ayarlari..."
PHP_INI="/etc/php/8.2/apache2/php.ini"
sudo sed -i 's/^memory_limit = .*/memory_limit = 256M/' $PHP_INI
sudo sed -i 's/^upload_max_filesize = .*/upload_max_filesize = 32M/' $PHP_INI
sudo sed -i 's/^post_max_size = .*/post_max_size = 32M/' $PHP_INI
sudo sed -i 's/^max_execution_time = .*/max_execution_time = 60/' $PHP_INI
sudo sed -i 's/^expose_php = .*/expose_php = Off/' $PHP_INI
sudo sed -i 's/^;date.timezone =.*/date.timezone = Europe\/Istanbul/' $PHP_INI
sudo sed -i 's/^display_errors = .*/display_errors = Off/' $PHP_INI
sudo sed -i 's/^;opcache.enable=.*/opcache.enable=1/' $PHP_INI
sudo sed -i 's/^;opcache.memory_consumption=.*/opcache.memory_consumption=128/' $PHP_INI

# --- MySQL 8 ---
echo ">>> MySQL Server kuruluyor..."
sudo -E apt-get install -y mysql-server

sudo systemctl enable mysql
sudo systemctl restart mysql

# --- Composer ---
echo ">>> Composer kuruluyor..."
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# --- Certbot (SSL icin, sonra calistirilacak) ---
echo ">>> Certbot kuruluyor..."
sudo -E apt-get install -y certbot python3-certbot-apache

echo ""
echo "======================================"
echo "  KURULUM DURUMU"
echo "======================================"
echo "--- Apache ---"
apache2 -v
sudo systemctl is-active apache2
echo "--- PHP ---"
php -v | head -1
echo "--- MySQL ---"
mysql --version
sudo systemctl is-active mysql
echo "--- Composer ---"
composer --version
echo "--- Certbot ---"
certbot --version

echo ""
echo "KURULUM TAMAMLANDI"
