#!/bin/bash
set -e
DOMAIN="aybu.askidakampus.com"
WEBROOT="/var/www/$DOMAIN"

echo ">>> Web root: $WEBROOT"
sudo mkdir -p "$WEBROOT"
sudo chown -R ali:www-data "$WEBROOT"
sudo chmod -R 755 "$WEBROOT"

# Park sayfasi /tmp/park_index.html dan kopyalanacak
if [ -f /tmp/park_index.html ]; then
  sudo cp /tmp/park_index.html "$WEBROOT/index.html"
  sudo chown ali:www-data "$WEBROOT/index.html"
fi

# Default Apache sayfasini kaldir
sudo a2dissite 000-default.conf 2>/dev/null || true

# Vhost olustur
sudo tee /etc/apache2/sites-available/${DOMAIN}.conf > /dev/null <<EOF
<VirtualHost *:80>
    ServerName $DOMAIN
    ServerAdmin webmaster@askidakampus.com
    DocumentRoot $WEBROOT

    <Directory $WEBROOT>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Gizli / duyarli dosyalari engelle
    <FilesMatch "^\.(env|git|htaccess)">
        Require all denied
    </FilesMatch>

    # Guvenlik basliklari
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Permissions-Policy "geolocation=(), microphone=(), camera=()"

    # Gzip/deflate
    <IfModule mod_deflate.c>
        AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json application/xml image/svg+xml
    </IfModule>

    # Cache statik icerik
    <IfModule mod_expires.c>
        ExpiresActive On
        ExpiresByType text/css "access plus 7 days"
        ExpiresByType application/javascript "access plus 7 days"
        ExpiresByType image/png "access plus 30 days"
        ExpiresByType image/jpeg "access plus 30 days"
        ExpiresByType image/svg+xml "access plus 30 days"
        ExpiresByType image/webp "access plus 30 days"
        ExpiresByType font/woff2 "access plus 1 year"
    </IfModule>

    ErrorLog \${APACHE_LOG_DIR}/${DOMAIN}_error.log
    CustomLog \${APACHE_LOG_DIR}/${DOMAIN}_access.log combined
</VirtualHost>
EOF

# Apache'nin hostname uyarisini susturmak icin
echo "ServerName localhost" | sudo tee /etc/apache2/conf-available/servername.conf > /dev/null
sudo a2enconf servername

sudo a2ensite "${DOMAIN}.conf"
sudo apache2ctl configtest
sudo systemctl reload apache2

echo ""
echo "=== ENABLED SITES ==="
sudo apache2ctl -S 2>&1 | grep -E "(VirtualHost|namevhost)"

echo ""
echo "=== LOCAL CURL TEST ==="
curl -sI -H "Host: $DOMAIN" http://127.0.0.1/ | head -5

echo ""
echo "VHOST KURULUM TAMAM"
