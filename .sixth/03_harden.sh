#!/bin/bash
set -e

# --- needrestart.conf fix ---
sudo sed -i "s/^\$nrconf{restart} = a;/\$nrconf{restart} = 'a';/" /etc/needrestart/needrestart.conf
grep "nrconf{restart}" /etc/needrestart/needrestart.conf

# --- sysctl optimizasyonlari ---
sudo tee /etc/sysctl.d/99-askida.conf > /dev/null <<'EOF'
# Network performance
net.core.somaxconn = 1024
net.ipv4.tcp_max_syn_backlog = 2048
net.ipv4.tcp_fin_timeout = 15
net.ipv4.tcp_keepalive_time = 600
net.ipv4.ip_local_port_range = 1024 65535

# Security
net.ipv4.conf.all.rp_filter = 1
net.ipv4.conf.default.rp_filter = 1
net.ipv4.conf.all.accept_source_route = 0
net.ipv4.conf.default.accept_source_route = 0
net.ipv4.conf.all.send_redirects = 0
net.ipv4.conf.default.send_redirects = 0
net.ipv4.conf.all.accept_redirects = 0
net.ipv4.conf.default.accept_redirects = 0
net.ipv4.icmp_echo_ignore_broadcasts = 1
net.ipv4.tcp_syncookies = 1
net.ipv4.conf.all.log_martians = 1

# Memory
vm.swappiness = 10
vm.vfs_cache_pressure = 50
EOF
sudo sysctl --system >/dev/null

# --- SSH hardening ---
sudo cp /etc/ssh/sshd_config /etc/ssh/sshd_config.bak.$(date +%s)
sudo tee /etc/ssh/sshd_config.d/99-askida-hardening.conf > /dev/null <<'EOF'
# Askida Kampus SSH hardening
PermitRootLogin no
PasswordAuthentication no
PubkeyAuthentication yes
PermitEmptyPasswords no
ChallengeResponseAuthentication no
KbdInteractiveAuthentication no
UsePAM yes
X11Forwarding no
AllowAgentForwarding no
AllowTcpForwarding no
ClientAliveInterval 300
ClientAliveCountMax 2
MaxAuthTries 3
MaxSessions 5
LoginGraceTime 30
Protocol 2
AllowUsers ali alaaddin
EOF

sudo sshd -t && echo "SSH config OK"
sudo systemctl restart ssh

echo "=== SSH STATUS ==="
sudo systemctl is-active ssh
echo "=== EFFECTIVE SSH CONFIG (critical) ==="
sudo sshd -T | grep -E '^(permitrootlogin|passwordauthentication|pubkeyauthentication|allowusers)' | sort

echo "=== UFW ==="
sudo ufw status

echo "=== FAIL2BAN ==="
sudo fail2ban-client status sshd

echo "=== SYSCTL swappiness ==="
cat /proc/sys/vm/swappiness

echo "=== DONE ==="
