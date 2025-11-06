# 🔧 Fix: Point Domain from Vercel to Render

Your domain `ain90.online` is currently pointing to Vercel, but your website is on Render!

## ✅ Solution: Update DNS Records

### Step 1: Get Your Render URL

1. Go to Render Dashboard
2. Find your Web Service (`vvveb-website`)
3. Copy your Render URL: `https://vvveb-website-XXXX.onrender.com`
   - It should look like: `vvveb-website.onrender.com` (without https://)

### Step 2: Add Custom Domain in Render

1. In Render Dashboard → Your Web Service → **Settings**
2. Scroll to **"Custom Domains"** section
3. Click **"Add Custom Domain"**
4. Enter: `ain90.online`
5. Click **"Add"**
6. Render will show you DNS instructions

### Step 3: Update DNS in Vercel

**You need to change the DNS records:**

1. **Go to Vercel Dashboard** → Your domain → DNS Settings

2. **Remove or Update the A record:**
   - Find the A record pointing to `216.24.57.1`
   - Either delete it OR update it to point to Render

3. **Add CNAME Record:**
   - Click **"Add Record"**
   - **Type:** `CNAME`
   - **Name:** `@` (for root domain) or leave empty
   - **Value:** `[your-render-url.onrender.com]`
     - Example: `vvveb-website.onrender.com`
   - **TTL:** `3600`
   - Click **"Save"**

4. **Update www Subdomain (if needed):**
   - **Type:** `CNAME`
   - **Name:** `www`
   - **Value:** `[your-render-url.onrender.com]`
   - **TTL:** `3600`
   - Click **"Save"**

### Step 4: Wait for DNS Propagation

- Wait 5-30 minutes for DNS to propagate
- Render will automatically create SSL certificate
- Your domain will work: `https://ain90.online`

---

## ⚠️ Important Notes:

1. **The ALIAS records** (with padlock) are managed by Vercel - you can leave them or remove them
2. **The CAA record** is for SSL - Render will handle SSL automatically
3. **After changing DNS**, Vercel's SSL certificates will stop working (that's okay - Render will create new ones)

---

## 🎯 Quick Steps:

1. ✅ Get Render URL from Render dashboard
2. ✅ Add `ain90.online` as custom domain in Render
3. ✅ Update CNAME record in Vercel DNS to point to Render URL
4. ✅ Wait 5-30 minutes
5. ✅ Done! `https://ain90.online` will work!

---

**The 404 error is because Vercel can't find a deployment - you need to point DNS to Render instead!** 🚀

