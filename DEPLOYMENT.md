# Deployment Guide for ain90.online

This guide will help you deploy the Vvveb Website Builder to your domain `ain90.online`.

## Prerequisites

1. **Web Server Requirements:**
   - PHP >= 7.4.0
   - MySQL/MariaDB database
   - Apache with mod_rewrite enabled (or Nginx)
   - Required PHP extensions: mysqli, mysqlnd, xml, libxml, pcre, zip, dom, curl, gettext

2. **Hosting Account:**
   - Access to your hosting control panel (cPanel, Plesk, etc.)
   - FTP/SFTP access or SSH access
   - Database creation privileges

## Step 1: Prepare Your Files

1. **Upload all files** to your web server:
   - Upload the entire project to your domain's root directory (usually `public_html` or `www`)
   - OR upload to a subdirectory if you prefer (e.g., `public_html/website-builder`)

2. **Set proper file permissions:**
   ```bash
   chmod 755 storage
   chmod 755 storage/cache
   chmod 755 storage/model
   chmod 755 storage/compiled-templates
   chmod 755 config
   chmod 755 public/media
   chmod 755 public/themes
   chmod 755 public/image-cache
   chmod 755 plugins
   ```

## Step 2: Configure Database

1. **Create a MySQL database:**
   - Log into your hosting control panel
   - Create a new MySQL database (e.g., `ain90_vvveb`)
   - Create a database user and assign it to the database
   - Note down: database name, username, password, and host (usually `localhost`)

2. **Database credentials example:**
   ```
   Database Name: ain90_vvveb
   Database User: ain90_user
   Database Password: [your_password]
   Database Host: localhost
   ```

## Step 3: Configure Web Server

### For Apache (Most Common):

1. **Ensure `.htaccess` is enabled** on your server
2. **Point document root** to the `public` folder:
   - If uploaded to root: Point document root to `/public_html/public`
   - If using subdirectory: Update `.htaccess` RewriteBase accordingly

### For Nginx:

Create an Nginx configuration file with:
```nginx
server {
    listen 80;
    server_name ain90.online www.ain90.online;
    root /path/to/your/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\. {
        deny all;
    }
}
```

## Step 4: Install Dependencies

1. **Install Composer dependencies** (if you have SSH access):
   ```bash
   cd /path/to/your/project
   composer install --no-dev --optimize-autoloader
   ```

   OR upload the `vendor` folder if it's already included in your upload.

## Step 5: Run Installation

1. **Access the installation wizard:**
   - Visit: `https://ain90.online/install/index.php`
   - OR: `https://ain90.online/install/` (if mod_rewrite is working)

2. **Follow the installation steps:**
   - **Step 1:** Check system requirements
   - **Step 2:** Enter database credentials:
     - Database Engine: MySQLi
     - Host: localhost (or your database host)
     - Database: [your_database_name]
     - Username: [your_database_user]
     - Password: [your_database_password]
     - Prefix: (leave empty or use a prefix like `vvveb_`)
   - **Step 3:** Configure admin account:
     - Admin Email: [your_email]
     - Admin Password: [secure_password]
     - Choose theme
     - Set site name and other settings

3. **Complete installation** - The system will automatically:
   - Create database tables
   - Set up default data
   - Configure the admin account

## Step 6: Post-Installation Configuration

1. **Update `env.php` for production:**
   - Set `DEBUG` to `false`
   - Set `PAGE_CACHE` to `true`
   - Set `SQL_CHECK` to `false`

2. **Secure your installation:**
   - Delete or protect the `install` folder after installation
   - Change default admin path if needed (during installation)
   - Set strong admin password

3. **Configure SSL/HTTPS:**
   - Install SSL certificate (Let's Encrypt is free)
   - Update `.htaccess` to force HTTPS (uncomment lines 37-38)

## Step 7: Verify Installation

1. **Access your website:**
   - Frontend: `https://ain90.online`
   - Admin Panel: `https://ain90.online/vadmin` (or custom path you set)

2. **Test functionality:**
   - Login to admin panel
   - Create a test page
   - Upload media
   - Test the website builder

## Troubleshooting

### Common Issues:

1. **500 Internal Server Error:**
   - Check file permissions
   - Check `.htaccess` is enabled
   - Check PHP error logs

2. **Database Connection Error:**
   - Verify database credentials
   - Check database host (might be `127.0.0.1` instead of `localhost`)
   - Ensure database user has proper permissions

3. **Permission Denied:**
   - Set correct file permissions (755 for directories, 644 for files)
   - Check ownership of files

4. **Installation Page Not Loading:**
   - Ensure `public` folder is document root
   - Check mod_rewrite is enabled
   - Verify PHP version >= 7.4

### File Permissions Reference:
```bash
# Directories
find . -type d -exec chmod 755 {} \;

# Files
find . -type f -exec chmod 644 {} \;

# Specific writable directories
chmod -R 775 storage
chmod -R 775 public/media
chmod -R 775 public/image-cache
```

## Security Checklist

- [ ] Change default admin password
- [ ] Set `DEBUG` to `false` in `env.php`
- [ ] Enable HTTPS/SSL
- [ ] Remove or protect `install` folder after installation
- [ ] Set strong database password
- [ ] Regularly update the application
- [ ] Backup database regularly
- [ ] Set proper file permissions

## Support

For more information, visit:
- Documentation: https://docs.vvveb.com/
- GitHub: https://github.com/givanz/Vvveb

