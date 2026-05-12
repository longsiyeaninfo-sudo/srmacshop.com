# 🚀 Quick Start - Deploy in 10 Minutes

The fastest way to get your MacBook Store live!

## Option 1: Deploy via Vercel Dashboard (Recommended)

### Step 1: Deploy to Vercel (2 minutes)

1. Go to [vercel.com](https://vercel.com) and sign in with GitHub
2. Click **"Add New Project"**
3. Import: `longsiyeaninfo-sudo/srmacshop.com`
4. **Root Directory:** `macbook-store`
5. Click **"Deploy"** (it will fail, that's okay!)

### Step 2: Set Up Database (3 minutes)

1. Go to [neon.tech](https://neon.tech) and sign up
2. Create new project: **"macbook-store"**
3. Copy the connection string (looks like: `postgresql://user:pass@ep-xxx.region.aws.neon.tech/neondb`)
4. Go back to Vercel → Your Project → **Settings** → **Environment Variables**
5. Add:
   ```
   DATABASE_URL = your-neon-connection-string
   AUTH_SECRET = P16M8M9jzw1ZSpRN5NBolHoAlBQNRqwlVcVGzWHQZ1E=
   NEXTAUTH_URL = https://your-project.vercel.app
   NEXT_PUBLIC_APP_URL = https://your-project.vercel.app
   ```
6. Go to **Deployments** → Click **"Redeploy"**

### Step 3: Initialize Database (2 minutes)

After deployment succeeds:

1. Install Neon CLI or use their SQL Editor
2. Run migrations:
   ```sql
   -- Copy the SQL from prisma/migrations or use Prisma CLI locally
   ```
3. Or run locally:
   ```bash
   export DATABASE_URL="your-neon-connection-string"
   npx prisma migrate deploy
   npm run db:seed
   ```

### Step 4: Test Your Store (1 minute)

Visit your Vercel URL: `https://your-project.vercel.app`

You should see:
- ✅ Homepage with MacBook products
- ✅ Shop page with 4 products
- ✅ Product detail pages with configurator
- ✅ Add to cart functionality
- ✅ Dark/light mode toggle

**🎉 Your store is live!**

---

## Option 2: Deploy via CLI

```bash
cd macbook-store

# Install Vercel CLI
npm install -g vercel

# Login to Vercel
vercel login

# Deploy
vercel --prod
```

Then follow Steps 2-4 above.

---

## What Works Right Now

✅ **Fully Functional:**
- Product browsing and filtering
- Product configurator (chip, RAM, storage, color)
- Shopping cart (localStorage)
- Responsive design
- Dark/light mode
- macOS-style UI

⚠️ **Needs Configuration:**
- Google OAuth (optional - for user accounts)
- Stripe (optional - for checkout)
- Email (optional - for order confirmations)

---

## Add Authentication (Optional - 5 minutes)

### Google OAuth:

1. Go to [console.cloud.google.com](https://console.cloud.google.com)
2. Create project → Enable Google+ API
3. Create OAuth 2.0 credentials
4. Authorized redirect URI: `https://your-project.vercel.app/api/auth/callback/google`
5. Add to Vercel environment variables:
   ```
   AUTH_GOOGLE_ID = your-client-id.apps.googleusercontent.com
   AUTH_GOOGLE_SECRET = your-client-secret
   ```
6. Redeploy
---

## Add Payments (Optional - 5 minutes)

### Stripe:

1. Go to [dashboard.stripe.com](https://dashboard.stripe.com)
2. Get test API keys from **Developers** → **API keys**
3. Add to Vercel environment variables:
   ```
   STRIPE_SECRET_KEY = sk_test_...
   NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY = pk_test_...
   ```
4. After deployment, set up webhook:
   - URL: `https://your-project.vercel.app/api/webhooks/stripe`
   - Events: `checkout.session.completed`, `payment_intent.payment_failed`
   - Copy webhook secret and add as `STRIPE_WEBHOOK_SECRET`
5. Redeploy

---

## Make Yourself Admin (Optional - 2 minutes)

1. Sign in to your deployed site with Google
2. Go to Neon SQL Editor
3. Run:
   ```sql
   UPDATE "User" 
   SET role = 'ADMIN' 
   WHERE email = 'your-email@gmail.com';
   ```

Now you can access `/admin` routes (when Phase 6 is implemented).

---

## Custom Domain (Optional - 5 minutes)

1. Vercel Dashboard → Your Project → **Settings** → **Domains**
2. Add your domain (e.g., `srmacshop.com`)
3. Follow DNS instructions
4. Update environment variables:
   ```
   NEXTAUTH_URL = https://srmacshop.com
   NEXT_PUBLIC_APP_URL = https://srmacshop.com
   ```
5. Update Google OAuth redirect URIs
6. Update Stripe webhook URL

---

## Troubleshooting

### Build fails with Prisma error
- Make sure `DATABASE_URL` is set in environment variables
- Redeploy after adding variables

### Site loads but no products
- Database needs to be seeded
- Run `npm run db:seed` with production DATABASE_URL

### OAuth doesn't work
- Check redirect URIs match exactly
- Verify `AUTH_SECRET` and `NEXTAUTH_URL` are set

### Need help?
- Check `DEPLOYMENT.md` for detailed guide
- Check Vercel function logs for errors
- Verify all environment variables are set

---

## What's Next?

The core store is working! Optional enhancements:

- [ ] Complete checkout flow (Phase 4)
- [ ] Admin dashboard (Phase 6)
- [ ] Customer accounts (Phase 5)
- [ ] Polish & animations (Phase 7)
- [ ] Real product images
- [ ] SEO optimization
- [ ] Analytics

**Your MacBook Store is live and ready to sell! 🎉**
