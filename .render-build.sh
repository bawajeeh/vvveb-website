#!/bin/bash
# Render.com build script
# This runs during deployment build phase

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "Setting up storage directories..."
mkdir -p storage/cache
mkdir -p storage/model
mkdir -p storage/compiled-templates
mkdir -p storage/logs
mkdir -p storage/backup
mkdir -p public/media
mkdir -p public/image-cache
mkdir -p public/page-cache
mkdir -p public/assets-cache

echo "Setting permissions..."
chmod -R 775 storage
chmod -R 775 public/media
chmod -R 775 public/image-cache

echo "Build complete!"

