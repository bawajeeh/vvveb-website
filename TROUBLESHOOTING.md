# 🔍 Troubleshooting Render Deployment Failures

## Common Issues and Fixes:

### 1. Docker Build Fails

**Error:** "Build failed" or "Docker build error"

**Possible Causes:**
- Dockerfile syntax error
- Missing dependencies
- Composer install fails
- Permission issues

**Fix:**
- Check Render logs for specific error
- Verify Dockerfile is in root directory
- Make sure `.dockerignore` isn't excluding needed files

---

### 2. Service Won't Start

**Error:** "Service failed to start" or "Health check failed"

**Possible Causes:**
- Wrong port configuration
- Apache not starting
- Missing environment variables
- Database connection failed

**Fix:**
- Check Render logs
- Verify environment variables are set
- Make sure database is "Available"
- Check Apache is listening on port 80

---

### 3. Database Connection Error

**Error:** "Could not connect to database"

**Possible Causes:**
- Wrong database credentials
- Database not ready
- Using external URL instead of internal

**Fix:**
- Use Internal Database URL (not External)
- Verify all DB_* environment variables
- Check database status is "Available"
- Wait for database to be fully ready

---

### 4. File Permission Errors

**Error:** "Permission denied" or "Cannot write to storage"

**Possible Causes:**
- Storage directory not writable
- Wrong permissions in Dockerfile
- Persistent disk not mounted correctly

**Fix:**
- Check persistent disk is added
- Verify mount path: `/var/www/html/storage`
- Check Dockerfile sets correct permissions

---

### 5. Composer Install Fails

**Error:** "composer install failed" or "dependency error"

**Possible Causes:**
- Missing composer.json
- Network issues during build
- PHP version mismatch

**Fix:**
- Verify composer.json exists
- Check PHP version in Dockerfile (8.1)
- Try building locally to test

---

## 🔧 Quick Fixes:

### Check Render Logs:
1. Go to Render Dashboard
2. Click on your service
3. Click "Logs" tab
4. Look for error messages
5. Share the error with me for help!

### Verify Configuration:
- [ ] Dockerfile exists in root directory
- [ ] Runtime is set to "Docker"
- [ ] Dockerfile Path is "." (just a dot)
- [ ] All 7 environment variables are set
- [ ] Persistent disk is added
- [ ] Database is "Available" (not "Building")

---

## 📋 Debug Checklist:

1. **Check Build Logs:**
   - Look for specific error messages
   - Check if Composer install succeeded
   - Verify Docker build completed

2. **Check Runtime Logs:**
   - See if Apache started
   - Check for PHP errors
   - Verify database connection

3. **Verify Environment:**
   - All environment variables present
   - Database credentials correct
   - Persistent disk mounted

4. **Test Locally (Optional):**
   ```bash
   docker build -t vvveb-test .
   docker run -p 8080:80 vvveb-test
   ```

---

## 🆘 Need More Help?

**Share with me:**
1. What error message you see
2. Screenshot of Render logs
3. Which step failed (build or start)
4. Any specific error from logs

**I'll help you fix it!** 🚀

