# 🌐 Connect Your Vercel Domain (ain90.online) to Render

Since your domain is managed by Vercel, we have two options:

---

## Option 1: Point Domain from Vercel to Render (RECOMMENDED)

### Step 1: Get Your Render URL
1. After your Render service is deployed and "Live"
2. Copy your Render URL: `https://vvveb-website-XXXX.onrender.com`

### Step 2: Add Custom Domain in Render
1. In Render dashboard → Your Web Service → **"Settings"**
2. Scroll to **"Custom Domains"** section
3. Click **"Add Custom Domain"**
4. Enter: `ain90.online`
5. Also add: `www.ain90.online` (optional)
6. Click **"Add"**

### Step 3: Get DNS Records from Render
Render will show you DNS records to add:
- Usually a **CNAME** record pointing to your Render URL

### Step 4: Update DNS in Vercel
1. Go to your Vercel dashboard
2. Select your project/domain: `ain90.online`
3. Go to **"Settings"** → **"Domains"** or **"DNS"**
4. Add the DNS record that Render provided:
   - **Type:** CNAME
   - **Name:** `@` (or leave empty for root domain)
   - **Value:** `[your-render-url.onrender.com]`
   - **TTL:** 3600

5. For `www` subdomain (if you added it):
   - **Type:** CNAME
   - **Name:** `www`
   - **Value:** `[your-render-url.onrender.com]`
   - **TTL:** 3600

### Step 5: Wait for DNS Propagation
- Wait 5-30 minutes for DNS to propagate
- Render will automatically create SSL certificate
- Your domain will work: `https://ain90.online`

---

## Option 2: Use Vercel as Proxy (Advanced)

If you want to keep using Vercel but proxy to Render:

1. **In Vercel**, create a `vercel.json` file:
```json
{
  "rewrites": [
    {
      "source": "/(.*)",
      "destination": "https://your-render-url.onrender.com/$1"
    }
  ]
}
```

2. **Deploy to Vercel** (but this won't work well for PHP - see below)

**⚠️ Warning:** This won't work well because:
- Vercel doesn't support PHP
- Proxy adds latency
- Better to point domain directly to Render

---

## ✅ Recommended Approach:

**Use Option 1** - Point your Vercel-managed domain directly to Render:

1. ✅ Keep domain on Vercel (for DNS management)
2. ✅ Point DNS to Render (where your PHP app runs)
3. ✅ Render handles SSL automatically
4. ✅ Best performance

---

## 📋 Step-by-Step Summary:

1. **Deploy on Render** (follow `CREATE_WEBSERVICE_GUIDE.md`)
2. **Get Render URL** (e.g., `https://vvveb-website-XXXX.onrender.com`)
3. **Add custom domain in Render:** `ain90.online`
4. **Get DNS records from Render**
5. **Add CNAME record in Vercel DNS:**
   - Point `@` to your Render URL
6. **Wait for DNS propagation** (5-30 min)
7. **Done!** `https://ain90.online` will work!

---

## 🎯 Quick Commands:

After Render deployment, you'll need:
- Render URL: `https://vvveb-website-XXXX.onrender.com`
- Add to Render custom domains: `ain90.online`
- Add to Vercel DNS: CNAME pointing to Render URL

---

**Your domain can stay on Vercel, but point to Render where your PHP app runs!** 🚀

