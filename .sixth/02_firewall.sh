#!/bin/bash
set -e
export DEBIAN_FRONTEND=noninteractive

# --- UFW ---
sudo -E apt-get install -y ufw
sudo ufw --force reset
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow 22/tcp comment 'SSH'
sudo ufw allow 80/tcp comment 'HTTP'
sudo ufw allow 443/tcp comment 'HTTPS'
sudo ufw --force enable
sudo ufw status verbose

# --- Fail2ban ---
sudo -E apt-get install -y fail2ban

# SSH jail konfigurasyonu
sudo tee /etc/fail2ban/jail.local > /dev/null <<'EOF'
[DEFAULT]
bantime  = 1h
findtime = 10m
maxretry = 5
backend  = systemd

[sshd]
enabled = true
port    = ssh
maxretry = 5
EOF

sudo systemctl enable fail2ban
sudo systemctl restart fail2ban
sleep 2
sudo fail2ban-client status
sudo fail2ban-client status sshd || true

echo "=== DONE ==="
