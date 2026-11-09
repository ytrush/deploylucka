
#!/bin/sh
set -e

PORT="${PORT:-80}"

# Configure Apache listening port
sed -i "s|^Listen .*|Listen ${PORT}|" /etc/apache2/ports.conf

# Configure VirtualHost port
sed -i "s|<VirtualHost \*:80>|<VirtualHost *:${PORT}>|" \
    /etc/apache2/sites-available/000-default.conf

# Check Apache configuration
echo "=== CHECK ACTIVE MPM ==="
apache2ctl -M | grep mpm

echo "=== CHECK APACHE CONFIGURATION ==="
apache2ctl configtest

echo "=== START APACHE ON PORT ${PORT} ==="
exec apache2-foreground
