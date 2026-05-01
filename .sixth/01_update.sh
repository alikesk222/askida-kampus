#!/bin/bash
set -e
export DEBIAN_FRONTEND=noninteractive
sudo -E apt-get update -y
sudo -E apt-get -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" upgrade -y
sudo -E apt-get -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" dist-upgrade -y
sudo -E apt-get autoremove -y
sudo -E apt-get autoclean -y
sudo timedatectl set-timezone Europe/Istanbul
sudo -E apt-get install -y unattended-upgrades apt-listchanges
sudo dpkg-reconfigure -f noninteractive unattended-upgrades
echo "=== KERNEL ===" && uname -r
echo "=== REBOOT NEEDED? ===" && { [ -f /var/run/reboot-required ] && echo YES || echo NO; }
echo "=== TIMEZONE ===" && timedatectl | grep "Time zone"
echo "=== DATE ===" && date
