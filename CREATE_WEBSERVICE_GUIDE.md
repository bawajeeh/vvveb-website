# 🚀 Complete Guide: Create Web Service on Render

Follow these steps exactly to create your Web Service.

---

## STEP 1: Start Creating Web Service

1. **In Render Dashboard:**
   - Click **"New +"** (top right corner)
   - Click **"Web Service"**

---

## STEP 2: Connect GitHub Repository

1. **If GitHub isn't connected:**
   - Click **"Connect account"** or **"Connect GitHub"**
   - Authorize Render to access your GitHub account
   - Select the repositories you want to give access to

2. **Select Repository:**
   - Find and click on: **`bawajeeh/vvveb-website`**
   - Click **"Connect"**

---

## STEP 3: Configure Basic Settings

Fill in these fields:

### Name:
- **Value:** `vvveb-website` (or any name you like)

### Region:
- **Select:** `Oregon (US West)` (or same region as your database)

### Branch:
- **Value:** `main` (or `master` if that's your branch)

### Root Directory:
- **Leave EMPTY** (don't enter anything)

### Runtime:
- **Select:** `Docker` ⭐ (NOT PHP - it's not available!)

### Dockerfile Path:
- **Value:** `.` (just a dot - this is the default)
- This tells Render to use the Dockerfile in your root directory

### Build Command:
- **Leave EMPTY** (Docker handles building automatically)

### Start Command:
- **Leave EMPTY** (Docker handles starting automatically)

### Plan:
- **Select:** `Free` ⭐

---

## STEP 4: Add Persistent Disk

1. **Scroll down** to find **"Disks"** section
2. **Click:** **"Add Disk"** button
3. **Fill in:**
   - **Name:** `vvveb-storage`
   - **Mount Path:** `/var/www/html/storage`
   - **Size:** `1` GB
4. **Click:** **"Add Disk"**

**Why:** This disk stores your uploaded files, cache, and other data that needs to persist.

---

## STEP 5: Add Environment Variables

1. **Scroll down** to **"Environment Variables"** section
2. **Click:** **"Add Environment Variable"** button
3. **Add each variable one by one:**

   **Variable 1:**
   - **Key:** `PHP_VERSION`
   - **Value:** `8.1`
   - Click **"Add"**

   **Variable 2:**
   - **Key:** `DB_ENGINE`
   - **Value:** `pgsql`
   - Click **"Add"**

   **Variable 3:**
   - **Key:** `DB_HOST`
   - **Value:** `dpg-d46e12a4d50c73b0j330-a`
   - Click **"Add"**

   **Variable 4:**
   - **Key:** `DB_PORT`
   - **Value:** `5432`
   - Click **"Add"**

   **Variable 5:**
   - **Key:** `DB_DATABASE`
   - **Value:** `vvveb_db`
   - Click **"Add"**

   **Variable 6:**
   - **Key:** `DB_USER`
   - **Value:** `vvveb_db_user`
   - Click **"Add"**

   **Variable 7:**
   - **Key:** `DB_PASSWORD`
   - **Value:** `1dkwBSv5EdEf5IBXnR2Jg1IL8ENLH9pz`
   - Click **"Add"**

**✅ You should have 7 environment variables total**

---

## STEP 6: Create Web Service

1. **Scroll to the bottom** of the page
2. **Review your settings:**
   - ✅ Runtime: Docker
   - ✅ Dockerfile Path: .
   - ✅ Persistent Disk: Added
   - ✅ Environment Variables: 7 added
3. **Click:** **"Create Web Service"** button

---

## STEP 7: Wait for Deployment

1. **Render will now:**
   - Clone your repository
   - Build the Docker image (this takes 5-10 minutes)
   - Start your web service

2. **Watch the logs:**
   - You'll see build progress in real-time
   - Look for "Build successful" message
   - Then "Deploy successful" message

3. **When status shows "Live" (green):**
   - Your service is ready!
   - Copy your URL: `https://vvveb-website-XXXX.onrender.com`

---

## STEP 8: Get Your Website URL

Once deployment is complete:

1. **At the top of your service page**, you'll see:
   ```
   https://vvveb-website-XXXX.onrender.com
   ```
   (Your actual URL will be different)

2. **Copy this URL** - this is your website!

---

## ✅ Checklist Summary

Before clicking "Create Web Service", make sure you have:

- [ ] Runtime: **Docker** (not PHP!)
- [ ] Dockerfile Path: **.** (just a dot)
- [ ] Persistent Disk: **Added** (`vvveb-storage`, `/var/www/html/storage`, 1GB)
- [ ] Environment Variables: **7 variables added**
  - [ ] PHP_VERSION = 8.1
  - [ ] DB_ENGINE = pgsql
  - [ ] DB_HOST = dpg-d46e12a4d50c73b0j330-a
  - [ ] DB_PORT = 5432
  - [ ] DB_DATABASE = vvveb_db
  - [ ] DB_USER = vvveb_db_user
  - [ ] DB_PASSWORD = 1dkwBSv5EdEf5IBXnR2Jg1IL8ENLH9pz
- [ ] Plan: **Free**

---

## 🎯 After Deployment

Once your service is "Live":

1. **Visit:** `https://YOUR-URL.onrender.com/install/`
2. **Complete installation** using database credentials:
   - Host: `dpg-d46e12a4d50c73b0j330-a`
   - Port: `5432`
   - Database: `vvveb_db`
   - Username: `vvveb_db_user`
   - Password: `1dkwBSv5EdEf5IBXnR2Jg1IL8ENLH9pz`

---

## 🆘 Troubleshooting

**Build fails?**
- Check logs for errors
- Make sure Dockerfile is in root directory
- Verify all environment variables are correct

**Service won't start?**
- Check environment variables (especially database credentials)
- Verify database is "Available" (not "Building")
- Check logs for specific error messages

**Can't find Docker option?**
- Make sure you're creating "Web Service" (not Static Site)
- Refresh the page
- Docker should be in the runtime dropdown

---

**Follow these steps and your website will be live! 🚀**

