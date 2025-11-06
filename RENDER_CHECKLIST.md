# ✅ Render Deployment Checklist

Print this or keep it open while deploying. Check off each step as you complete it.

---

## 📦 STEP 1: Prepare Code (5 minutes)

- [ ] Open terminal/command prompt
- [ ] Navigate to project folder
- [ ] Run: `git init`
- [ ] Run: `git add .`
- [ ] Run: `git commit -m "Ready for Render"`
- [ ] Created GitHub account (if needed)
- [ ] Created new GitHub repository
- [ ] Connected local repo: `git remote add origin https://github.com/USERNAME/REPO.git`
- [ ] Pushed code: `git push -u origin main`
- [ ] Verified files are on GitHub

**✅ STEP 1 COMPLETE**

---

## 🗄️ STEP 2: Create Database (3 minutes)

- [ ] Signed up at render.com (with GitHub)
- [ ] Clicked "New +" → "PostgreSQL"
- [ ] Set name: `vvveb-db`
- [ ] Selected "Free" plan
- [ ] Clicked "Create Database"
- [ ] Waited for database to be ready (status: "Available")
- [ ] Copied Internal Database URL
- [ ] Extracted connection details:
  - [ ] Host: `_________________`
  - [ ] Port: `5432`
  - [ ] Database: `vvveb`
  - [ ] User: `_________________`
  - [ ] Password: `_________________`

**✅ STEP 2 COMPLETE**

---

## 🌐 STEP 3: Create Web Service (5 minutes)

- [ ] Clicked "New +" → "Web Service"
- [ ] Connected GitHub repository
- [ ] Selected repository: `_________________`
- [ ] Set name: `vvveb-website`
- [ ] Set Runtime: `PHP`
- [ ] Set Build Command: `composer install --no-dev --optimize-autoloader`
- [ ] Set Start Command: `php -S 0.0.0.0:$PORT -t public`
- [ ] Selected "Free" plan
- [ ] Added Persistent Disk:
  - [ ] Name: `vvveb-storage`
  - [ ] Mount Path: `/opt/render/project/src/storage`
  - [ ] Size: `1 GB`

**✅ STEP 3 COMPLETE**

---

## 🔧 STEP 4: Add Environment Variables (3 minutes)

Added these environment variables:

- [ ] `PHP_VERSION` = `8.1`
- [ ] `DB_ENGINE` = `pgsql`
- [ ] `DB_HOST` = `_________________`
- [ ] `DB_PORT` = `5432`
- [ ] `DB_DATABASE` = `vvveb`
- [ ] `DB_USER` = `_________________`
- [ ] `DB_PASSWORD` = `_________________`

- [ ] Clicked "Create Web Service"
- [ ] Waited for deployment (3-5 minutes)
- [ ] Status shows "Live" (green)
- [ ] Copied website URL: `https://_________________.onrender.com`

**✅ STEP 4 COMPLETE**

---

## 🚀 STEP 5: Install Application (5 minutes)

- [ ] Opened: `https://YOUR-URL.onrender.com/install/`
- [ ] Step 1: Requirements check passed ✅
- [ ] Step 2: Database Configuration:
  - [ ] Engine: `PostgreSQL`
  - [ ] Host: `_________________`
  - [ ] Port: `5432`
  - [ ] Database: `vvveb`
  - [ ] Username: `_________________`
  - [ ] Password: `_________________`
  - [ ] Clicked "Next"
- [ ] Step 3: Admin Setup:
  - [ ] Email: `_________________`
  - [ ] Password: `_________________`
  - [ ] Site Name: `ain90.online`
  - [ ] Selected theme
  - [ ] Clicked "Install"
- [ ] Installation completed successfully ✅
- [ ] Redirected to admin panel

**✅ STEP 5 COMPLETE**

---

## 🧪 STEP 6: Test Website (2 minutes)

- [ ] Tested frontend: `https://YOUR-URL.onrender.com` ✅
- [ ] Tested admin login: `https://YOUR-URL.onrender.com/vadmin` ✅
- [ ] Can login to admin panel ✅
- [ ] Can create/edit pages ✅

**✅ STEP 6 COMPLETE**

---

## 🌍 STEP 7: Connect Domain (Optional - 10 minutes)

- [ ] Went to Render → Settings → Custom Domains
- [ ] Added domain: `ain90.online`
- [ ] Got DNS instructions from Render
- [ ] Went to domain registrar
- [ ] Added CNAME record:
  - [ ] Type: `CNAME`
  - [ ] Name: `@` or `www`
  - [ ] Value: `YOUR-URL.onrender.com`
- [ ] Waited for DNS propagation (5-30 min)
- [ ] SSL certificate auto-generated ✅
- [ ] Tested: `https://ain90.online` ✅

**✅ STEP 7 COMPLETE**

---

## 🎉 DEPLOYMENT COMPLETE!

**Your Website:**
- Frontend: `https://_________________.onrender.com`
- Admin: `https://_________________.onrender.com/vadmin`
- Custom Domain: `https://ain90.online` (if connected)

**Admin Credentials:**
- Email: `_________________`
- Password: `_________________`

**Render Dashboard:**
- Web Service: https://dashboard.render.com/web
- Database: https://dashboard.render.com/databases

---

## 📝 Notes

- Free services sleep after 15 min (first request may be slow)
- Database expires after 30 days (can recreate)
- All data stored in persistent disk
- Automatic HTTPS included

---

## 🆘 Need Help?

- Check Render logs: Dashboard → Your service → "Logs"
- See full guide: `STEP_BY_STEP_RENDER.md`
- Render docs: https://render.com/docs

**Congratulations! Your website is live! 🚀**

