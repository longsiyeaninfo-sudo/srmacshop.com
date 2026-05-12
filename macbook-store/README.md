# MacBook Store

A premium e-commerce store for MacBooks with Apple-style design, built with Next.js 15, TypeScript, and Tailwind CSS.

## Features

- 🎨 macOS-inspired design with frosted-glass effects
- 🛍️ Product catalog with filtering by category
- ⚙️ Apple-style product configurator (chip, RAM, storage, color)
- 🛒 Shopping cart with localStorage persistence
- 🔐 Authentication with Auth.js (Google OAuth)
- 💳 Stripe checkout integration (ready to configure)
- 📱 Fully responsive design
- 🌓 Dark/light mode support

## Tech Stack

- **Framework:** Next.js 15 (App Router)
- **Language:** TypeScript
- **Styling:** Tailwind CSS v4
- **UI Components:** shadcn/ui + Radix UI
- **Database:** PostgreSQL with Prisma ORM
- **Authentication:** Auth.js v5
- **State Management:** Zustand
- **Payments:** Stripe
- **Deployment:** Vercel

## Getting Started

### Prerequisites

- Node.js 18+ 
- PostgreSQL database (or use Neon/Supabase free tier)
- Google OAuth credentials (optional, for authentication)
- Stripe account (optional, for payments)

### Installation

1. Clone the repository:
```bash
git clone <your-repo-url>
cd macbook-store
```

2. Install dependencies:
```bash
npm install
```

3. Set up environment variables:
Create a `.env.local` file with:
```env
# Database
DATABASE_URL="postgresql://user:password@localhost:5432/macbook_store"

# Auth
AUTH_SECRET="your-secret-here"
AUTH_GOOGLE_ID="your-google-client-id"
AUTH_GOOGLE_SECRET="your-google-client-secret"
NEXTAUTH_URL="http://localhost:3000"

# Stripe
STRIPE_SECRET_KEY="sk_test_..."
STRIPE_PUBLISHABLE_KEY="pk_test_..."
STRIPE_WEBHOOK_SECRET="whsec_..."

# App
NEXT_PUBLIC_APP_URL="http://localhost:3000"
```

4. Set up the database:
```bash
# Run migrations
npx prisma migrate dev --name init

# Seed with sample MacBook products
npm run db:seed
```

5. Start the development server:
```bash
npm run dev
```

Visit [http://localhost:3000](http://localhost:3000) to see the store.

## Deployment to Vercel

1. Push your code to GitHub

2. Import the project in Vercel

3. Set up a PostgreSQL database (recommended: Neon)

4. Add environment variables in Vercel dashboard

5. Deploy!

### Database Setup

For production, use [Neon](https://neon.tech) (free tier available):
```bash
# Create database
npx create-db

# Run migrations
npx prisma migrate deploy

# Seed products
npm run db:seed
```

### Stripe Webhook

Configure webhook endpoint in Stripe dashboard:
```
https://yourdomain.com/api/webhooks/stripe
```

Events to listen for:
- `checkout.session.completed`
- `payment_intent.payment_failed`

## Project Structure

```
macbook-store/
├── app/
│   ├── (storefront)/          # Public pages
│   │   ├── shop/              # Product listing & detail
│   │   └── page.tsx           # Homepage
│   ├── api/                 # API routes
│   │   └── auth/          # Auth.js routes
│   ├── layout.tsx          # Root layout
│   └── globals.css            # Global styles
├── components/
│   ├── storefront/            # Storefront components
│   │   ├── nav.tsx            # Navigation
│   │   ├── footer.tsx         # Footer
│   │   └── product-configurator.tsx
│   └── ui/               # shadcn components
├── lib/
│   ├── prisma.ts         # Prisma client
│   ├── auth.ts              # Auth.js config
│   └── cart-store.ts        # Zustand cart store
├── prisma/
│   ├── schema.prisma          # Database schema
│   └── seed.ts              # Seed script
└── middleware.ts              # Route protection
```

## Roadmap

- [ ] Complete checkout flow with Stripe
- [ ] Admin dashboard for product management
- [ ] Customer account pages (orders, wishlist, addresses)
- [ ] Order confirmation emails
- [ ] Product search
- [ ] Product reviews
- [ ] Wishlist functionality

## License

MIT

## Credits

Built with [Claude Code](https://claude.ai/code)
