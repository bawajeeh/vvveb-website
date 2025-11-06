# Deploy to Render.com (FREE) - Recommended ✅

Render.com is **perfect** for this PHP application! It supports PHP and provides free PostgreSQL databases.

## Why Render is Perfect for This App:
- ✅ Free PHP hosting
- ✅ Free PostgreSQL database (1GB, perfect for this app)
- ✅ Automatic HTTPS/SSL
- ✅ Easy deployment from GitHub
- ✅ Supports Composer dependencies
- ✅ Persistent file storage

## Free Plan Limits:
- 750 hours/month (enough for personal projects)
- Services spin down after 15 min inactivity (wakes up automatically)
- 1GB PostgreSQL database
- Database expires after 30 days (but you can recreate it)

## Step-by-Step Deployment Guide

### Step 1: Prepare Your Repository

1. **Create a GitHub repository** (if you haven't already)
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin https://github.com/yourusername/vvveb-website.git
   git push -u origin main
   ```

### Step 2: Create Render Configuration Files

Create these files in your project root:

#### `render.yaml` (Optional - for easy setup)
```yaml
services:
  - type: web
    name: vvveb-website
    env: php
    buildCommand: composer install --no-dev --optimize-autoloader
    startCommand: php -S 0.0.0.0:$PORT -t public
    envVars:
      - key: PHP_VERSION
        value: 8.1
    disk:
      name: vvveb-storage
      mountPath: /opt/render/project/src/storage
      sizeGB: 1

databases:
  - name: vvveb-db
    databaseName: vvveb
    user: vvveb_user
    plan: free
```

#### `.render-build.sh` (Build script)
```bash
#!/bin/bash
# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# Set permissions
chmod -R 775 storage
chmod -R 775 public/media
chmod -R 775 public/image-cache
```

#### `public/_render.php` (Entry point for Render)
```php
<?php
// Render.com entry point
// This file routes requests to the main index.php

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI'] ?? '/';

require __DIR__ . '/../index.php';
```

### Step 3: Deploy on Render

1. **Sign up at Render.com** (free account)
   - Go to https://render.com
   - Sign up with GitHub

2. **Create a New Web Service**
   - Click "New +" → "Web Service"
   - Connect your GitHub repository
   - Select your repository

3. **Configure Web Service:**
   - **Name:** `vvveb-website` (or any name)
   - **Environment:** `PHP`
   - **Build Command:** `composer install --no-dev --optimize-autoloader`
   - **Start Command:** `php -S 0.0.0.0:$PORT -t public`
   - **Root Directory:** (leave empty - root of repo)

4. **Add Environment Variables:**
   ```
   PHP_VERSION=8.1
   ```

5. **Add Persistent Disk** (for storage):
   - Go to "Disks" tab
   - Add disk:
     - Name: `vvveb-storage`
     - Mount Path: `/opt/render/project/src/storage`
     - Size: 1GB (free)

### Step 4: Create PostgreSQL Database

1. **Create Database:**
   - Click "New +" → "PostgreSQL"
   - Name: `vvveb-db`
   - Plan: **Free**
   - Database: `vvveb`
   - User: `vvveb_user`
   - Note down the connection details!

2. **Get Database Connection String:**
   - After creation, Render provides:
     - Internal Database URL (for Render services)
     - External Database URL (for local access)
   - Format: `postgresql://user:password@host:port/database`

3. **Add Database Environment Variables to Web Service:**
   ```
   DB_ENGINE=pgsql
   DB_HOST=[from connection string - extract hostname]
   DB_PORT=5432
   DB_DATABASE=vvveb
   DB_USER=[from connection string - extract username]
   DB_PASSWORD=[from connection string - extract password]
   ```
   
   **Example:** If connection string is:
   `postgresql://vvveb_user:password123@dpg-xxxxx-a.oregon-postgres.render.com:5432/vvveb`
   
   Then:
   - DB_HOST = `dpg-xxxxx-a.oregon-postgres.render.com`
   - DB_PORT = `5432`
   - DB_DATABASE = `vvveb`
   - DB_USER = `vvveb_user`
   - DB_PASSWORD = `password123`

### Step 5: Update env.php for Render

Create `env.render.php`:
```php
<?php
// Render.com production settings

define('SQL_CHECK', false);
define('PAGE_CACHE', true);
defined('DEBUG') || define('DEBUG', false);
defined('VTPL_DEBUG') || define('VTPL_DEBUG', false);
defined('DISABLE_PLUGIN_ON_ERORR') || define('DISABLE_PLUGIN_ON_ERORR', true);
defined('V_SUBDIR_INSTALL') || define('V_SUBDIR_INSTALL', false);
defined('V_SHARED_SESSION') || define('V_SHARED_SESSION', false);
defined('LOG_SQL_QUERIES') || define('LOG_SQL_QUERIES', false);
defined('REST') || define('REST', false);
defined('GRAPHQL') || define('GRAPHQL', false);
defined('GRAPHQL_CAMELCASE') || define('GRAPHQL_CAMELCASE', true);
defined('STRIP_EXIF') || define('STRIP_EXIF', true);

if (DEBUG) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
} else {
	error_reporting(0);
	ini_set('display_errors', 0);
}
```

### Step 6: Install the Application

1. **Wait for deployment to complete**
   - Render will build and deploy your app
   - You'll get a URL like: `https://vvveb-website.onrender.com`

2. **Run Installation:**
   - Visit: `https://your-app.onrender.com/install/`
   - Database Configuration:
     - **Engine:** PostgreSQL
     - **Host:** [from environment variables]
     - **Port:** 5432
     - **Database:** vvveb
     - **Username:** [from environment variables]
     - **Password:** [from environment variables]
   - Complete admin setup

3. **After Installation:**
   - Copy `env.render.php` to `env.php` (or manually update)
   - Test your site!

### Step 7: Connect Custom Domain (Optional)

1. In Render dashboard → Settings → Custom Domains
2. Add: `ain90.online`
3. Update DNS records as instructed by Render
4. Wait for SSL certificate (automatic)

## Important Notes for Render:

1. **Storage Path:** Use `/opt/render/project/src/storage` for persistent storage
2. **Database:** Use PostgreSQL (not MySQL) - it's free on Render
3. **Cold Starts:** Free services spin down after 15 min - first request may take ~30 seconds
4. **File Uploads:** Store in the persistent disk mount path
5. **Environment Variables:** Set all DB credentials as environment variables

## Troubleshooting:

- **500 Error:** Check Render logs, verify database connection
- **Permission Errors:** Ensure storage folders are writable (775)
- **Database Connection:** Use internal database URL for Render services
- **Slow First Load:** Normal on free plan (cold start)

## Cost: FREE! 🎉

The free plan is perfect for personal projects and small websites!

