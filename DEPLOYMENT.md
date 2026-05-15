# MacStore - Production Environment Configuration

**Laravel Version:** 13.9.0  
**PHP Version:** 8.2+  
**Repository:** https://github.com/longsiyeaninfo-sudo/srmacshop.com.git

## Required Environment Variables

```env
# Application
APP_NAME="MacStore"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://srmacshop.com
APP_LOCALE=en
APP_FALLBACK_LOCALE=en

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=macstore
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

# Cache & Session
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@srmacshop.com"
MAIL_FROM_NAME="${APP_NAME}"

# Logging
LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error
```

## Production Checklist

### Before Deployment

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY` with `php artisan key:generate`
- [ ] Configure production database credentials
- [ ] Set up Redis for caching and sessions
- [ ] Configure mail server (SMTP, Mailgun, SES, etc.)
- [ ] Set correct `APP_URL`
- [ ] Review and update `.env` file

## Server Requirements

- PHP 8.2 or higher
- MySQL 8.0+ or MariaDB 10.3+
- Composer 2.x
- Web server (Apache with mod_rewrite or Nginx)
- SSH access to cPanel/server

## cPanel Deployment Steps

### 1. Clone Repository via SSH

```bash
# SSH into your cPanel server
ssh username@your-server.com

# Navigate to your domain directory (usually public_html or a subdomain folder)
cd public_html

# Clone the repository
git clone git@github.com:longsiyeaninfo-sudo/srmacshop.com.git .
# OR if using HTTPS:
# git clone https://github.com/longsiyeaninfo-sudo/srmacshop.com.git .

# Navigate to the Laravel project
cd macstore
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Set proper permissions
chmod -R 755 storage bootstrap/cache
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env
# Generate application key
php artisan key:generate

# Edit .env file with your production settings
nano .env
```

**Important .env settings for cPanel:**
- Set `APP_URL` to your domain (e.g., https://srmacshop.com)
- Configure database credentials from cPanel MySQL
- Set `APP_ENV=production` and `APP_DEBUG=false`

### 4. Database Setup
```bash
# Run migrations
php artisan migrate --force

# Optional: Seed initial data
php artisan db:seed
```

### 5. Configure Web Server

**For cPanel with Apache:**

The Laravel project includes a `.htaccess` file in the `public` directory. You need to point your domain to the `public` folder.

**Option A: Using cPanel File Manager**
1. Go to cPanel → Domains → Domains
2. Edit your domain
3. Change Document Root to: `/home/username/public_html/macstore/public`

**Option B: Using .htaccess redirect (if you can't change document root)**

Create a `.htaccess` file in your root directory:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ macstore/public/$1 [L]
</IfModule>
```

### 6. Storage Link

```bash
# Create symbolic link for storage
php artisan storage:link
```

### 7. Optimize for Production

```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Security

- [ ] Enable HTTPS/SSL
- [ ] Set secure session cookies (`SESSION_SECURE_COOKIE=true`)
- [ ] Configure CORS if needed
- [ ] Set up firewall rules
- [ ] Enable rate limiting
- [ ] Configure backup strategy
- [ ] Set up monitoring and logging
- [ ] Review file permissions (storage and bootstrap/cache should be writable)

### Performance

- [ ] Enable OPcache
- [ ] Configure Redis for cache and sessions
- [ ] Set up queue workers (`php artisan queue:work`)
- [ ] Enable HTTP/2
- [ ] Configure CDN for static assets (optional)
- [ ] Set up database connection pooling
- [ ] Enable Gzip compression

### Monitoring

- [ ] Set up error tracking (Sentry, Bugsnag, etc.)
- [ ] Configure application monitoring
- [ ] Set up uptime monitoring
- [ ] Configure log rotation
- [ ] Set up database backups
- [ ] Monitor disk space and performance

## Git Deployment Workflow

### Initial Setup
```bash
# Add remote if not already added
git remote add origin git@github.com:longsiyeaninfo-sudo/srmacshop.com.git

# Verify remote
git remote -v
```

### Deploying Updates

**On your local machine:**
```bash
# Make your changes
git add .
git commit -m "Your commit message"
git push origin main
```

**On cPanel server via SSH:**
```bash
# Navigate to project
cd /home/username/public_html/macstore

# Pull latest changes
git pull origin main

# Update dependencies if composer.json changed
composer install --optimize-autoloader --no-dev

# Run migrations if database changed
php artisan migrate --force

# Clear and recache
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Automated Deployment (Optional)

You can set up a webhook or cron job to automatically pull changes:

```bash
# Create a deployment script: deploy.sh
#!/bin/bash
cd /home/username/public_html/macstore
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Production Checklist

### Before Deployment

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY` with `php artisan key:generate`
- [ ] Configure production database credentials
- [ ] Set correct `APP_URL`
- [ ] Review and update `.env` file

## Web Server Configuration

### Nginx Example

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com;
    root /var/www/macstore/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Apache Example

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/macstore/public

    <Directory /var/www/macstore/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/macstore-error.log
    CustomLog ${APACHE_LOG_DIR}/macstore-access.log combined
</VirtualHost>
```

## Maintenance Mode

```bash
# Enable maintenance mode
php artisan down --secret="your-secret-token"

# Access site during maintenance
https://yourdomain.com/your-secret-token

# Disable maintenance mode
php artisan up
```

## Troubleshooting

### Clear All Caches
```bash
php artisan optimize:clear
```

### Permission Issues
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Database Connection Issues
- Check database credentials in `.env`
- Verify database server is running
- Check firewall rules

### 500 Errors
- Check `storage/logs/laravel.log`
- Verify file permissions
- Check `.env` configuration
- Run `php artisan config:clear`
