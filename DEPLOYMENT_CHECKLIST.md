# Quick Deployment Checklist for ain90.online

## Pre-Deployment

- [ ] Backup current website (if any)
- [ ] Verify hosting meets requirements (PHP >= 7.4, MySQL, mod_rewrite)
- [ ] Create MySQL database and user
- [ ] Note down database credentials

## Upload Files

- [ ] Upload all files to web server
- [ ] Set document root to `/public` folder
- [ ] Set file permissions (755 for directories, 644 for files)
- [ ] Make `storage` folder writable (775)

## Installation

- [ ] Visit `https://ain90.online/install/`
- [ ] Complete database configuration step
- [ ] Complete admin account setup step
- [ ] Verify installation success

## Post-Installation

- [ ] Update `env.php` - Set DEBUG to false
- [ ] Test admin login at `https://ain90.online/vadmin`
- [ ] Test frontend at `https://ain90.online`
- [ ] Configure SSL/HTTPS
- [ ] Remove or protect `install` folder
- [ ] Change default admin password
- [ ] Set up regular backups

## Database Credentials Template

```
Host: localhost
Database: [your_database_name]
Username: [your_database_user]
Password: [your_database_password]
Prefix: (optional)
```

## Quick Commands (if SSH access available)

```bash
# Set permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod -R 775 storage public/media public/image-cache

# Install dependencies
composer install --no-dev --optimize-autoloader
```

