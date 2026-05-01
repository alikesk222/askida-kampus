#!/bin/bash
set -e
DOMAIN="aybu.askidakampus.com"
WEBROOT="/var/www/$DOMAIN"
SSL_DIR="/etc/ssl/askida"

echo ">>> Self-signed sertifika uretiliyor ($DOMAIN)..."
sudo mkdir -p "$SSL_DIR"
sudo openssl req -x509 -nodes -newkey rsa:2048 \
  -keyout "$SSL_DIR/$DOMAIN.key" \
  -out    "$SSL_DIR/$DOMAIN.crt" \
  -days 3650 \
  -subj "/C=TR/ST=Ankara/L=Ankara/O=Askida Kampus/CN=$DOMAIN" \
  -addext "subjectAltName=DNS:$DOMAIN"

sudo chmod 600 "$SSL_DIR/$DOMAIN.key"
sudo chmod 644 "$SSL_DIR/$DOMAIN.crt"

echo ">>> Apache SSL vhost (443) olusturuluyor..."
sudo tee /etc/apache2/sites-available/${DOMAIN}-ssl.conf > /dev/null <<EOF
<IfModule mod_ssl.c>
<VirtualHost *:443>
    ServerName $DOMAIN
    ServerAdmin webmaster@askidakampus.com
    DocumentRoot $WEBROOT

    SSLEngine on
    SSLCertificateFile      $SSL_DIR/$DOMAIN.crt
    SSLCertificateKeyFile   $SSL_DIR/$DOMAIN.key

    # Modern TLS
    SSLProtocol             all -SSLv3 -TLSv1 -TLSv1.1
    SSLCipherSuite          ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384
    SSLHonorCipherOrder     off
    SSLSessionTickets       off

    <Directory $WEBROOT>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch "^\.(env|git|htaccess)">
        Require all denied
    </FilesMatch>

    # Real IP'i Cloudflare header'indan cek
    RemoteIPHeader CF-Connecting-IP
    RemoteIPTrustedProxy 173.245.48.0/20
    RemoteIPTrustedProxy 103.21.244.0/22
    RemoteIPTrustedProxy 103.22.200.0/22
    RemoteIPTrustedProxy 103.31.4.0/22
    RemoteIPTrustedProxy 141.101.64.0/18
    RemoteIPTrustedProxy 108.162.192.0/18
    RemoteIPTrustedProxy 190.93.240.0/20
    RemoteIPTrustedProxy 188.114.96.0/20
    RemoteIPTrustedProxy 197.234.240.0/22
    RemoteIPTrustedProxy 198.41.128.0/17
    RemoteIPTrustedProxy 162.158.0.0/15
    RemoteIPTrustedProxy 104.16.0.0/13
    RemoteIPTrustedProxy 104.24.0.0/14
    RemoteIPTrustedProxy 172.64.0.0/13
    RemoteIPTrustedProxy 131.0.72.0/22

    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Permissions-Policy "geolocation=(), microphone=(), camera=()"

    <IfModule mod_deflate.c>
        AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json application/xml image/svg+xml
    </IfModule>

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

    ErrorLog \${APACHE_LOG_DIR}/${DOMAIN}_ssl_error.log
    CustomLog \${APACHE_LOG_DIR}/${DOMAIN}_ssl_access.log combined
</VirtualHost>
</IfModule>
EOF

sudo a2enmod ssl remoteip
sudo a2ensite "${DOMAIN}-ssl.conf"
sudo apache2ctl configtest
sudo systemctl reload apache2

echo ""
echo "=== LOCAL HTTPS TEST (self-signed oldugu icin -k) ==="
curl -skI -H "Host: $DOMAIN" https://127.0.0.1/ | head -5

echo ""
echo "=== 443 dinleniyor mu? ==="
sudo ss -tlnp | grep ':443' || echo "443 dinlenmiyor!"

echo ""
echo "SSL KURULUM TAMAM"
