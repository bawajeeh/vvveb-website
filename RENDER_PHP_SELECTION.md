# ⚠️ IMPORTANT: Select PHP Runtime!

When creating your Web Service on Render, you MUST select:

## ✅ Correct Runtime Selection:

**Runtime:** `PHP` (NOT Node!)

If you see a dropdown with options like:
- Node ❌
- Python 3 ❌
- Ruby ❌
- **PHP** ✅ ← SELECT THIS ONE!
- Go ❌
- Docker ❌
- etc.

**Select "PHP"** - that's what your Vvveb website builder needs!

---

## If PHP is Not Visible:

1. Make sure you're creating a **"Web Service"** (not Static Site)
2. PHP should be in the list - scroll if needed
3. If still not visible, try refreshing the page

---

## After Selecting PHP:

The form will show:
- **Build Command:** `composer install --no-dev --optimize-autoloader`
- **Start Command:** `php -S 0.0.0.0:$PORT -t public`

These are already configured correctly!

---

**Make sure you select PHP, not Node!** 🚀

