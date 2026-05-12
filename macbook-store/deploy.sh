#!/bin/bash

# MacBook Store - Quick Deployment Script
# This script helps you deploy to Vercel with all necessary configurations

echo "🚀 MacBook Store Deployment Helper"
echo "=============================="
echo ""

# Check if vercel is installed
if ! command -v vercel &> /dev/null; then
    echo "❌ Vercel CLI not found. Installing..."
    npm install -g vercel
fi

echo "📋 Pre-deployment Checklist:"
echo ""
echo "Before deploying, make sure you have:"
echo "  ✓ Neon PostgreSQL database created"
echo "  ✓ Google OAuth credentials"
echo "  ✓ Stripe API keys"
echo ""

read -p "Do you have all the above ready? (y/n) " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo ""
    echo "📚 Please complete the setup first:"
    echo ""
    echo "1. Database (Neon):"
    echo "   → Visit: https://neon.tech"
    echo "   → Create project: macbook-store"
    echo "   → Copy connection string"
    echo ""
    echo "2. Google OAuth:"
    echo "   → Visit: https://console.cloud.google.com"
    echo "   → Create OAuth 2.0 credentials"
    echo "   → Add redirect URI: https://your-domain.vercel.app/api/auth/callback/google"
    echo ""
    echo "3. Stripe:"
    echo "   → Visit: https://dashboard.stripe.com"
    echo "   → Get API keys from Developers → API keys"
    echo ""
    echo "Run this script again when ready!"
    exit 0
fi

echo "
echo "🎯 Starting deployment..."
echo ""

# Deploy to Vercel
vercel --prod

echo ""
echo "✅ Deployment initiated!"
echo ""
echo "📝 Next steps:"
echo "1. Go to Vercel dashboard and add environment variables"
echo "2. Run database migrations"
echo "3. Seed the database with products"
echo "4. Configure Stripe webhook"
echo "5. Make yourself an admin user"
echo ""
echo "See DEPLOYMENT.md for detailed instructions!"
