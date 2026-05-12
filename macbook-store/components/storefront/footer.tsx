import Link from "next/link";

export function Footer() {
  return (
    <footer className="border-t border-[var(--border)] bg-[var(--surface)] mt-auto">
    <div className="mx-auto max-w-7xl px-6 py-12">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
       {/* Shop */}
          <div>
        <h3 className="font-semibold mb-4">Shop</h3>
          <ul className="space-y-3 text-sm text-[var(--muted)]">
              <li>
                <Link href="/shop" className="hover:text-[var(--foreground)] transition-colors">
                  All Products
                </Link>
           </li>
            <li>
                <Link href="/shop?category=macbook-pro" className="hover:text-[var(--foreground)] transition-colors">
              MacBook Pro
                </Link>
              </li>
              <li>
          <Link href="/shop?category=macbook-air" className="hover:text-[var(--foreground)] transition-colors">
               MacBook Air
                </Link>
              </li>
            </ul>
      </div>

      {/* Account */}
          <div>
      <h3 className="font-semibold mb-4">Account</h3>
            <ul className="space-y-3 text-sm text-[var(--muted)]">
            <li>
                <Link href="/account" className="hover:text-[var(--foreground)] transition-colors">
             My Account
           </Link>
         </li>
          <li>
           <Link href="/account/orders" className="hover:text-[var(--foreground)] transition-colors">
                  Orders
            </Link>
              </li>
              <li>
                <Link href="/account/wishlist" className="hover:text-[var(--foreground)] transition-colors">
              Wishlist
                </Link>
              </li>
            </ul>
          </div>

          {/* Support */}
          <div>
            <h3 className="font-semibold mb-4">Support</h3>
            <ul className="space-y-3 text-sm text-[var(--muted)]">
              <li>
                <Link href="/support" className="hover:text-[var(--foreground)] transition-colors">
                Contact Us
            </Link>
              </li>
              <li>
         <Link href="/support/shipping" className="hover:text-[var(--foreground)] transition-colors">
                  Shipping Info
            </Link>
            </li>
              <li>
             <Link href="/support/returns" className="hover:text-[var(--foreground)] transition-colors">
                  Returns
                </Link>
              </li>
            </ul>
          </div>

          {/* About */}
        <div>
            <h3 className="font-semibold mb-4">About</h3>
            <ul className="space-y-3 text-sm text-[var(--muted)]">
              <li>
       <Link href="/about" className="hover:text-[var(--foreground)] transition-colors">
             Our Story
                </Link>
              </li>
              <li>
                <Link href="/privacy" className="hover:text-[var(--foreground)] transition-colors">
             Privacy Policy
                </Link>
              </li>
              <li>
              <Link href="/terms" className="hover:text-[var(--foreground)] transition-colors">
                  Terms of Service
           </Link>
         </li>
            </ul>
          </div>
        </div>

        <div className="mt-12 pt-8 border-t border-[var(--border)] text-center text-sm text-[var(--muted)]">
          <p>&copy; {new Date().getFullYear()} MacBook Store. All rights reserved.</p>
        </div>
      </div>
    </footer>
  );
}
