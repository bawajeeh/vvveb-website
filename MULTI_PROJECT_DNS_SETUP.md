# 🌐 Multi-Project DNS Configuration for `ain90.online`

## 📋 Overview

You have **two projects** using the same domain `ain90.online`:

1. **Vvveb CMS** (PHP) → Main website
2. **BuildFlow Platform** (React/Node.js) → Website builder platform

---

## 🎯 DNS Records Needed

### Current DNS Status:
- `ain90.online` → Currently pointing to Vercel (`64.29.17.1`, `216.198.79.1`)
- `app.ain90.online` → Not configured
- `api.ain90.online` → Not configured
- `www.ain90.online` → Not configured

---

## ✅ Complete DNS Configuration

### **GoDaddy DNS Management Setup**

#### **1. Root Domain (@) - Vvveb CMS**
```
Type: A
Name: @
Value: 216.24.57.1  (Render IP for Vvveb CMS)
TTL: 600 seconds
```

#### **2. www Subdomain - Vvveb CMS**
```
Type: CNAME
Name: www
Value: vvveb-website.onrender.com
TTL: 600 seconds
```

#### **3. app Subdomain - BuildFlow Frontend**
```
Type: CNAME
Name: app
Value: buildflow-platform-frontend.vercel.app
TTL: 600 seconds
```

#### **4. api Subdomain - BuildFlow Backend**
```
Type: CNAME
Name: api
Value: [Your BuildFlow Backend Render URL]
TTL: 600 seconds
```

#### **5. admin Subdomain - BuildFlow Admin (Optional)**
```
Type: CNAME
Name: admin
Value: [Your BuildFlow Admin Vercel URL]
TTL: 600 seconds
```

---

## 🚀 Step-by-Step Setup

### **Step 1: Configure Vvveb CMS (Main Domain)**

1. **GoDaddy DNS:**
   - Edit A record for `@`:
     - **Value:** `216.24.57.1`
     - **TTL:** `600`
   - Edit/Add CNAME for `www`:
     - **Name:** `www`
     - **Value:** `vvveb-website.onrender.com`
     - **TTL:** `600`

2. **Render Dashboard:**
   - Go to your Vvveb Web Service
   - Settings → Custom Domains
   - Add: `ain90.online`
   - Add: `www.ain90.online`
   - Click "Verify" for both

---

### **Step 2: Configure BuildFlow Platform**

#### **A. Frontend (app.ain90.online)**

1. **GoDaddy DNS:**
   - Add CNAME record:
     - **Name:** `app`
     - **Value:** `buildflow-platform-frontend.vercel.app`
     - **TTL:** `600`

2. **Vercel Dashboard:**
   - Go to BuildFlow Frontend project
   - Settings → Domains
   - Add: `app.ain90.online`
   - Verify DNS

#### **B. Backend API (api.ain90.online)**

1. **Deploy BuildFlow Backend on Render:**
   - Create new Web Service on Render
   - Connect GitHub repo: `bawajeeh/buildflow-platform`
   - Set root directory: `backend`
   - Deploy

2. **Get Render URL:**
   - After deployment, note the Render URL (e.g., `buildflow-backend.onrender.com`)

3. **GoDaddy DNS:**
   - Add CNAME record:
     - **Name:** `api`
     - **Value:** `[Your BuildFlow Backend Render URL]`
     - **TTL:** `600`

4. **Render Dashboard:**
   - Go to BuildFlow Backend Web Service
   - Settings → Custom Domains
   - Add: `api.ain90.online`
   - Click "Verify"

#### **C. Admin Dashboard (admin.ain90.online) - Optional**

1. **Deploy Admin Dashboard on Vercel:**
   - Connect `admin-dashboard` folder to Vercel

2. **GoDaddy DNS:**
   - Add CNAME record:
     - **Name:** `admin`
     - **Value:** `[Your Admin Dashboard Vercel URL]`
     - **TTL:** `600`

3. **Vercel Dashboard:**
   - Add: `admin.ain90.online`

---

## 📊 Final DNS Configuration Summary

| Subdomain | Type | Points To | Service | Project |
|-----------|------|-----------|---------|---------|
| `@` (root) | A | `216.24.57.1` | Render | Vvveb CMS |
| `www` | CNAME | `vvveb-website.onrender.com` | Render | Vvveb CMS |
| `app` | CNAME | `buildflow-platform-frontend.vercel.app` | Vercel | BuildFlow Frontend |
| `api` | CNAME | `[BuildFlow Backend URL]` | Render | BuildFlow Backend |
| `admin` | CNAME | `[Admin Dashboard URL]` | Vercel | BuildFlow Admin |

---

## 🔍 Verify DNS Configuration

### **Check DNS Records:**
```bash
# Check root domain
dig +short ain90.online A

# Check www
dig +short www.ain90.online CNAME

# Check app
dig +short app.ain90.online CNAME

# Check api
dig +short api.ain90.online CNAME
```

### **Expected Results:**
- `ain90.online` → `216.24.57.1`
- `www.ain90.online` → `vvveb-website.onrender.com`
- `app.ain90.online` → `buildflow-platform-frontend.vercel.app`
- `api.ain90.online` → `[Your BuildFlow Backend URL]`

---

## ⚠️ Important Notes

### **1. Remove Vercel Domain**
- If `ain90.online` is still in Vercel, remove it:
  - Vercel Dashboard → Domains → `ain90.online` → Remove

### **2. DNS Propagation**
- DNS changes take **5-30 minutes** to propagate
- Use [dnschecker.org](https://dnschecker.org) to check globally

### **3. SSL Certificates**
- Render and Vercel automatically provision SSL certificates
- Wait for DNS verification before SSL activates

### **4. GoDaddy Limitations**
- GoDaddy doesn't allow CNAME for root domain (`@`)
- Use A record for root domain (requires static IP)
- All subdomains can use CNAME records

---

## 🎯 Quick Action Checklist

### **For Vvveb CMS:**
- [ ] Update A record `@` → `216.24.57.1` in GoDaddy
- [ ] Update CNAME `www` → `vvveb-website.onrender.com` in GoDaddy
- [ ] Add `ain90.online` in Render custom domains
- [ ] Add `www.ain90.online` in Render custom domains
- [ ] Remove `ain90.online` from Vercel (if exists)

### **For BuildFlow Platform:**
- [ ] Deploy backend on Render (if not done)
- [ ] Add CNAME `app` → BuildFlow Frontend Vercel URL in GoDaddy
- [ ] Add CNAME `api` → BuildFlow Backend Render URL in GoDaddy
- [ ] Add `app.ain90.online` in Vercel
- [ ] Add `api.ain90.online` in Render
- [ ] (Optional) Set up `admin.ain90.online`

---

## 🚨 Troubleshooting

### **Issue: Root domain still shows Vercel 404**
- **Solution:** Remove domain from Vercel completely
- **Solution:** Wait for DNS propagation (up to 30 minutes)

### **Issue: Subdomain not working**
- **Check:** DNS record exists in GoDaddy
- **Check:** Custom domain added in Render/Vercel
- **Check:** DNS propagation status on dnschecker.org

### **Issue: SSL certificate not issued**
- **Solution:** Wait for DNS verification to complete
- **Solution:** Ensure DNS records are correct

---

## 📚 References

- [BuildFlow Platform Repository](https://github.com/bawajeeh/buildflow-platform)
- [Render Custom Domains](https://render.com/docs/custom-domains)
- [Vercel Custom Domains](https://vercel.com/docs/concepts/projects/domains)

---

**Once configured, your domain structure will be:**
- 🌐 `https://ain90.online` → Vvveb CMS (Main website)
- 🌐 `https://www.ain90.online` → Vvveb CMS (Main website)
- 🎨 `https://app.ain90.online` → BuildFlow Frontend (Website builder)
- 🔌 `https://api.ain90.online` → BuildFlow Backend API
- ⚙️ `https://admin.ain90.online` → BuildFlow Admin Dashboard (Optional)

