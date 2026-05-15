# SR Mac Shop — Production Deployment

**Laravel:** 11
**PHP:** 8.2+
**Repository:** https://github.com/longsiyeaninfo-sudo/srmacshop.com.git

The Laravel application lives at the **repository root** (no `macstore/` subdirectory). The web server document root must point to `public/`.

---

## Required environment variables

```env
APP_NAME="SR Mac Shop"
APP_ENV=production
APP_KEY=                   # generate with `php artisan key:generate`
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://srmacshop.com
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=srmacshop
DB_USERNAME=
DB_PASSWORD=

CACHE_STORE=file
SESSION_DRIVER=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public

MAIL_MAILER=resend
RESEND_KEY=
MAIL_FROM_ADDRESS=orders@srmacshop.com
MAIL_FROM_NAME="${APP_NAME}"

STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=
CASHIER_CURRENCY=usd

ABA_MERCHANT_ID=
ABA_API_KEY=
ABA_BASE_URL=https://checkout.payway.com.kh

LOG_CHANNEL=stack
LOG_LEVEL=error
```

---

## Server requirements

- PHP 8.2 or higher (PHP 8.5 works; expect occasional Pdo deprecation notices)
- MySQL 8.0+ or MariaDB 10.6+
- Composer 2.x
- Node 18+ and npm (for Vite asset build)
- Apache with mod_rewrite, or Nginx
- SSH access to cPanel/server

---

## cPanel deployment

### 1. Clone repository via SSH

```bash
ssh username@your-server.com

# Clone into your home directory (NOT public_html — public_html will point at public/)
cd ~
git clone git@github.com:longsiyeaninfo-sudo/srmacshop.com.git srmacshop
cd srmacshop
```

### 2. Install dependencies and build assets

```bash
composer install --optimize-autoloader --no-dev
npm ci
npm run build

# Permissions
chmod -R 775 storage bootstrap/cache
```

### 3. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
nano .env       # set APP_URL, DB_*, mail, payment, etc.
```

### 4. Database setup

```bash
php artisan migrate --force
php artisan db:seed --force       # optional: seeds settings, coupons, sample catalog
php artisan storage:link
```

### 5. Point the domain at `public/`

**Option A — change document root (preferred)**

In cPanel → Domains, set the document root for srmacshop.com to:
`/home/username/srmacshop/public`

**Option B — `.htaccess` rewrite (when option A is not available)**

In `~/public_html/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ /home/username/srmacshop/public/$1 [L]
</IfModule>
```

### 6. Optimize for production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components
```

### 7. Queue worker and scheduler

Cron (every minute):

```cron
* * * * * cd /home/username/srmacshop && php artisan schedule:run >> /dev/null 2>&1
```

Queue worker via Supervisor or cPanel's process manager:

```ini
[program:srmacshop-worker]
command=php /home/username/srmacshop/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=username
```

---

## Git deployment workflow

**Local:**
```bash
git add .
git commit -m "your change"
git push origin main
```

**Server:**
```bash
cd ~/srmacshop
git pull origin main
composer install --optimize-autoloader --no-dev
npm ci && npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components
```

### One-shot deploy script

```bash
#!/usr/bin/env bash
set -euo pipefail
cd ~/srmacshop
git pull origin main
composer install --optimize-autoloader --no-dev
npm ci && npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components
```

---

## Web server configuration

### Nginx

```nginx
server {
    listen 80;
    server_name srmacshop.com www.srmacshop.com;
    root /var/www/srmacshop/public;

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

### Apache

```apache
<VirtualHost *:80>
  ServerName srmacshop.com
    DocumentRoot /var/www/srmacshop/public

    <Directory /var/www/srmacshop/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/srmacshop-error.log
    CustomLog ${APACHE_LOG_DIR}/srmacshop-access.log combined
</VirtualHost>
```

---

## Stripe webhook

Configure the Stripe dashboard webhook to:

`https://srmacshop.com/webhooks/stripe`

Events: `checkout.session.completed`, `checkout.session.expired`, `checkout.session.async_payment_failed`.

Copy the signing secret into `STRIPE_WEBHOOK_SECRET`.

---

## Maintenance mode

```bash
php artisan down --secret="recovery-token"
# Visit https://srmacshop.com/recovery-token to bypass maintenance.
php artisan up
```

---

## Troubleshooting

```bash
# Clear all caches
php artisan optimize:clear

# Permissions (Linux)
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# 500 errors
tail -f storage/logs/laravel.log
```

If `php artisan` emits `PDO::MYSQL_ATTR_SSL_CA is deprecated` notices on PHP 8.5, the project already references `Pdo\Mysql::ATTR_SSL_CA` in `config/database.php`; the warning above only appears when the framework still has the older constant on disk in `vendor/`. Re-running `composer install` after each Laravel patch release resolves it.
