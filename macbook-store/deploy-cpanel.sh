#!/bin/bash

# MacBook Store - Complete cPanel Deployment Script
# This script will set up everything automatically

echo "🚀 MacBook Store - Automatic Deployment to cPanel"
echo "==========================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Step 1: Clean up old installation
echo "📦 Step 1: Cleaning up old files..."
cd ~
if [ -d "repositories/srmacshop.com" ]; then
    echo "Removing old repository..."
    rm -rf repositories/srmacshop.com
fi

# Step 2: Clone fresh from GitHub
echo ""
echo "📥 Step 2: Downloading project from GitHub..."
cd ~/repositories
git clone https://github.com/longsiyeaninfo-sudo/srmacshop.com.git
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Project downloaded successfully${NC}"
else
    echo -e "${RED}✗ Failed to download project${NC}"
    exit 1
fi

# Step 3: Go into project folder
echo ""
echo "📂 Step 3: Entering project folder..."
cd srmacshop.com/macbook-store
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Found macbook-store folder${NC}"
else
    echo -e "${RED}✗ macbook-store folder not found${NC}"
    exit 1
fi

# Step 4: Install dependencies
echo ""
echo "📦 Step 4: Installing dependencies (this may take 2-3 minutes)..."
npm install
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Dependencies installed${NC}"
else
    echo -e "${RED}✗ Failed to install dependencies${NC}"
    exit 1
fi

# Step 5: Generate Prisma Client
echo ""
echo "🔧 Step 5: Setting up database client..."
npx prisma generate
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Database client ready${NC}"
else
    echo -e "${RED}✗ Failed to generate database client${NC}"
    exit 1
fi

# Step 6: Build the application
echo ""
echo "🏗️  Step 6: Building application for production..."
npm run build
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Build completed successfully${NC}"
else
    echo -e "${RED}✗ Build failed${NC}"
  exit 1
fi

# Step 7: Create production environment file
echo ""
echo "⚙️  Step 7: Creating environment configuration..."
cat > .env.production << 'EOF'
# Database - YOU MUST UPDATE THIS
DATABASE_URL="postgresql://username:password@localhost:5432/macbook_store"

# Auth
AUTH_SECRET="P16M8M9jzw1ZSpRN5NBolHoAlBQNRqwlVcVGzWHQZ1E="
NEXTAUTH_URL="https://srmacshop.com"

# App
NEXT_PUBLIC_APP_URL="https://srmacshop.com"
NODE_ENV="production"

# Optional (can be empty for now)
AUTH_GOOGLE_ID=""
AUTH_GOOGLE_SECRET=""
STRIPE_SECRET_KEY=""
NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY=""
EOF

echo -e "${GREEN}✓ Environment file created${NC}"

# Step 8: Display summary
echo ""
echo "======================================"
echo -e "${GREEN}✅ INSTALLATION COMPLETE!${NC}"
echo "======================================="
echo ""
echo "📁 Project location:"
echo "   ~/repositories/srmacshop.com/macbook-store"
echo ""
echo "📋 Next steps:"
echo ""
echo "1. Set up PostgreSQL database in cPanel:"
echo "   - Go to cPanel → Databases → PostgreSQL Databases"
echo "   - Create database: macbook_store"
echo "   - Create user and grant privileges"
echo "   - Update DATABASE_URL in .env.production"
echo ""
echo "2. Configure Node.js App in cPanel:"
echo "   - Go to: Setup Node.js App"
echo "   - Click: Create Application"
echo "   - Node version: 18.x or higher"
echo "   - Application root: $(pwd)"
echo "   - Application startup file: node_modules/next/dist/bin/next"
echo "   - Application mode: Production"
echo ""
echo "3. Add Environment Variables in Node.js App:"
echo "   - Copy from .env.production file"
echo "   - Add each variable in the Node.js App interface"
echo ""
echo "4. Start the application!"
echo ""
echo "======================================="
echo "
echo "📄 Full path to your project:"
echo "   $(pwd)"
echo ""
echo "🎉 Your MacBook Store is ready to launch!"
