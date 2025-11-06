# 🌐 Complete Guide: Connect Vercel Domain to Render

Since `ain90.online` is managed by Vercel, here's how to connect it to Render:

---

## ✅ The Solution:

**Keep your domain on Vercel, but point DNS to Render!**

This way:
- ✅ Domain stays managed by Vercel
- ✅ PHP app runs on Render (where it works)
- ✅ Best of both worlds!

---

## 📋 Complete Steps:

### PART 1: Deploy on Render First

1. **Follow:** `CREATE_WEBSERVICE_GUIDE.md`
2. **Deploy your web service**
3. **Wait for it to be "Live"**
4. **Copy your Render URL:** `https://vvveb-website-XXXX.onrender.com`

### PART 2: Add Custom Domain in Render

1. **In Render Dashboard:**
   - Go to your Web Service
   - Click **"Settings"** tab
   - Scroll to **"Custom Domains"** section

2. **Add Domain:**
   - Click **"Add Custom Domain"**
   - Enter: `ain90.online`
   - Click **"Add"**
   - (Optional) Also add: `www.ain90.online`

3. **Render will show DNS instructions:**
   - It will tell you what DNS record to add
   - Usually a CNAME record

### PART 3: Update DNS in Vercel

1. **Go to Vercel Dashboard:**
   - https://vercel.com/dashboard
   - Select your project or domain

2. **Go to DNS Settings:**
   - Click on your domain: `ain90.online`
   - Go to **"DNS"** or **"Settings"** → **"Domains"**

3. **Add CNAME Record:**
   - Click **"Add Record"** or **"Add DNS Record"**
   - **Type:** `CNAME`
   - **Name:** `@` (for root domain) or leave empty
   - **Value:** `[your-render-url.onrender.com]`
     - Example: `vvveb-website-xxxx.onrender.com`
   - **TTL:** `3600` (or default)
   - Click **"Save"** or **"Add"**

4. **Add www Subdomain (Optional):**
   - **Type:** `CNAME`
   - **Name:** `www`
   - **Value:** `[your-render-url.onrender.com]`
   - **TTL:** `3600`
   - Click **"Save"**

### PART 4: Wait and Verify

1. **Wait 5-30 minutes** for DNS propagation
2. **Render will automatically:**
   - Detect the DNS change
   - Create SSL certificate
   - Enable HTTPS

3. **Test:**
   - Visit: `https://ain90.online`
   - Should show your website!

---

## 🎯 Example DNS Configuration:

In Vercel DNS, you'll have:

```
Type    Name    Value                              TTL
CNAME   @       vvveb-website-xxxx.onrender.com    3600
CNAME   www     vvveb-website-xxxx.onrender.com    3600
```

---

## ⚠️ Important Notes:

1. **Don't remove existing DNS records** unless you know what they're for
2. **Keep Vercel as DNS provider** - just add the CNAME
3. **Render handles SSL automatically** - no need to configure certificates
4. **DNS propagation takes time** - be patient (5-30 minutes)

---

## 🆘 Troubleshooting:

**Domain not working?**
- Check DNS propagation: https://dnschecker.org
- Verify CNAME record is correct in Vercel
- Make sure Render custom domain is added
- Wait a bit longer (DNS can take up to 48 hours, but usually 5-30 min)

**SSL certificate not ready?**
- Render creates SSL automatically
- Wait 5-10 minutes after DNS propagates
- Check Render dashboard for SSL status

**Still using Vercel site?**
- Clear DNS cache: `sudo dscacheutil -flushcache` (Mac)
- Or wait longer for DNS to fully propagate

---

## ✅ Summary:

1. Deploy on Render ✅
2. Add `ain90.online` as custom domain in Render ✅
3. Add CNAME record in Vercel DNS pointing to Render ✅
4. Wait for DNS propagation ✅
5. Done! `https://ain90.online` works! 🎉

---

**Your domain stays on Vercel, but your PHP website runs on Render!** 🚀

