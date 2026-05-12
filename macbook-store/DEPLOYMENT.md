# Deployment Guide

This guide will help you deploy the MacBook Store to production using Vercel and Neon PostgreSQL.

## Prerequisites

- GitHub account (code already pushed)
- Vercel account (free tier available)
- Neon account for PostgreSQL (free tier available)
- Google OAuth credentials (for authentication)
- Stripe account (for payments)

## Step 1: Set Up Database (Neon)

1. Go to [Neon](https://neon.tech) and sign up/login
2. Create a new project called "macbook-store"
3. Copy the connection string (it looks like: `postgresql://user:password@ep-xxx.region.aws.neon.tech/neondb`)
4. Save this for later

## Step 2: Set Up Google OAuth

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing
3. Enable Google+ API
4. Go to "Credentials" → "Create Credentials" → "OAuth 2.0 Client ID"
5. Application type: Web application
6. Authorized redirect URIs:
   - `http://localhost:3000/api/auth/callback/google` (for local testing)
   - `https://yourdomain.vercel.app/api/auth/callback/google` (for production)
7. Copy Client ID and Client Secret

## Step 3: Set Up Stripe

1. Go to [Stripe Dashboard](https://dashboard.stripe.com/)
2. Get your API keys from Developers → API keys
3. Copy:
   - Publishable key (starts with `pk_test_`)
   - Secret key (starts with `sk_test_`)
4. Set up webhook (we'll do this after deployment)

## Step 4: Deploy to Vercel
1. Go to [Vercel](https://vercel.com) and sign in with GitHub
2. Click "Add New Project"
3. Import your repository: `longsiyeaninfo-sudo/srmacshop.com`
4. Configure project:
   - **Framework Preset:** Next.js
   - **Root Directory:** `macbook-store`
   - **Build Command:** `prisma generate && prisma migrate deploy && next build`
   - **Install Command:** `npm install`

5. Add Environment Variables:

```env
# Database
DATABASE_URL=postgresql://user:password@ep-xxx.region.aws.neon.tech/neondb

# Auth
AUTH_SECRET=P16M8M9jzw1ZSpRN5NBolHoAlBQNRqwlVcVGzWHQZ1E=
AUTH_GOOGLE_ID=your-google-client-id.apps.googleusercontent.com
AUTH_GOOGLE_SECRET=your-google-client-secret
NEXTAUTH_URL=https://yourdomain.vercel.app

# Stripe
STRIPE_SECRET_KEY=sk_test_your_stripe_secret_key
NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY=pk_test_your_stripe_publishable_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret

# Email (Resend) - Optional for now
RESEND_API_KEY=
EMAIL_FROM=orders@yourdomain.com

# App
NEXT_PUBLIC_APP_URL=https://yourdomain.vercel.app
```

6. Click "Deploy"

## Step 5: Run Database Migrations

After first deployment:

1. Go to Vercel Dashboard → Your Project → Settings → Environment Variables
2. Make sure DATABASE_URL is set
3. Go to Deployments → Latest Deployment → View Function Logs
4. Or run locally:
```bash
# Set DATABASE_URL to production database
export DATABASE_URL="postgresql://..."
npx prisma migrate deploy
npm run db:seed
```

## Step 6: Configure Stripe Webhook

1. Go to Stripe Dashboard → Developers → Webhooks
2. Click "Add endpoint"
3. Endpoint URL: `https://yourdomain.vercel.app/api/webhooks/stripe`
4. Select events:
   - `checkout.session.completed`
   - `payment_intent.payment_failed`
5. Copy the webhook signing secret
6. Add it to Vercel environment variables as `STRIPE_WEBHOOK_SECRET`
7. Redeploy

## Step 7: Create Admin User

1. Sign in to your deployed site with Google
2. Connect to your Neon database using a SQL client or Neon's SQL Editor
3. Run this query to make yourself an admin:
```sql
UPDATE "User" 
SET role = 'ADMIN' 
WHERE email = 'your-email@gmail.com';
```

## Step 8: Add Custom Domain (Optional)

1. Go to Vercel Dashboard → Your Project → Settings → Domains
2. Add your custom domain (e.g., `srmacshop.com`)
3. Follow DNS configuration instructions
4. Update environment variables:
   - `NEXTAUTH_URL` → `https://srmacshop.com`
   - `NEXT_PUBLIC_APP_URL` → `https://srmacshop.com`
5. Update Google OAuth redirect URIs
6. Update Stripe webhook URL

## Step 9: Switch to Production Mode

When ready for real payments:

1. In Stripe Dashboard, toggle to "Live mode"
2. Get live API keys (start with `pk_live_` and `sk_live_`)
3. Update Vercel environment variables with live keys
4. Create new webhook for production
5. Redeploy

## Troubleshooting

### Database Connection Issues
- Make sure DATABASE_URL is correctly formatted
- Check Neon project is not paused (free tier pauses after inactivity)
- Verify IP allowlist in Neon (should allow all IPs for Vercel)

### OAuth Issues
- Verify redirect URIs match exactly (including https://)
- Check AUTH_SECRET is set
- Make sure NEXTAUTH_URL matches your domain

### Build Failures
- Check build logs in Vercel
- Ensure `prisma generate` runs before build
- Verify all environment variables are set
### Stripe Webhook Not Working
- Test webhook in Stripe Dashboard
- Check webhook signing secret matches
- Verify endpoint URL is correct
- Check function logs in Vercel

## Monitoring

- **Vercel Analytics:** Automatically enabled
- **Error Tracking:** Check Vercel Function Logs
- **Database:** Monitor in Neon Dashboard
- **Payments:** Track in Stripe Dashboard

## Backup

- **Database:** Neon provides automatic backups
- **Code:** Backed up on GitHub
- **Environment Variables:** Document separately (securely)

## Support

For issues:
1. Check Vercel deployment logs
2. Check Neon database status
3. Verify all environment variables
4. Test locally with production DATABASE_URL

---

**Your store is now live! 🎉**

Visit your deployment URL to see it in action.
