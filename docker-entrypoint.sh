#!/bin/sh
set -e

PORT="${PORT:-80}"

sed -i "s|^Listen .*|Listen ${PORT}|" /etc/apache2/ports.conf
sed -i "s|<VirtualHost \*:80>|<VirtualHost *:${PORT}>|" /etc/apache2/sites-available/000-default.conf

echo "=== ACTIVE MPM ==="
grep -RniE '^[[:space:]]*LoadModule[[:space:]]+mpm_' /etc/apache2

echo "=== APACHE CONFIG TEST ==="
apache2ctl configtest

exec apache2-foreground