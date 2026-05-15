#!/bin/bash
# SR Mac Shop - cPanel Deployment Script
# Run this on your cPanel server after cloning the repository

set -e  # Exit on any error

echo "=== SR Mac Shop Deployment Script ==="
echo "Starting deployment..."

# Navigate to project directory
cd ~/srmacshop

echo ""
echo "Step 1: Installing PHP dependencies..."
composer install --optimize-autoloader --no-dev

echo ""
echo "Step 2: Installing Node dependencies..."
npm ci

echo ""
echo "Step 3: Building assets..."
npm run build

echo ""
echo "Step 4: Setting up environment file..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env file created from .env.example"
else
    echo ".env file already exists, skipping..."
fi

echo ""
echo "Step 5: Generating application key..."
php artisan key:generate --force

echo ""
echo "Step 6: Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo ""
echo "=== IMPORTANT: Configure your .env file now ==="
echo "Run: nano .env"
echo ""
echo "Update these values:"
echo "  APP_ENV=production"
echo "  APP_DEBUG=false"
echo "  APP_URL=https://srmacshop.com"
echo "  DB_CONNECTION=mysql"
echo "  DB_HOST=127.0.0.1"
echo "  DB_DATABASE=your_database_name"
echo "  DB_USERNAME=your_database_user"
echo "  DB_PASSWORD=your_database_password"
echo ""
echo "After editing .env, run: bash ~/srmacshop/deploy-step2.sh"
