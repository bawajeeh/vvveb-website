# 🔄 Change Nameservers from Vercel Back to GoDaddy

Since your domain is registered with GoDaddy, you need to change nameservers **in GoDaddy**, not Vercel!

---

## ✅ Step-by-Step Guide:

### STEP 1: Change Nameservers in GoDaddy

1. **Log into GoDaddy:**
   - Go to https://godaddy.com
   - Sign in to your account

2. **Go to Domain Management:**
   - Click "My Products" or "Domains"
   - Find `ain90.online`
   - Click on it

3. **Go to Nameservers:**
   - Look for "Nameservers" or "DNS" section
   - Click "Manage" or "Change Nameservers"

4. **Change to GoDaddy Nameservers:**
   - Select "Use default nameservers" OR
   - Enter GoDaddy's nameservers manually:
     - `ns05.domaincontrol.com`
     - `ns06.domaincontrol.com`
   - Click **"Save"**

5. **Wait:** 5-30 minutes for nameserver changes to propagate

---

### STEP 2: Configure DNS in GoDaddy

Once nameservers are back to GoDaddy:

1. **Go to DNS Management:**
   - GoDaddy → Your Domain → DNS Management

2. **Update A Record:**
   - Find A record with Name: `@` and Data: `Parked`
   - Click Edit
   - **Type:** `A`
   - **Name:** `@`
   - **Data:** `216.24.57.1` (Render's IP)
   - **TTL:** `600 seconds`
   - Click **Save**

3. **Update www CNAME (if needed):**
   - Find CNAME with Name: `www`
   - Click Edit
   - **Name:** `www`
   - **Data:** `vvveb-website.onrender.com`
   - **TTL:** `600 seconds`
   - Click **Save**

---

### STEP 3: Verify in Render

1. **Go to Render Dashboard:**
   - Your Web Service → Settings → Custom Domains
   - Click **"Verify"** button next to your domains
   - Wait for DNS to propagate (5-30 minutes)

---

## 📋 What Happens:

1. **Nameservers change:** From Vercel → To GoDaddy
2. **DNS control:** Now managed by GoDaddy (not Vercel)
3. **DNS records:** You can edit them in GoDaddy
4. **Domain points to:** Render (via A record)

---

## ⚠️ Important Notes:

1. **Vercel DNS records will stop working** once nameservers change
   - That's okay - you'll use GoDaddy DNS instead

2. **Vercel SSL certificates** will stop working
   - Render will create new SSL certificates automatically

3. **DNS propagation takes time:**
   - Nameserver changes: 5-30 minutes (sometimes up to 48 hours)
   - DNS record changes: 5-30 minutes

---

## 🎯 Quick Steps:

1. ✅ GoDaddy → Your Domain → Nameservers
2. ✅ Change to GoDaddy nameservers (`ns05.domaincontrol.com`, `ns06.domaincontrol.com`)
3. ✅ Wait 5-30 minutes
4. ✅ Update A record in GoDaddy DNS: `@` → `216.24.57.1`
5. ✅ Update www CNAME: `www` → `vvveb-website.onrender.com`
6. ✅ Verify in Render dashboard
7. ✅ Wait for SSL certificate
8. ✅ Done! 🎉

---

## 🆘 If You Can't Find Nameservers in GoDaddy:

**Look for:**
- "DNS" section
- "Nameservers" section
- "Domain Settings"
- "Advanced DNS Settings"

**Or contact GoDaddy support** - they can help you change nameservers.

---

**Change nameservers in GoDaddy (where domain is registered), not Vercel!** 🚀

