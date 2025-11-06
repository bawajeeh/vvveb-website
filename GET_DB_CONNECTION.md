# 📋 Get Your Database Connection String

I can see your database: **vvveb-db**

## ✅ Next Step: Get Connection String

1. **Click on your database name** (`vvveb-db`) to open it
2. **Find the "Connections" section** (usually near the top)
3. **Look for "Internal Database URL"** - it looks like:
   ```
   postgresql://user:password@host:5432/database
   ```
4. **Copy that Internal Database URL**

---

## 🔧 Then Run This:

Once you have the Internal Database URL, run:

```bash
cd "/Users/abdullah/Desktop/Website Buider"
./render-helper.sh
```

Paste your Internal Database URL when asked, and it will extract all the values you need!

---

## 📝 What You'll Get:

The script will give you:
- `DB_HOST` = [hostname]
- `DB_PORT` = 5432
- `DB_DATABASE` = [database name]
- `DB_USER` = [username]
- `DB_PASSWORD` = [password]

Then use these values in your Web Service environment variables!

---

**Click on your database → Find "Connections" → Copy "Internal Database URL" → Run the helper script!** 🚀

