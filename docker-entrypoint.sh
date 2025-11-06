#!/bin/bash
# Startup script for Render - handles PORT environment variable

set -e

# Use PORT environment variable from Render, default to 80
PORT=${PORT:-80}

# Ensure required directories exist and have correct permissions
mkdir -p storage/cache storage/logs storage/compiled-templates storage/model storage/backup
mkdir -p public/media public/image-cache public/page-cache public/assets-cache
mkdir -p public/themes
mkdir -p config
touch config/sites.php 2>/dev/null || true

# Set ownership to www-data (Apache user) - only if we have permission
chown -R www-data:www-data /var/www/html 2>/dev/null || true

# Set directory permissions
chmod -R 755 /var/www/html 2>/dev/null || true
chmod -R 775 storage config public/media public/themes public/image-cache plugins 2>/dev/null || true
chmod 664 config/sites.php 2>/dev/null || true

# Verify PHP extensions are loaded (for debugging)
php -m | grep -E "(mysqli|mysqlnd|xml|libxml|pcre|zip|dom|curl|gettext)" > /dev/null || echo "Warning: Some PHP extensions may be missing"

# Update Apache to listen on the PORT
echo "Listen ${PORT}" > /etc/apache2/ports.conf

# Update virtual host to use PORT
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf || \
sed -i "s/<VirtualHost \*:\${PORT}>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf || true

# Start Apache
exec apache2-foreground

