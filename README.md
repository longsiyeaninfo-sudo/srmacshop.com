# MacStore - E-commerce Platform

A modern, full-featured e-commerce platform built with Laravel 13, Livewire 4, and Filament 5, designed for selling MacBooks and Apple products in Cambodia.

## Features

### Customer Features
- 🛍️ **Product Browsing** - Browse products with advanced filtering and search
- 🔍 **Search** - Laravel Scout powered search across products
- 🛒 **Shopping Cart** - Session-based cart with real-time updates
- 💳 **Checkout** - Complete checkout process with order management
- 👤 **User Accounts** - Customer dashboard with order history
- 📍 **Address Management** - Save and manage multiple shipping addresses
- ❤️ **Wishlist** - Save favorite products for later
- ⭐ **Reviews & Ratings** - Product reviews with star ratings
- 📧 **Email Notifications** - Order confirmations and shipping updates
- 🌓 **Dark Mode** - Beautiful dark mode support
- 🌐 **Multi-language** - English and Khmer language support

### Admin Features
- 📊 **Dashboard** - Comprehensive admin dashboard
- 📦 **Product Management** - Products with variants and specifications
- 📁 **Category Management** - Hierarchical category system
- 📋 **Order Management** - Complete order processing workflow
- 👥 **User Management** - Customer and admin user management
- 🎟️ **Coupon System** - Discount codes and promotions
- ⭐ **Review Moderation** - Approve and manage customer reviews
- ⚙️ **Settings** - Site-wide configuration options

## Tech Stack

- **Framework**: Laravel 13
- **Frontend**: Livewire 4, Alpine.js, Tailwind CSS
- **Admin Panel**: Filament 5
- **Database**: SQLite (dev) / MySQL (production)
- **Search**: Laravel Scout
- **Media**: Spatie Media Library
- **Permissions**: Spatie Laravel Permission
- **Translations**: Spatie Laravel Translatable

## Requirements

- PHP 8.2 or higher
- Composer 2.x
- Node.js 18+ and NPM
- MySQL 8.0+ or PostgreSQL 13+ (production)
- Redis (recommended for production)

## Installation

### Development Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/longsiyeaninfo-sudo/srmacshop.com.git
   cd srmacshop.com/macstore
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Compile assets**
   ```bash
   npm run dev
   ```

8. **Start development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   - Storefront: http://127.0.0.1:8000
   - Admin Panel: http://127.0.0.1:8000/admin
   - Admin Credentials: admin@macstore.com / password

## Production Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed production deployment instructions.

## Project Structure

```
macstore/
├── app/
│   ├── Filament/          # Admin panel resources
│   ├── Livewire/          # Livewire components
│   ├── Mail/              # Email templates
│   ├── Models/          # Eloquent models
│   └── Services/      # Business logic services
├── database/
│   ├── migrations/     # Database migrations
│   └── seeders/        # Database seeders
├── resources/
│   ├── views/
│   │   ├── components/    # Blade components
│   │   ├── livewire/      # Livewire views
│   │   └── layouts/       # Layout templates
│   └── css/               # Stylesheets
└── routes/
    └── web.php        # Web routes
```

## Development Phases

✅ **Phase 1**: Project Setup
✅ **Phase 2**: Design System Foundation
✅ **Phase 3**: Database & Models
✅ **Phase 4**: Admin Panel (Filament)
✅ **Phase 5**: Storefront Pages (Livewire)
✅ **Phase 6**: Cart & Checkout
✅ **Phase 7**: Customer Account
✅ **Phase 8**: Search, Reviews, Email
✅ **Phase 9**: Polish & Performance
✅ **Phase 10**: Testing & Deployment

## Key Features Implementation

### Search
- Laravel Scout with database driver
- Full-text search across products
- Searchable: name, description, SKU, category

### Caching
- Featured products cached (1 hour)
- Category list cached (1 hour)
- Database query optimization with indexes

### Performance
- Eager loading to prevent N+1 queries
- Database indexes on frequently queried columns
- Image optimization with multiple sizes
- Asset compilation and minification

### Security
- CSRF protection
- XSS prevention
- SQL injection protection
- Secure password hashing
- Role-based access control

## Testing

```bash
# Run tests
php artisan test

# Clear caches
php artisan optimize:clear
```

## Contributing

This is a private project. For issues or questions, please contact the development team.

## License

Proprietary - All rights reserved

## Credits

- **Developer**: Claude Opus 4.7 (AI Assistant)
- **Project Owner**: Long Siyean Info
- **Framework**: Laravel
- **Admin Panel**: Filament
- **UI Components**: Livewire

## Support

For support, please contact: admin@macstore.com

---

**MacStore** - Premium MacBooks for Cambodia 🇰🇭
