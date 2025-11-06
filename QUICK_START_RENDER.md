# 🚀 Quick Start: Deploy to Render.com (FREE)

## TL;DR - Fastest Way to Deploy

1. **Push to GitHub**
   ```bash
   git init
   git add .
   git commit -m "Ready for Render"
   git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO.git
   git push -u origin main
   ```

2. **Deploy on Render**
   - Go to https://render.com
   - Sign up with GitHub
   - Click "New +" → "Web Service"
   - Connect your repo
   - Use these settings:
     - **Build Command:** `composer install --no-dev --optimize-autoloader`
     - **Start Command:** `php -S 0.0.0.0:$PORT -t public`
   - Add Persistent Disk: `/opt/render/project/src/storage` (1GB)

3. **Create Database**
   - Click "New +" → "PostgreSQL" (Free plan)
   - Copy connection details

4. **Add Environment Variables** (in Web Service settings):
   ```
   DB_ENGINE=pgsql
   DB_HOST=[from database connection string]
   DB_PORT=5432
   DB_DATABASE=vvveb
   DB_USER=[from database connection string]
   DB_PASSWORD=[from database connection string]
   ```

5. **Install**
   - Visit: `https://your-app.onrender.com/install/`
   - Use PostgreSQL credentials
   - Complete setup

6. **Done!** 🎉

## Full Step-by-Step Guide

👉 **START HERE:** See `STEP_BY_STEP_RENDER.md` for complete step-by-step instructions with screenshots guidance!

For more technical details, see `DEPLOY_RENDER.md`.

## Why Not Vercel?

Vercel doesn't support traditional PHP apps. See `DEPLOY_VERCEL.md` for explanation.

## Files Created for Render:

- ✅ `render.yaml` - Render configuration
- ✅ `.render-build.sh` - Build script
- ✅ `env.render.php` - Production settings template
- ✅ `DEPLOY_RENDER.md` - Complete guide

## Cost: FREE! 🎉

Free plan includes:
- 750 hours/month
- 1GB PostgreSQL database
- Automatic HTTPS
- Persistent storage

Perfect for personal projects!

