#!/bin/bash
# Complete Render Deployment Automation
# This script guides you through the entire process

clear
echo "=========================================="
echo "🚀 RENDER DEPLOYMENT AUTOMATION"
echo "=========================================="
echo ""
echo "I'll guide you through deploying to Render step by step!"
echo ""

# Step 1: Check if on Render website
echo "STEP 1: Sign Up for Render"
echo "---------------------------"
echo "1. Open: https://render.com"
echo "2. Click 'Get Started for Free'"
echo "3. Sign up with GitHub"
echo ""
read -p "Press ENTER when you're logged into Render dashboard..."

# Step 2: Create Database
echo ""
echo "STEP 2: Create PostgreSQL Database"
echo "------------------------------------"
echo "1. Click 'New +' → 'PostgreSQL'"
echo "2. Name: vvveb-db"
echo "3. Plan: Free"
echo "4. Click 'Create Database'"
echo "5. Wait for status to show 'Available'"
echo ""
read -p "Press ENTER when database is created and shows 'Available'..."

echo ""
echo "Now get your database connection string:"
echo "1. Click on your database name"
echo "2. Find 'Connections' section"
echo "3. Copy the 'Internal Database URL'"
echo ""
read -p "Paste your Internal Database URL here: " DB_CONN_STRING

# Extract database info
if [[ $DB_CONN_STRING =~ postgresql://([^:]+):([^@]+)@([^:]+):([^/]+)/(.+) ]]; then
    DB_USER="${BASH_REMATCH[1]}"
    DB_PASSWORD="${BASH_REMATCH[2]}"
    DB_HOST="${BASH_REMATCH[3]}"
    DB_PORT="${BASH_REMATCH[4]}"
    DB_DATABASE="${BASH_REMATCH[5]}"
    
    echo ""
    echo "✅ Database info extracted!"
    echo ""
    
    # Save to file
    cat > render-env-vars.txt <<EOF
PHP_VERSION=8.1
DB_ENGINE=pgsql
DB_HOST=$DB_HOST
DB_PORT=$DB_PORT
DB_DATABASE=$DB_DATABASE
DB_USER=$DB_USER
DB_PASSWORD=$DB_PASSWORD
EOF
    
    echo "Environment variables saved to: render-env-vars.txt"
    echo ""
    echo "📋 Copy these values:"
    echo "-------------------"
    cat render-env-vars.txt
    echo ""
    
else
    echo "❌ Invalid connection string. Please try again."
    exit 1
fi

# Step 3: Create Web Service
echo ""
echo "STEP 3: Create Web Service"
echo "--------------------------"
echo "1. Click 'New +' → 'Web Service'"
echo "2. Connect repository: bawajeeh/vvveb-website"
echo "3. Configure:"
echo "   - Name: vvveb-website"
echo "   - Runtime: PHP"
echo "   - Build Command: composer install --no-dev --optimize-autoloader"
echo "   - Start Command: php -S 0.0.0.0:\$PORT -t public"
echo "   - Plan: Free"
echo ""
echo "4. Add Persistent Disk:"
echo "   - Name: vvveb-storage"
echo "   - Mount Path: /opt/render/project/src/storage"
echo "   - Size: 1 GB"
echo ""
echo "5. Add Environment Variables (use values above):"
echo "   - PHP_VERSION = 8.1"
echo "   - DB_ENGINE = pgsql"
echo "   - DB_HOST = $DB_HOST"
echo "   - DB_PORT = $DB_PORT"
echo "   - DB_DATABASE = $DB_DATABASE"
echo "   - DB_USER = $DB_USER"
echo "   - DB_PASSWORD = $DB_PASSWORD"
echo ""
read -p "Press ENTER when web service is created and deploying..."

# Step 4: Installation
echo ""
echo "STEP 4: Install Application"
echo "----------------------------"
echo "Wait for deployment to complete (status shows 'Live')"
echo ""
read -p "What's your Render URL? (e.g., https://vvveb-website-xxxx.onrender.com): " RENDER_URL

echo ""
echo "✅ Installation Steps:"
echo "---------------------"
echo "1. Visit: $RENDER_URL/install/"
echo ""
echo "2. Database Configuration:"
echo "   - Engine: PostgreSQL"
echo "   - Host: $DB_HOST"
echo "   - Port: $DB_PORT"
echo "   - Database: $DB_DATABASE"
echo "   - Username: $DB_USER"
echo "   - Password: $DB_PASSWORD"
echo ""
echo "3. Admin Setup:"
echo "   - Enter your email"
echo "   - Choose a password"
echo "   - Complete installation"
echo ""
echo "🎉 Your website will be live at: $RENDER_URL"
echo ""
echo "Admin panel: $RENDER_URL/vadmin"
echo ""

# Save final info
cat > render-deployment-info.txt <<EOF
Website URL: $RENDER_URL
Admin URL: $RENDER_URL/vadmin

Database Info:
Host: $DB_HOST
Port: $DB_PORT
Database: $DB_DATABASE
User: $DB_USER

Installation Database Credentials:
Engine: PostgreSQL
Host: $DB_HOST
Port: $DB_PORT
Database: $DB_DATABASE
Username: $DB_USER
Password: $DB_PASSWORD
EOF

echo "✅ All info saved to: render-deployment-info.txt"
echo ""
echo "=========================================="
echo "DEPLOYMENT READY!"
echo "=========================================="
echo ""
echo "Next: Visit $RENDER_URL/install/ to complete setup"
echo ""

