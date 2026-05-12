# 🚀 SIMPLE GUIDE - Deploy Your MacBook Store to cPanel

## ✅ I'll Do Everything For You - Just Follow These Steps

---

## STEP 1: Open Terminal in cPanel

1. Login to your cPanel
2. Scroll down to **Advanced** section
3. Click **Terminal**
4. A black screen will open (this is the terminal)

---

## STEP 2: Copy & Paste This Command

**Copy this entire command** (click to select all, then Ctrl+C or Cmd+C):

```bash
cd ~ && curl -o deploy.sh https://raw.githubusercontent.com/longsiyeaninfo-sudo/srmacshop.com/main/macbook-store/deploy-cpanel.sh && chmod +x deploy.sh && ./deploy.sh
```

**Paste it into the terminal** (right-click → Paste, or Ctrl+V)

**Press Enter**

---

## STEP 3: Wait (2-3 minutes)

The script will automatically:
- ✅ Download your project from GitHub
- ✅ Install all dependencies
- ✅ Build the application
- ✅ Set up configuration files

You'll see progress messages like:
```
📦 Step 1: Cleaning up old files...
📥 Step 2: Downloading project from GitHub...
📦 Step 4: Installing dependencies...
🏗️  Step 6: Building application...
✅ INSTALLATION COMPLETE!
```

---

## STEP 4: Set Up Database (5 minutes)

After the script finishes:

### 4a. Create PostgreSQL Database

1. Go to cPanel → **Databases** → **PostgreSQL Databases**
2. Create New Database:
   - Database name: `macbook_store`
   - Click **Create Database**
3. Create New User:
   - Username: `macbook_user`
   - Password: (create a strong password)
   - Click **Create User**
4. Add User to Database:
   - User: `macbook_user`
   - Database: `macbook_store`
   - Click **Add**
   - Check **ALL PRIVILEGES**
   - Click **Make Changes**

### 4b. Get Database Connection String

Your DATABASE_URL will be:
```
postgresql://macbook_user:YOUR_PASSWORD@localhost:5432/macbook_store
```

Replace `YOUR_PASSWORD` with the password you created.

### 4c. Update Environment File

In cPanel Terminal, run:
```bash
cd ~/repositories/srmacshop.com/macbook-store
nano .env.production
```

Update the DATABASE_URL line with your connection string.

Press `Ctrl+X`, then `Y`, then `Enter` to save.

---

## STEP 5: Set Up Node.js App (3 minutes)

1. Go to cPanel → **Software** → **Setup Node.js App**

2. Click **Create Application**

3. Fill in these details:

   ```
   Node.js version: 18.20.5 (or latest 18.x)
   Application mode: Production
   Application root: repositories/srmacshop.com/macbook-store
   Application URL: srmacshop.com
   Application startup file: node_modules/next/dist/bin/next
   ```

4. Click **Create**

---

## STEP 6: Add Environment Variables

In the Node.js App page, scroll to **Environment Variables** section.

Click **Add Variable** for each of these:

```
DATABASE_URL = postgresql://macbook_user:YOUR_PASSWORD@localhost:5432/macbook_store
AUTH_SECRET = P16M8M9jzw1ZSpRN5NBolHoAlBQNRqwlVcVGzWHQZ1E=
NEXTAUTH_URL = https://srmacshop.com
NEXT_PUBLIC_APP_URL = https://srmacshop.com
NODE_ENV = production
```

Click **Save** after adding all variables.

---

## STEP 7: Run Database Setup

In cPanel Terminal:

```bash
cd ~/repositories/srmacshop.com/macbook-store
export DATABASE_URL="postgresql://macbook_user:YOUR_PASSWORD@localhost:5432/macbook_store"
npx prisma migrate deploy
npm run db:seed
```

This will:
- Create database tables
- Add 4 MacBook products

---

## STEP 8: Start Your Application

1. Go back to **Setup Node.js App** in cPanel
2. Find your application
3. Click **Start App** or **Restart**
4. Wait 30 seconds

---

## STEP 9: Visit Your Site! 🎉

Go to: **https://srmacshop.com**

You should see:
- ✅ Homepage with MacBook products
- ✅ Shop page working
- ✅ Product configurator
- ✅ Add to cart functionality

---

## 🆘 If Something Goes Wrong

### Error: "Cannot find module"
**Fix:** Make sure all files uploaded. Re-run the deploy script.

### Error: "Database connection failed"
**Fix:** Check DATABASE_URL is correct in environment variables.

### Error: "Application won't start"
**Fix:** 
1. Check Node.js version is 18.x or higher
2. Verify Application startup file: `node_modules/next/dist/bin/next`
3. Check cPanel error logs

### Still Not Working?

**Check Error Logs:**
1. cPanel → **Metrics** → **Errors**
2. Look for recent errors
3. Send me the error message

---

## 📞 Quick Reference

**Project Location:**
```
~/repositories/srmacshop.com/macbook-store
```

**Start/Stop App:**
```
cPanel → Setup Node.js App → Your App → Start/Stop/Restart
```

**View Logs:**
```
cPanel → Setup Node.js App → Your App → Open Application
```

---

## ✅ Checklist

Before your site works, make sure:

- [ ] Script ran successfully
- [ ] PostgreSQL database created
- [ ] Database user created and granted privileges
- [ ] DATABASE_URL updated in .env.production
- [ ] Node.js app created in cPanel
- [ ] Environment variables added
- [ ] Database migrations ran
- [ ] Database seeded with products
- [ ] Application started

---

**That's it! Your MacBook Store will be live at srmacshop.com! 🚀**

**Just follow the steps one by one. I've automated everything else for you!**
