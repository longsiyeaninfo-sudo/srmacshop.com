# 🔧 FIX: Deploy MacBook Store to cPanel

## Problem: HTTP ERROR 500 on srmacshop.com

Your Next.js app needs proper Node.js configuration in cPanel.

---

## ✅ SOLUTION: Step-by-Step Fix

### Step 1: Check cPanel Node.js Support

1. Login to cPanel at your hosting provider
2. Go to **Software** → **Setup Node.js App**
3. If you don't see this option, contact your hosting provider - they need to enable Node.js

### Step 2: Build the Application Locally

```bash
cd /Users/mac08/SRMACSHOP/macbook-store

# Install dependencies
npm install

# Build for production
npm run build

# This creates the .next folder with optimized code
```

### Step 3: Create Production Environment File

Create `.env.production` in the macbook-store folder:

```env
# Database - MUST BE REAL DATABASE
DATABASE_URL="postgresql://username:password@your-db-host:5432/database_name"

# Auth
AUTH_SECRET="P16M8M9jzw1ZSpRN5NBolHoAlBQNRqwlVcVGzWHQZ1E="
NEXTAUTH_URL="https://srmacshop.com"

# App
NEXT_PUBLIC_APP_URL="https://srmacshop.com"

# Optional (can be empty for now)
AUTH_GOOGLE_ID=""
AUTH_GOOGLE_SECRET=""
STRIPE_SECRET_KEY=""
NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY=""
```

### Step 4: Upload Files to cPanel

**Upload these folders/files via cPanel File Manager or FTP:**

```
macbook-store/
├── .next/              ← IMPORTANT: Build output
├── node_modules/    ← All dependencies
├── public/             ← Static files
├── app/            ← Source code
├── components/         ← Components
├── lib/                ← Libraries
├── prisma/             ← Database schema
├── package.json        ← Dependencies list
├── package-lock.json   ← Lock file
├── next.config.ts      ← Next.js config
├── .env.production     ← Production environment
└── middleware.ts       ← Middleware
```

**Upload to:** `/home/yourusername/public_html/` or `/home/yourusername/srmacshop.com/`

### Step 5: Configure Node.js App in cPanel

1. Go to **Setup Node.js App**
2. Click **Create Application**
3. Configure:

```
Node.js version: 18.x or higher
Application mode: Production
Application root: /home/yourusername/public_html/macbook-store
Application URL: srmacshop.com
Application startup file: node_modules/next/dist/bin/next
```

4. Click **Create**

### Step 6: Set Environment Variables in cPanel

In the Node.js App settings, add these environment variables:

```
DATABASE_URL = postgresql://your-real-database-url
AUTH_SECRET = P16M8M9jzw1ZSpRN5NBolHoAlBQNRqwlVcVGzWHQZ1E=
NEXTAUTH_URL = https://srmacshop.com
NEXT_PUBLIC_APP_URL = https://srmacshop.com
NODE_ENV = production
```

### Step 7: Start the Application

1. In cPanel Node.js App settings
2. Click **Start App** or **Restart**
3. Wait 30 seconds
4. Visit https://srmacshop.com

---

## 🚨 IMPORTANT: Database Setup
Your app **REQUIRES** a PostgreSQL database. You have 2 options:

### Option A: Use cPanel PostgreSQL (if available)

1. cPanel → **Databases** → **PostgreSQL Databases**
2. Create database: `macbook_store`
3. Create user and grant privileges
4. Get connection string:
   ```
   postgresql://username:password@localhost:5432/macbook_store
   ```
5. Update `.env.production` with this URL

### Option B: Use External Database (Recommended)

**Use Neon (Free tier):**

1. Go to https://neon.tech
2. Create account
3. Create project: "macbook-store"
4. Copy connection string (looks like):
   ```
   postgresql://user:pass@ep-xxx.region.aws.neon.tech/neondb
   ```
5. Update `.env.production` with this URL

### Run Database Migrations

After setting up database, run migrations:

```bash
# On your local machine with production DATABASE_URL
export DATABASE_URL="your-production-database-url"
npx prisma migrate deploy
npm run db:seed
```

---

## 🔍 Troubleshooting

### Error: "Cannot find module 'next'"

**Fix:** Make sure `node_modules/` folder is uploaded

### Error: "Database connection failed"

**Fix:** 
1. Check DATABASE_URL is correct
2. Make sure database exists
3. Run migrations: `npx prisma migrate deploy`

### Error: "Application won't start"

**Fix:**
1. Check Node.js version is 18+
2. Verify Application startup file: `node_modules/next/dist/bin/next`
3. Check cPanel error logs

### Still showing 500 error?

**Check cPanel Error Logs:**
1. cPanel → **Metrics** → **Errors**
2. Look for Node.js errors
3. Common issues:
   - Missing DATABASE_URL
   - Wrong Node.js version
   - Missing .next folder (need to build)

---

## ⚡ FASTER ALTERNATIVE: Deploy to Vercel Instead

**cPanel is complex for Next.js. Vercel is optimized for it:**

### Deploy to Vercel (10 minutes):

1. Go to https://vercel.com/new
2. Import: `longsiyeaninfo-sudo/srmacshop.com`
3. Root directory: `macbook-store`
4. Add environment variables:
   ```
   DATABASE_URL = your-neon-database-url
   AUTH_SECRET = P16M8M9jzw1ZSpRN5NBolHoAlBQNRqwlVcVGZWHQZ1E=
   NEXTAUTH_URL = https://your-project.vercel.app
   NEXT_PUBLIC_APP_URL = https://your-project.vercel.app
   ```
5. Deploy!
6. **Then point srmacshop.com to Vercel:**
   - Vercel → Settings → Domains
   - Add `srmacshop.com`
   - Update DNS records as instructed

**Benefits:**
- ✅ Automatic builds
- ✅ CDN included
- ✅ No server management
- ✅ Free SSL
- ✅ Optimized for Next.js

---

## 📝 Quick Commands

### Build locally:
```bash
cd /Users/mac08/SRMACSHOP/macbook-store
npm run build
```

### Test locally before uploading:
```bash
npm run start
# Visit http://localhost:3000
```

### Check if build worked:
```bash
ls -la .next/
# Should see: server/, static/, BUILD_ID, etc.
```

---

## ✅ Checklist

Before your site works, you need:

- [ ] Node.js app configured in cPanel
- [ ] All files uploaded (including .next folder)
- [ ] Environment variables set
- [ ] PostgreSQL database created
- [ ] Database migrations run
- [ ] Database seeded with products
- [ ] Application started in cPanel

---

## 🆘 Need Help?

If cPanel is too complex, I **strongly recommend Vercel** instead. It's:
- Free for your use case
- Designed for Next.js
- Much easier to deploy
- Better performance

**Your choice:**
1. **cPanel** = More work, need Node.js support
2. **Vercel** = 10 minutes, works perfectly

Let me know which path you want to take!
