#!/bin/bash
# Bot koruması - fail2ban scanner filtresi + mod_evasive
set -e

echo "=== 1. mod_evasive kurulumu ==="
DEBIAN_FRONTEND=noninteractive apt-get install -y libapache2-mod-evasive > /dev/null 2>&1

mkdir -p /var/log/mod_evasive
chown www-data:www-data /var/log/mod_evasive

cat > /etc/apache2/mods-available/evasive.conf << 'EOF'
<IfModule mod_evasive24.c>
    DOSHashTableSize    3097
    DOSPageCount        10
    DOSSiteCount        80
    DOSPageInterval     2
    DOSSiteInterval     2
    DOSBlockingPeriod   600
    DOSLogDir           /var/log/mod_evasive
    # Cloudflare IP aralıkları - asla engelleme
    DOSWhitelist        127.0.0.1
    DOSWhitelist        103.21.244.*
    DOSWhitelist        103.22.200.*
    DOSWhitelist        103.31.4.*
    DOSWhitelist        104.16.*
    DOSWhitelist        104.24.*
    DOSWhitelist        108.162.*
    DOSWhitelist        141.101.*
    DOSWhitelist        162.158.*
    DOSWhitelist        172.64.*
    DOSWhitelist        173.245.*
    DOSWhitelist        188.114.*
    DOSWhitelist        190.93.*
    DOSWhitelist        197.234.*
    DOSWhitelist        198.41.*
</IfModule>
EOF

a2enmod evasive > /dev/null 2>&1
echo "mod_evasive aktif"

echo "=== 2. fail2ban: Tarayıcı filtresi ==="
# Bilinen saldırı path'lerini tarayan IP'ler
cat > /etc/fail2ban/filter.d/apache-scanner.conf << 'EOF'
[Definition]
failregex = ^<HOST> .+"(?:GET|POST|HEAD) (?:/wp-admin|/wp-login|/xmlrpc|/phpmy|/pma|/adminer|/.env|/.git|/shell|/c99|/r57|/eval-stdin|/setup\.php|/install\.php|/config\.php|/composer\.phar|/vendor/phpunit|/.well-known/pki-validation/[a-z0-9]{30}|/\.DS_Store|/backup|/dump\.sql|/db\.sql).* HTTP/\d" \d+
ignoreregex =
EOF

# Aynı IP'den 15+ 404 yanıtı = tarayıcı
cat > /etc/fail2ban/filter.d/apache-404.conf << 'EOF'
[Definition]
failregex = ^<HOST> .+" 404
ignoreregex = \.(css|js|png|jpg|jpeg|gif|ico|woff|woff2|svg|webp|map)
EOF

echo "=== 3. fail2ban jail.local güncelleme ==="
cat > /etc/fail2ban/jail.local << 'EOF'
[DEFAULT]
bantime  = 24h
findtime = 10m
maxretry = 5
backend  = systemd
ignoreip = 127.0.0.1/8 ::1

[sshd]
enabled  = true
port     = ssh
maxretry = 3
bantime  = 72h

[askida-auth]
enabled  = true
filter   = askida-auth
logpath  = /var/log/apache2/aybu.askidakampus.com_ssl_error.log
           /var/log/apache2/aybu.askidakampus.com_error.log
maxretry = 10
findtime = 15m
bantime  = 24h
port     = http,https

[apache-badbots]
enabled  = true
filter   = apache-badbots
logpath  = /var/log/apache2/aybu.askidakampus.com_ssl_access.log
maxretry = 2
bantime  = 24h
port     = http,https

[apache-scanner]
enabled  = true
filter   = apache-scanner
logpath  = /var/log/apache2/aybu.askidakampus.com_ssl_access.log
           /var/log/apache2/aybu.askidakampus.com_access.log
maxretry = 3
findtime = 5m
bantime  = 72h
port     = http,https

[apache-404]
enabled  = true
filter   = apache-404
logpath  = /var/log/apache2/aybu.askidakampus.com_ssl_access.log
maxretry = 20
findtime = 5m
bantime  = 24h
port     = http,https
EOF

echo "=== 4. Apache yeniden başlat ==="
apache2ctl configtest && systemctl reload apache2

echo "=== 5. fail2ban yeniden başlat ==="
systemctl restart fail2ban
sleep 2
fail2ban-client status

echo "=== TAMAMLANDI ==="
