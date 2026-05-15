#!/bin/bash
# SR Mac Shop - cPanel Deployment Script (Step 2)
# Run this AFTER configuring your .env file

set -e  # Exit on any error

echo "=== SR Mac Shop Deployment - Step 2 ==="
echo "Running database migrations and optimization..."

cd ~/srmacshop

echo ""
echo "Step 7: Running database migrations..."
php artisan migrate --force

echo ""
echo "Step 8: Seeding database (creates admin user)..."
php artisan db:seed --force

echo ""
echo "Step 9: Creating storage link..."
php artisan storage:link

echo ""
echo "Step 10: Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components

echo ""
echo "=== Deployment Complete! ==="
echo ""
echo "Next steps:"
echo "1. In cPanel → Domains, set Document Root to: /home/siyeanlong/srmacshop/public"
echo "2. Visit: https://srmacshop.com"
echo "3. Admin login: https://srmacshop.com/admin"
echo "   Email: admin@srmacshop.com"
echo "   Password: password"
echo ""
echo "IMPORTANT: Change the admin password after first login!"
