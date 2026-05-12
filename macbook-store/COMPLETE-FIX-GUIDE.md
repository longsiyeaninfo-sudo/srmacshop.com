# 🚀 COMPLETE FIX - All Commands Ready

## ═══════════════════════════════════
## PART 1: RUN DEPLOYMENT SCRIPT
## ══════════════════════════

### Open cPanel Terminal and paste this:

```bash
cd ~ && curl -o deploy.sh https://raw.githubusercontent.com/longsiyeaninfo-sudo/srmacshop.com/main/macbook-store/deploy-cpanel.sh && chmod +x deploy.sh && ./deploy.sh
```

**Wait 2-3 minutes for it to complete.**

---

## ═══════════════════════════════
## PART 2: CREATE DATABASE
## ════════════════════════════════════

### Step 1: Create Database in cPanel

1. Go to: **cPanel → Databases → PostgreSQL Databases**
2. Under "Create New Database":
   - Database name: `macbook_store`
   - Click **Create Database**

### Step 2: Create Database User

1. Under "Add New User":
   - Username: `macbook_user`
   - Password: `MacBook2024!Store` (or create your own)
   - Click **Create User**

### Step 3: Add User to Database

1. Under "Add User To Database":
   - User: `macbook_user`
   - Database: `macbook_store`
   - Click **Add**
2. On privileges page:
   - Check **ALL PRIVILEGES**
   - Click **Make Changes**

### Step 4: Note Your Database URL

Your connection string is:
```
postgresql://macbook_user:MacBook2024!Store@localhost:5432/macbook_store
```

---

## ════════════════════════════════════
## PART 3: UPDATE ENVIRONMENT FILE
## ════════════════════════════

### In Terminal, run these commands:

```bash
cd ~/repositories/srmacshop.com/macbook-store

cat > .env.production << 'EOF'
DATABASE_URL="postgresql://macbook_user:MacBook2024!Store@localhost:5432/macbook_store"
AUTH_SECRET="P16M8M9jzw1ZSpRN5NBolHoAlBQNRqwlVcVGzWHQZ1E="
NEXTAUTH_URL="https://srmacshop.com"
NEXT_PUBLIC_APP_URL="https://srmacshop.com"
NODE_ENV="production"
EOF
```

---

## ═════════════════════════
## PART 4: RUN DATABASE MIGRATIONS
## ════════════════════════

### In Terminal, run:

```bash
cd ~/repositories/srmacshop.com/macbook-store
export DATABASE_URL="postgresql://macbook_user:MacBook2024!Store@localhost:5432/macbook_store"
npx prisma migrate deploy
npm run db:seed
```

**This creates tables and adds 4 MacBook products.**

---

## ═════════════════════════════════
## PART 5: SET UP NODE.JS APP
## ════════════════════════════

### Step 1: Create Application

1. Go to: **cPanel → Software → Setup Node.js App**
2. Click **Create Application**
3. Fill in:

```
Node.js version: 18.20.5 (or any 18.x version)
Application mode: Production
Application root: repositories/srmacshop.com/macbook-store
Application URL: srmacshop.com
Application startup file: node_modules/next/dist/bin/next
```

4. Click **Create**

### Step 2: Add Environment Variables

In the Node.js App page, scroll to **Environment Variables**.

Click **Add Variable** for each:

```
Name: DATABASE_URL
Value: postgresql://macbook_user:MacBook2024!Store@localhost:5432/macbook_store

Name: AUTH_SECRET
Value: P16M8M9jzw1ZSpRN5NBolHoAlBQNRqwlVcVGzWHQZ1E=

Name: NEXTAUTH_URL
Value: https://srmacshop.com

Name: NEXT_PUBLIC_APP_URL
Value: https://srmacshop.com

Name: NODE_ENV
Value: production
```

Click **Save** after adding all.

---

## ═════════════════════════════════
## PART 6: START THE APPLICATION
## ══════════════════════════════

1. In **Setup Node.js App** page
2. Find your application
3. Click **Start App** button
4. Wait 30 seconds

---

## ════════════════
## PART 7: TEST YOUR SITE
## ═══════════════════════════

Visit: **https://srmacshop.com**

You should see:
✅ Homepage with MacBook products
✅ Shop page with 4 products
✅ Product detail pages
✅ Working configurator
✅ Add to cart

---

## 🆘 TROUBLESHOOTING

### If you see errors:

**Error: "Cannot find module"**
```bash
cd ~/repositories/srmacshop.com/macbook-store
npm install
```

**Error: "Database connection failed"**
- Check DATABASE_URL is correct
- Make sure database exists
- Verify user has privileges

**Error: "Application won't start"**
- Check Node.js version is 18.x
- Verify startup file path
- Check cPanel error logs: **Metrics → Errors**

**Still not working?**
Run this to check logs:
```bash
cd ~/repositories/srmacshop.com/macbook-store
npm start
```

Look for error messages and tell me what you see.

---

## 📋 QUICK CHECKLIST

Before your site works:

- [ ] Deployment script ran successfully
- [ ] PostgreSQL database created (`macbook_store`)
- [ ] Database user created (`macbook_user`)
- [ ] User added to database with ALL PRIVILEGES
- [ ] .env.production file updated
- [ ] Database migrations ran (`prisma migrate deploy`)
- [ ] Database seeded (`npm run db:seed`)
- [ ] Node.js app created in cPanel
- [ ] Environment variables added
- [ ] Application started

---

## 🎉 SUCCESS!

When everything works, you'll see your MacBook Store at:
**https://srmacshop.com**

With:
- 4 MacBook products
- Working configurator
- Shopping cart
- Beautiful macOS design

---

**Copy these commands and run them one by one!**
**I'm here to help if you get stuck!** 🚀
