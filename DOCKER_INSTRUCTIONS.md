# 🐳 Deploy Using Docker on Render

**Render doesn't have native PHP support - use Docker instead!**

## ✅ Solution: Select "Docker" Runtime

When creating your Web Service on Render:

1. **Runtime:** Select **"Docker"** (not PHP - it's not available!)
2. **Dockerfile:** Already created! Render will auto-detect it
3. **Build Command:** Leave empty (Docker handles it)
4. **Start Command:** Leave empty (Docker handles it)

---

## 📋 Complete Setup Steps:

### 1. Create Web Service
- Click "New +" → "Web Service"
- Connect repository: `bawajeeh/vvveb-website`
- **Runtime:** Select **"Docker"** ⭐

### 2. Configure Settings
- **Name:** `vvveb-website`
- **Region:** Choose closest
- **Branch:** `main`
- **Root Directory:** Leave empty
- **Dockerfile Path:** Leave empty (auto-detects)
- **Build Command:** Leave empty
- **Start Command:** Leave empty
- **Plan:** Free

### 3. Add Persistent Disk
- **Name:** `vvveb-storage`
- **Mount Path:** `/var/www/html/storage`
- **Size:** `1 GB`

### 4. Add Environment Variables
- `PHP_VERSION` = `8.1`
- `DB_ENGINE` = `pgsql`
- `DB_HOST` = `[from database]`
- `DB_PORT` = `5432`
- `DB_DATABASE` = `vvveb`
- `DB_USER` = `[from database]`
- `DB_PASSWORD` = `[from database]`

### 5. Create Web Service
- Click "Create Web Service"
- Wait 5-10 minutes for Docker build

---

## 🎯 What the Dockerfile Does:

✅ Uses PHP 8.1 with Apache
✅ Installs all required PHP extensions (MySQL, PostgreSQL, GD, etc.)
✅ Installs Composer
✅ Sets up your application
✅ Configures Apache with mod_rewrite
✅ Sets correct permissions
✅ Exposes port 80

---

## ✅ Files Created:

- ✅ `Dockerfile` - Complete PHP/Apache setup
- ✅ `.dockerignore` - Excludes unnecessary files

---

## 🚀 Ready!

**Select "Docker" as runtime and Render will use the Dockerfile automatically!**

The Dockerfile is already in your project and ready to go! 🎉

