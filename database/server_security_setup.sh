#!/bin/bash
# Sunucu güvenlik sertleştirme scripti
# Çalıştır: sudo bash server_security_setup.sh

set -e

echo "=== 1. SSH Sertleştirme ==="
# Root login'i ve şifre girişini devre dışı bırak
sed -i 's/^PermitRootLogin yes/PermitRootLogin no/' /etc/ssh/sshd_config
sed -i 's/^PasswordAuthentication yes/PasswordAuthentication no/' /etc/ssh/sshd_config
# Yoksa ekle
grep -q "^PermitRootLogin" /etc/ssh/sshd_config || echo "PermitRootLogin no" >> /etc/ssh/sshd_config
grep -q "^PasswordAuthentication" /etc/ssh/sshd_config || echo "PasswordAuthentication no" >> /etc/ssh/sshd_config
systemctl reload sshd
echo "SSH: root login ve parola girişi devre dışı"

echo "=== 2. fail2ban: SSH + Web ==="
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
EOF

echo "=== 3. fail2ban: askida-auth filtresi ==="
cat > /etc/fail2ban/filter.d/askida-auth.conf << 'EOF'
[Definition]
failregex = \[ASKIDA_LOGIN_FAILED\] ip=<HOST>
ignoreregex =
datepattern = {^LN-BEG}
EOF

echo "=== 4. mod_remoteip: Cloudflare gerçek IP ==="
a2enmod remoteip 2>/dev/null || true

cat > /etc/apache2/conf-available/cloudflare-remoteip.conf << 'EOF'
# Cloudflare IP aralıkları - gerçek ziyaretçi IP'si için
RemoteIPHeader CF-Connecting-IP
RemoteIPTrustedProxy 103.21.244.0/22
RemoteIPTrustedProxy 103.22.200.0/22
RemoteIPTrustedProxy 103.31.4.0/22
RemoteIPTrustedProxy 104.16.0.0/13
RemoteIPTrustedProxy 104.24.0.0/14
RemoteIPTrustedProxy 108.162.192.0/18
RemoteIPTrustedProxy 131.0.72.0/22
RemoteIPTrustedProxy 141.101.64.0/18
RemoteIPTrustedProxy 162.158.0.0/15
RemoteIPTrustedProxy 172.64.0.0/13
RemoteIPTrustedProxy 173.245.48.0/20
RemoteIPTrustedProxy 188.114.96.0/20
RemoteIPTrustedProxy 190.93.240.0/20
RemoteIPTrustedProxy 197.234.240.0/22
RemoteIPTrustedProxy 198.41.128.0/17
EOF

a2enconf cloudflare-remoteip
apache2ctl configtest && systemctl reload apache2
echo "Apache: mod_remoteip aktif"

echo "=== 5. fail2ban yeniden başlat ==="
systemctl restart fail2ban
sleep 2
fail2ban-client status

echo "=== TAMAMLANDI ==="
echo "SSH: root ve parola girişi kapalı"
echo "fail2ban: SSH (3 deneme/72sa ban), Web login (10 deneme/24sa ban)"
echo "mod_remoteip: Cloudflare gerçek IP aktif"
