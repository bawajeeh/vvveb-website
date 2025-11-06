# 🔄 Change Domain DNS from Vercel Back to GoDaddy

You want to manage your domain `ain90.online` through GoDaddy instead of Vercel.

---

## ✅ Step-by-Step Guide:

### STEP 1: Get GoDaddy Nameservers

1. **Log into GoDaddy:**
   - Go to https://godaddy.com
   - Sign in to your account

2. **Find Your Domain:**
   - Go to "My Products" or "Domains"
   - Find `ain90.online`
   - Click on it

3. **Get Nameservers:**
   - Go to "DNS" or "Nameservers" section
   - Note down GoDaddy's nameservers (usually something like):
     - `ns1.godaddy.com`
     - `ns2.godaddy.com`
   - Or use "Use default nameservers"

---

### STEP 2: Change Nameservers in Vercel

1. **Go to Vercel Dashboard:**
   - https://vercel.com/dashboard
   - Go to your domain: `ain90.online`

2. **Change Nameservers:**
   - Go to "Nameservers" or "DNS" settings
   - Click "Change Nameservers" or "Use Custom Nameservers"
   - Enter GoDaddy's nameservers:
     - `ns1.godaddy.com`
     - `ns2.godaddy.com`
   - Save changes

3. **Wait:** 5-30 minutes for nameserver changes to propagate

---

### STEP 3: Configure DNS in GoDaddy

Once nameservers are changed back to GoDaddy:

1. **Go to GoDaddy DNS Management:**
   - GoDaddy → Your Domain → DNS Management

2. **Get Your Render URL:**
   - From Render Dashboard → Your Web Service
   - Copy URL: `vvveb-website.onrender.com` (or similar)

3. **Add DNS Records in GoDaddy:**

   **For Root Domain (`ain90.online`):**
   - **Type:** `CNAME`
   - **Name:** `@` (or leave empty)
   - **Value:** `[your-render-url.onrender.com]`
   - **TTL:** `600` (or default)
   - Click "Save"

   **For www Subdomain:**
   - **Type:** `CNAME`
   - **Name:** `www`
   - **Value:** `[your-render-url.onrender.com]`
   - **TTL:** `600`
   - Click "Save"

---

### STEP 4: Add Custom Domain in Render

1. **In Render Dashboard:**
   - Go to your Web Service → Settings
   - Scroll to "Custom Domains"
   - Click "Add Custom Domain"
   - Enter: `ain90.online`
   - Click "Add"

2. **Render will verify DNS:**
   - Wait for DNS to propagate
   - Render will automatically create SSL certificate

---

## 📋 Complete Checklist:

- [ ] Log into GoDaddy
- [ ] Get GoDaddy nameservers
- [ ] Change nameservers in Vercel back to GoDaddy
- [ ] Wait 5-30 minutes for nameserver propagation
- [ ] Get Render URL from Render dashboard
- [ ] Add CNAME record in GoDaddy DNS pointing to Render
- [ ] Add custom domain in Render dashboard
- [ ] Wait for DNS propagation (5-30 minutes)
- [ ] Test: `https://ain90.online`

---

## 🎯 DNS Records to Add in GoDaddy:

```
Type    Name    Value                              TTL
CNAME   @       vvveb-website.onrender.com         600
CNAME   www     vvveb-website.onrender.com         600
```

---

## ⚠️ Important Notes:

1. **Nameserver Change:** Takes 5-30 minutes (sometimes up to 48 hours)
2. **DNS Propagation:** After nameservers change, DNS records take 5-30 minutes
3. **SSL Certificate:** Render will create SSL automatically after DNS propagates
4. **Vercel Records:** Once nameservers change, Vercel DNS records won't matter anymore

---

## 🆘 Troubleshooting:

**Domain not working after nameserver change?**
- Wait longer (can take up to 48 hours)
- Check DNS propagation: https://dnschecker.org
- Verify CNAME records in GoDaddy are correct
- Make sure Render custom domain is added

**Still seeing Vercel?**
- Clear DNS cache: `sudo dscacheutil -flushcache` (Mac)
- Or wait longer for full propagation

---

## ✅ Summary:

1. Change nameservers from Vercel to GoDaddy ✅
2. Add CNAME records in GoDaddy pointing to Render ✅
3. Add custom domain in Render ✅
4. Wait for propagation ✅
5. Done! 🎉

---

**Your domain will be managed by GoDaddy, but pointing to Render where your PHP website runs!** 🚀

