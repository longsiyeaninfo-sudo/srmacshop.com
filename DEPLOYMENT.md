# MacStore - Production Environment Configuration

## Required Environment Variables

```env
# Application
APP_NAME="MacStore"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://yourdomain.com
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
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"

# Scout
SCOUT_DRIVER=database
# For production, consider using Meilisearch or Algolia
# SCOUT_DRIVER=meilisearch
# MEILISEARCH_HOST=http://127.0.0.1:7700
# MEILISEARCH_KEY=your_master_key

# Filament
FILAMENT_FILESYSTEM_DISK=public

# AWS S3 (Optional - for production file storage)
# AWS_ACCESS_KEY_ID=
# AWS_SECRET_ACCESS_KEY=
# AWS_DEFAULT_REGION=us-east-1
# AWS_BUCKET=
# AWS_USE_PATH_STYLE_ENDPOINT=false

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

### Server Requirements

- PHP 8.2 or higher
- MySQL 8.0+ or PostgreSQL 13+
- Redis (recommended for caching)
- Composer 2.x
- Node.js 18+ and NPM (for asset compilation)
- Web server (Nginx or Apache)

### Optimization Commands

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Compile assets
npm run build

# Create storage link
php artisan storage:link

# Run migrations
php artisan migrate --force

# Index products for search
php artisan scout:import "App\Models\Product"
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

## Deployment Steps

1. **Clone Repository**
   ```bash
   git clone https://github.com/longsiyeaninfo-sudo/srmacshop.com.git
   cd srmacshop.com/macstore
   ```

2. **Install Dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   # Edit .env with production values
   ```

4. **Database Setup**
   ```bash
   php artisan migrate --force
   php artisan db:seed --class=AdminSeeder
   ```

5. **Storage & Permissions**
   ```bash
   php artisan storage:link
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

6. **Optimize**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

7. **Queue Worker** (Supervisor recommended)
   ```bash
   php artisan queue:work --daemon
   ```

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
