#!/bin/bash

# Deployment Script for Vvveb Website Builder
# This script helps prepare your files for deployment to ain90.online

echo "=========================================="
echo "Vvveb Deployment Preparation Script"
echo "=========================================="
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo -e "${YELLOW}Warning: Composer not found. Make sure to install dependencies manually.${NC}"
else
    echo -e "${GREEN}Installing Composer dependencies...${NC}"
    composer install --no-dev --optimize-autoloader
fi

# Set file permissions
echo -e "${GREEN}Setting file permissions...${NC}"
find . -type d -exec chmod 755 {} \; 2>/dev/null
find . -type f -exec chmod 644 {} \; 2>/dev/null

# Set writable permissions for specific directories
echo -e "${GREEN}Setting writable permissions for storage and media directories...${NC}"
chmod -R 775 storage 2>/dev/null
chmod -R 775 public/media 2>/dev/null
chmod -R 775 public/image-cache 2>/dev/null
chmod -R 775 public/page-cache 2>/dev/null
chmod -R 775 public/assets-cache 2>/dev/null

# Clean cache and temporary files
echo -e "${GREEN}Cleaning cache and temporary files...${NC}"
rm -rf storage/compiled-templates/app_* 2>/dev/null
rm -rf storage/compiled-templates/admin_* 2>/dev/null
rm -rf storage/cache/* 2>/dev/null
rm -rf storage/logs/* 2>/dev/null
rm -rf public/page-cache/* 2>/dev/null
rm -rf public/assets-cache/* 2>/dev/null
rm -rf public/image-cache/* 2>/dev/null

# Backup current env.php if it exists
if [ -f "env.php" ]; then
    echo -e "${GREEN}Backing up env.php...${NC}"
    cp env.php env.php.backup
fi

# Copy production env.php template
if [ -f "env.production.php" ]; then
    echo -e "${YELLOW}Production env.php template found.${NC}"
    echo -e "${YELLOW}After deployment, copy env.production.php to env.php and configure it.${NC}"
fi

echo ""
echo -e "${GREEN}=========================================="
echo "Deployment Preparation Complete!"
echo "==========================================${NC}"
echo ""
echo "Next steps:"
echo "1. Upload all files to your web server"
echo "2. Set document root to the 'public' folder"
echo "3. Create a MySQL database"
echo "4. Visit https://ain90.online/install/ to complete installation"
echo "5. After installation, update env.php with production settings"
echo ""
echo "See DEPLOYMENT.md for detailed instructions."

