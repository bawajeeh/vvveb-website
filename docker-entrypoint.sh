#!/bin/bash
# Startup script for Render - handles PORT environment variable

set -e

# Use PORT environment variable from Render, default to 80
PORT=${PORT:-80}

# Update Apache to listen on the PORT
echo "Listen ${PORT}" > /etc/apache2/ports.conf

# Update virtual host to use PORT
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf || \
sed -i "s/<VirtualHost \*:\${PORT}>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf || true

# Start Apache
exec apache2-foreground

