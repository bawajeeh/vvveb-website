FROM php:8.1-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    postgresql-client \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mysqli \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Create env.php from production template if it doesn't exist
RUN if [ ! -f env.php ]; then \
    cp env.render.php env.php 2>/dev/null || \
    cp env.production.php env.php 2>/dev/null || \
    echo "<?php\n\
define('SQL_CHECK', false);\n\
define('PAGE_CACHE', true);\n\
defined('DEBUG') || define('DEBUG', false);\n\
defined('VTPL_DEBUG') || define('VTPL_DEBUG', false);\n\
defined('DISABLE_PLUGIN_ON_ERORR') || define('DISABLE_PLUGIN_ON_ERORR', true);\n\
defined('V_SUBDIR_INSTALL') || define('V_SUBDIR_INSTALL', false);\n\
defined('V_SHARED_SESSION') || define('V_SHARED_SESSION', false);\n\
defined('LOG_SQL_QUERIES') || define('LOG_SQL_QUERIES', false);\n\
defined('REST') || define('REST', false);\n\
defined('GRAPHQL') || define('GRAPHQL', false);\n\
defined('GRAPHQL_CAMELCASE') || define('GRAPHQL_CAMELCASE', true);\n\
defined('STRIP_EXIF') || define('STRIP_EXIF', true);\n\
if (DEBUG) {\n\
	ini_set('display_errors', 1);\n\
	ini_set('display_startup_errors', 1);\n\
	error_reporting(E_ALL);\n\
} else {\n\
	error_reporting(0);\n\
	ini_set('display_errors', 0);\n\
}" > env.php; \
    fi

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions for storage directories
RUN mkdir -p storage/cache storage/logs storage/compiled-templates storage/model storage/backup \
    && mkdir -p public/media public/image-cache public/page-cache public/assets-cache \
    && chmod -R 775 storage public/media public/image-cache

# Configure Apache virtual host
RUN echo '<VirtualHost *:80>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Copy startup script to handle Render's PORT variable
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port (Render will set PORT env var dynamically)
EXPOSE 80

# Start Apache using our script that handles PORT
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

