# 🚀 Step-by-Step: Deploy to Render.com (FREE)

Follow these steps exactly in order. Each step has clear instructions.

---

## 📋 Prerequisites Checklist

Before starting, make sure you have:
- [ ] A GitHub account (free at github.com)
- [ ] Your website files ready (this folder)
- [ ] About 20-30 minutes of time

---

## STEP 1: Prepare Your Code for GitHub

### 1.1 Open Terminal/Command Prompt

- **Mac/Linux:** Open Terminal
- **Windows:** Open Command Prompt or PowerShell
- Navigate to your project folder:
  ```bash
  cd "/Users/abdullah/Desktop/Website Buider"
  ```

### 1.2 Initialize Git Repository

```bash
git init
```

### 1.3 Add All Files

```bash
git add .
```

### 1.4 Create First Commit

```bash
git commit -m "Initial commit - Ready for Render deployment"
```

### 1.5 Create GitHub Repository

1. Go to https://github.com
2. Sign in (or create account if needed)
3. Click the **"+"** icon (top right) → **"New repository"**
4. Repository name: `vvveb-website` (or any name you like)
5. Description: `Vvveb Website Builder`
6. Choose: **Public** (free) or **Private**
7. **DO NOT** check "Initialize with README"
8. Click **"Create repository"**

### 1.6 Connect and Push to GitHub

GitHub will show you commands. Use these (replace YOUR_USERNAME with your GitHub username):

```bash
git remote add origin https://github.com/YOUR_USERNAME/vvveb-website.git
git branch -M main
git push -u origin main
```

**Example:** If your username is `john`, use:
```bash
git remote add origin https://github.com/john/vvveb-website.git
git branch -M main
git push -u origin main
```

You'll be asked for your GitHub username and password (use a Personal Access Token if password doesn't work).

**✅ Check:** Go to your GitHub repository page - you should see all your files!

---

## STEP 2: Sign Up for Render.com

### 2.1 Create Render Account

1. Go to https://render.com
2. Click **"Get Started for Free"**
3. Click **"Sign up with GitHub"**
4. Authorize Render to access your GitHub account
5. Complete signup if needed

**✅ Check:** You should see the Render dashboard

---

## STEP 3: Create PostgreSQL Database

### 3.1 Create New Database

1. In Render dashboard, click **"New +"** (top right)
2. Click **"PostgreSQL"**

### 3.2 Configure Database

Fill in these fields:
- **Name:** `vvveb-db` (or any name)
- **Database:** `vvveb` (or leave default)
- **User:** `vvveb_user` (or leave default)
- **Region:** Choose closest to you (e.g., `Oregon (US West)`)
- **PostgreSQL Version:** `Latest` (or default)
- **Plan:** Select **"Free"** ⭐

### 3.3 Create Database

Click **"Create Database"**

### 3.4 Wait for Database to Start

Wait 1-2 minutes for database to be ready (status will show "Available")

### 3.5 Copy Database Connection Details

1. Click on your database name
2. Find **"Connections"** section
3. You'll see:
   - **Internal Database URL** (for Render services)
   - **External Database URL** (for local access)

**📝 IMPORTANT:** Copy the **Internal Database URL** - it looks like:
```
postgresql://vvveb_user:password123@dpg-xxxxx-a.oregon-postgres.render.com:5432/vvveb
```

**Extract these values:**
- **Host:** `dpg-xxxxx-a.oregon-postgres.render.com` (part after @ and before :)
- **Port:** `5432` (usually this)
- **Database:** `vvveb` (last part after /)
- **User:** `vvveb_user` (part after :// and before :)
- **Password:** `password123` (part after user: and before @)

**✅ Check:** You have all database connection details written down

---

## STEP 4: Create Web Service on Render

### 4.1 Create New Web Service

1. In Render dashboard, click **"New +"**
2. Click **"Web Service"**

### 4.2 Connect GitHub Repository

1. Click **"Connect account"** if GitHub isn't connected
2. Find and select your repository (`vvveb-website`)
3. Click **"Connect"**

### 4.3 Configure Web Service

Fill in these settings:

**Basic Settings:**
- **Name:** `vvveb-website` (or any name)
- **Region:** Same as database (e.g., `Oregon (US West)`)
- **Branch:** `main` (or `master` if that's your branch)
- **Root Directory:** Leave **empty** (default)
- **Runtime:** `PHP`
- **Build Command:** 
  ```
  composer install --no-dev --optimize-autoloader
  ```
- **Start Command:**
  ```
  php -S 0.0.0.0:$PORT -t public
  ```

**Plan:**
- Select **"Free"** ⭐

### 4.4 Add Environment Variables

Scroll down to **"Environment Variables"** section and click **"Add Environment Variable"** for each:

1. **PHP_VERSION**
   - Key: `PHP_VERSION`
   - Value: `8.1`
   - Click **"Add"**

2. **DB_ENGINE**
   - Key: `DB_ENGINE`
   - Value: `pgsql`
   - Click **"Add"**

3. **DB_HOST**
   - Key: `DB_HOST`
   - Value: `[paste the hostname from Step 3.5]`
   - Example: `dpg-xxxxx-a.oregon-postgres.render.com`
   - Click **"Add"**

4. **DB_PORT**
   - Key: `DB_PORT`
   - Value: `5432`
   - Click **"Add"`

5. **DB_DATABASE**
   - Key: `DB_DATABASE`
   - Value: `vvveb` (or your database name)
   - Click **"Add"`

6. **DB_USER**
   - Key: `DB_USER`
   - Value: `vvveb_user` (or your database user)
   - Click **"Add"`

7. **DB_PASSWORD**
   - Key: `DB_PASSWORD`
   - Value: `[paste the password from Step 3.5]`
   - Click **"Add"**

**✅ Check:** You have 7 environment variables added

### 4.5 Add Persistent Disk (IMPORTANT!)

1. Scroll to **"Disks"** section
2. Click **"Add Disk"**
3. Fill in:
   - **Name:** `vvveb-storage`
   - **Mount Path:** `/opt/render/project/src/storage`
   - **Size:** `1` GB (free tier allows 1GB)
4. Click **"Add Disk"**

**✅ Check:** Disk is added to the list

### 4.6 Create Web Service

Scroll down and click **"Create Web Service"**

### 4.7 Wait for Deployment

Render will now:
1. Clone your repository
2. Install Composer dependencies
3. Build your application
4. Start the web service

**⏳ Wait 3-5 minutes** for first deployment

**✅ Check:** Status shows "Live" (green) when ready

---

## STEP 5: Get Your Website URL

### 5.1 Find Your URL

Once deployment is complete:
1. At the top of your web service page, you'll see:
   ```
   https://vvveb-website.onrender.com
   ```
   (Your URL will be different - use YOUR actual URL)

2. **Copy this URL** - this is your website!

**✅ Check:** You have your website URL

---

## STEP 6: Install the Application

### 6.1 Open Installation Page

1. Open a new browser tab
2. Go to: `https://YOUR-URL.onrender.com/install/`
   (Replace YOUR-URL with your actual Render URL)

### 6.2 Step 1: Check Requirements

The installer will check:
- PHP version ✅
- Required extensions ✅
- Writable folders ✅

If everything is green, click **"Next"** or continue

### 6.3 Step 2: Database Configuration

Fill in the database form:

- **Database Engine:** Select **"PostgreSQL"** (pgsql)
- **Host:** `[same as DB_HOST from Step 4.4]`
  - Example: `dpg-xxxxx-a.oregon-postgres.render.com`
- **Port:** `5432`
- **Database:** `vvveb` (or your database name)
- **Username:** `vvveb_user` (or your database user)
- **Password:** `[same as DB_PASSWORD from Step 4.4]`
- **Prefix:** Leave **empty**

Click **"Next"** or **"Continue"**

**⏳ Wait:** Database tables will be created (30-60 seconds)

### 6.4 Step 3: Admin Account Setup

Fill in:
- **Admin Email:** Your email address
  - Example: `admin@ain90.online`
- **Admin Password:** Choose a strong password
  - Example: `MySecurePassword123!`
- **Confirm Password:** Type password again

**Site Settings:**
- **Site Name:** `ain90.online` (or your site name)
- **Site Description:** (optional)
- **Default Theme:** Choose a theme (e.g., `landing`)
- **Language:** Choose your language

Click **"Install"** or **"Complete Installation"**

**⏳ Wait:** Installation completes (1-2 minutes)

### 6.5 Installation Complete!

You should see a success message and be redirected to admin panel.

**✅ Check:** You can see the admin dashboard

---

## STEP 7: Update Production Settings

### 7.1 Update env.php

1. Go back to Render dashboard
2. Click on your web service
3. Go to **"Environment"** tab
4. Add new environment variable:
   - Key: `RENDER_ENV`
   - Value: `production`
   - Click **"Add"**

5. Or manually update `env.php` via Render Shell:
   - Go to **"Shell"** tab in Render
   - Run:
     ```bash
     cp env.render.php env.php
     ```

### 7.2 Verify Settings

The `env.php` should have:
- `DEBUG = false`
- `PAGE_CACHE = true`
- `SQL_CHECK = false`

---

## STEP 8: Test Your Website

### 8.1 Test Frontend

1. Go to: `https://YOUR-URL.onrender.com`
2. You should see your website homepage

### 8.2 Test Admin Panel

1. Go to: `https://YOUR-URL.onrender.com/vadmin`
2. Login with your admin credentials
3. You should see the admin dashboard

**✅ Check:** Both frontend and admin work

---

## STEP 9: Connect Custom Domain (Optional)

### 9.1 Add Custom Domain

1. In Render dashboard → Your web service → **"Settings"**
2. Scroll to **"Custom Domains"**
3. Click **"Add Custom Domain"**
4. Enter: `ain90.online`
5. Click **"Add"**

### 9.2 Update DNS Records

Render will show you DNS records to add:

1. Go to your domain registrar (where you bought `ain90.online`)
2. Find DNS settings
3. Add a **CNAME** record:
   - **Type:** CNAME
   - **Name:** `@` or `www`
   - **Value:** `[your-render-url.onrender.com]`
   - **TTL:** 3600

4. Wait 5-30 minutes for DNS to propagate

### 9.3 SSL Certificate

Render automatically creates SSL certificate (wait 5-10 minutes)

**✅ Check:** `https://ain90.online` works!

---

## 🎉 CONGRATULATIONS!

Your website is now live on Render.com for FREE!

---

## 📝 Quick Reference

**Your Website URLs:**
- Frontend: `https://YOUR-URL.onrender.com`
- Admin: `https://YOUR-URL.onrender.com/vadmin`

**Render Dashboard:**
- Web Service: https://dashboard.render.com/web
- Database: https://dashboard.render.com/databases

**Important Notes:**
- Free services sleep after 15 min inactivity (first request may be slow)
- Database expires after 30 days (can recreate)
- All files stored in persistent disk survive restarts
- Automatic HTTPS included

---

## 🆘 Troubleshooting

### Website shows 500 Error
- Check Render logs: Dashboard → Your service → "Logs"
- Verify database environment variables are correct
- Check file permissions

### Database Connection Error
- Verify all DB_* environment variables are set correctly
- Check database is running (status should be "Available")
- Use Internal Database URL, not External

### Installation Page Not Loading
- Make sure you're using `/install/` path
- Check Render logs for errors
- Verify PHP version is 8.1

### Slow First Load
- Normal! Free services sleep after 15 min
- First request wakes up the service (~30 seconds)
- Subsequent requests are fast

---

## ✅ Final Checklist

- [ ] Code pushed to GitHub
- [ ] Render account created
- [ ] PostgreSQL database created
- [ ] Web service deployed
- [ ] Environment variables set
- [ ] Persistent disk added
- [ ] Installation completed
- [ ] Website tested
- [ ] Admin panel tested
- [ ] Custom domain connected (optional)

**You're all set! 🚀**

