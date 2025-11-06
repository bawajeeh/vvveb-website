# 🚀 Setup Instructions - Follow These Steps

I've prepared everything locally! Now you need to do these 3 simple steps:

---

## ✅ STEP 1: Create GitHub Repository (2 minutes)

1. **Go to:** https://github.com
2. **Sign in** (or create account if needed)
3. **Click:** The **"+"** icon (top right) → **"New repository"**
4. **Fill in:**
   - Repository name: `vvveb-website` (or any name you like)
   - Description: `My Website Builder`
   - Choose: **Public** (free)
   - **DO NOT** check "Initialize with README"
5. **Click:** **"Create repository"**

6. **Copy the repository URL** - it will look like:
   ```
   https://github.com/YOUR_USERNAME/vvveb-website.git
   ```

---

## ✅ STEP 2: Connect and Push to GitHub (1 minute)

**I'll run this command for you, but you need to provide:**
- Your GitHub username
- Your repository URL

**Or run this yourself in terminal:**

```bash
cd "/Users/abdullah/Desktop/Website Buider"
git remote add origin https://github.com/YOUR_USERNAME/vvveb-website.git
git branch -M main
git push -u origin main
```

**When asked for credentials:**
- Username: Your GitHub username
- Password: Use a **Personal Access Token** (not your password)
  - Get token: GitHub → Settings → Developer settings → Personal access tokens → Generate new token
  - Select scope: `repo`
  - Copy token and use it as password

---

## ✅ STEP 3: Deploy on Render (10 minutes)

1. **Go to:** https://render.com
2. **Sign up** with GitHub (click "Sign up with GitHub")
3. **Authorize** Render to access your GitHub account

### Create Database:
4. Click **"New +"** → **"PostgreSQL"**
5. Fill in:
   - Name: `vvveb-db`
   - Plan: **Free**
   - Click **"Create Database"**
6. Wait 1-2 minutes for database to be ready
7. **Copy the Internal Database URL** (looks like: `postgresql://user:pass@host:5432/db`)

### Create Web Service:
8. Click **"New +"** → **"Web Service"**
9. Connect your GitHub repository (`vvveb-website`)
10. **Settings:**
    - Name: `vvveb-website`
    - Runtime: `PHP`
    - Build Command: `composer install --no-dev --optimize-autoloader`
    - Start Command: `php -S 0.0.0.0:$PORT -t public`
    - Plan: **Free**
11. **Add Persistent Disk:**
    - Name: `vvveb-storage`
    - Mount Path: `/opt/render/project/src/storage`
    - Size: `1 GB`
12. **Add Environment Variables** (click "Add Environment Variable" for each):
    - `PHP_VERSION` = `8.1`
    - `DB_ENGINE` = `pgsql`
    - `DB_HOST` = `[extract from database URL - part after @ and before :]`
    - `DB_PORT` = `5432`
    - `DB_DATABASE` = `vvveb`
    - `DB_USER` = `[extract from database URL - part after :// and before :]`
    - `DB_PASSWORD` = `[extract from database URL - part after user: and before @]`
13. Click **"Create Web Service"**
14. Wait 3-5 minutes for deployment

### Install Application:
15. Once deployed, visit: `https://YOUR-APP.onrender.com/install/`
16. **Database Step:**
    - Engine: `PostgreSQL`
    - Use the same credentials from environment variables
17. **Admin Step:**
    - Email: Your email
    - Password: Choose a strong password
    - Complete installation

---

## 🎉 DONE!

Your website will be live at: `https://YOUR-APP.onrender.com`

---

## 📞 Need Help?

If you get stuck on any step, tell me:
- Which step you're on
- What error you see
- I'll help you fix it!

**Let me know when you've created the GitHub repository and I'll help you push the code!**

