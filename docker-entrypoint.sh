#!/bin/sh
set -e

PORT="${PORT:-80}"

# Remove conflicting Apache MPM modules
rm -f /etc/apache2/mods-enabled/mpm_event.load
rm -f /etc/apache2/mods-enabled/mpm_event.conf
rm -f /etc/apache2/mods-enabled/mpm_worker.load
rm -f /etc/apache2/mods-enabled/mpm_worker.conf

# Ensure only prefork is enabled
a2enmod mpm_prefork rewrite

# Create Laravel storage symlink
php artisan storage:link

# Verify storage files and symlink
echo "=== STORAGE LINK ==="
ls -ld public/storage
echo "=== STORAGE CONTENTS ==="
ls -la storage/app/public

# Configure Railway port
sed -i "s|^Listen .*|Listen ${PORT}|" /etc/apache2/ports.conf
sed -i "s|<VirtualHost \*:80>|<VirtualHost *:${PORT}>|" /etc/apache2/sites-available/000-default.conf

echo "=== ACTIVE MPM MODULES ==="
ls -l /etc/apache2/mods-enabled/mpm_*

echo "=== APACHE CONFIG TEST ==="
apache2ctl configtest

exec apache2-foreground