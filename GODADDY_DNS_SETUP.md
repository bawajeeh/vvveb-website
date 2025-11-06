# 🔧 Configure GoDaddy DNS to Point to Render

I can see your GoDaddy DNS records. Here's how to point `ain90.online` to Render:

---

## ✅ Step-by-Step Instructions:

### STEP 1: Get Your Render URL

1. **Go to Render Dashboard:**
   - https://dashboard.render.com
   - Find your Web Service (`vvveb-website`)
   - Copy your Render URL (looks like: `vvveb-website.onrender.com`)

---

### STEP 2: Update DNS Records in GoDaddy

**In your GoDaddy DNS Management:**

#### Option A: Use CNAME (Recommended)

1. **Update the A Record:**
   - Find the A record with Name: `@` and Data: `Parked`
   - Click the **Edit** icon (pencil)
   - **Change Type to:** `CNAME` (or delete it and create new CNAME)
   - **Name:** `@` (or leave empty)
   - **Data:** `[your-render-url.onrender.com]`
     - Example: `vvveb-website.onrender.com`
   - **TTL:** `600 seconds` (or 1 Hour)
   - Click **"Save"**

2. **Update www CNAME:**
   - Find the CNAME record with Name: `www` and Data: `ain90.online.`
   - Click the **Edit** icon (pencil)
   - **Name:** `www`
   - **Data:** `[your-render-url.onrender.com]`
     - Example: `vvveb-website.onrender.com`
   - **TTL:** `600 seconds` (or 1 Hour)
   - Click **"Save"**

#### Option B: Keep A Record (Alternative)

If GoDaddy doesn't allow CNAME for root domain:

1. **Get Render's IP Address:**
   - You'll need to contact Render support or use a service
   - OR use CNAME with a service like Cloudflare

2. **Update A Record:**
   - Edit the A record
   - **Name:** `@`
   - **Data:** `[Render IP address]`
   - **TTL:** `600 seconds`
   - Save

**Note:** CNAME is easier and recommended!

---

### STEP 3: Add Custom Domain in Render

1. **In Render Dashboard:**
   - Go to your Web Service → **Settings**
   - Scroll to **"Custom Domains"**
   - Click **"Add Custom Domain"**
   - Enter: `ain90.online`
   - Click **"Add"**

2. **Also add www:**
   - Click **"Add Custom Domain"** again
   - Enter: `www.ain90.online`
   - Click **"Add"**

---

### STEP 4: Wait for DNS Propagation

- **Wait:** 5-30 minutes for DNS to propagate
- **Render will automatically:**
  - Detect DNS changes
  - Create SSL certificate
  - Enable HTTPS

---

## 📋 What Your DNS Should Look Like:

After changes, you should have:

```
Type    Name    Data                              TTL
CNAME   @       vvveb-website.onrender.com        600
CNAME   www     vvveb-website.onrender.com        600
NS      @       ns05.domaincontrol.com.          (keep)
NS      @       ns06.domaincontrol.com.          (keep)
SOA     @       ...                              (keep)
TXT     _dmarc  ...                              (keep)
```

---

## ⚠️ Important Notes:

1. **Don't Delete:**
   - NS records (nameservers) - Keep them!
   - SOA record - Keep it!
   - TXT records (like _dmarc) - Keep them if you use email

2. **Update:**
   - A record (@) → Change to CNAME pointing to Render
   - www CNAME → Update to point to Render

3. **If CNAME for @ doesn't work:**
   - Some DNS providers don't allow CNAME for root domain
   - In that case, you may need to use A record with IP
   - Or use a DNS service that supports CNAME flattening (like Cloudflare)

---

## 🎯 Quick Steps Summary:

1. ✅ Get Render URL from Render dashboard
2. ✅ Edit A record (@) → Change to CNAME → Point to Render URL
3. ✅ Edit www CNAME → Point to Render URL
4. ✅ Add custom domain in Render (`ain90.online` and `www.ain90.online`)
5. ✅ Wait 5-30 minutes
6. ✅ Test: `https://ain90.online`

---

## 🆘 Troubleshooting:

**Can't use CNAME for @ (root domain)?**
- Some DNS providers don't allow this
- Options:
  1. Use A record with Render's IP (contact Render support)
  2. Use a DNS service like Cloudflare (supports CNAME flattening)
  3. Use www subdomain only (less ideal)

**DNS not working after changes?**
- Wait longer (can take up to 48 hours)
- Check DNS propagation: https://dnschecker.org
- Verify records are correct in GoDaddy
- Make sure Render custom domain is added

---

**Update those DNS records in GoDaddy and your domain will point to Render!** 🚀

