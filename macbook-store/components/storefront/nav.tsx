"use client";

import Link from "next/link";
import { Search, ShoppingBag, User, Moon, Sun } from "lucide-react";
import { useTheme } from "next-themes";
import { Button } from "@/components/ui/button";
import { useCartStore } from "@/lib/cart-store";

export function Nav() {
  const { theme, setTheme } = useTheme();
  const itemCount = useCartStore((state) => state.itemCount());

  return (
    <nav className="sticky top-0 z-50 w-full border-b backdrop-blur-2xl bg-[var(--surface-glass)] border-[var(--border)]">
      <div className="mx-auto max-w-7xl px-6">
        <div className="flex h-14 items-center justify-between">
          {/* Logo */}
          <Link href="/" className="text-xl font-semibold tracking-tight">
        MacBook Store
          </Link>

          {/* Main Navigation */}
       <div className="hidden md:flex items-center gap-8">
            <Link
              href="/shop"
           className="text-sm font-medium hover:text-[var(--accent)] transition-colors"
            >
              Store
            </Link>
         <Link
        href="/shop?category=macbook-pro"
              className="text-sm font-medium hover:text-[var(--accent)] transition-colors"
            >
              MacBook Pro
            </Link>
            <Link
              href="/shop?category=macbook-air"
              className="text-sm font-medium hover:text-[var(--accent)] transition-colors"
            >
              MacBook Air
            </Link>
            <Link
              href="/support"
              className="text-sm font-medium hover:text-[var(--accent)] transition-colors"
          >
              Support
            </Link>
          </div>

      {/* Right Side Icons */}
          <div className="flex items-center gap-4">
            <Button
              variant="ghost"
              size="icon"
           className="h-9 w-9"
          aria-label="Search"
       >
       <Search className="h-5 w-5" />
            </Button>

            <Button
              variant="ghost"
           size="icon"
              className="h-9 w-9 relative"
          aria-label="Shopping cart"
            >
              <ShoppingBag className="h-5 w-5" />
              {itemCount > 0 && (
                <span className="absolute -top-1 -right-1 h-5 w-5 rounded-full bg-[var(--accent)] text-white text-xs flex items-center justify-center">
              {itemCount}
          </span>
           )}
            </Button>

            <Button
              variant="ghost"
            size="icon"
            className="h-9 w-9"
              aria-label="Account"
          >
              <User className="h-5 w-5" />
            </Button>

            <Button
              variant="ghost"
              size="icon"
              className="h-9 w-9"
              onClick={() => setTheme(theme === "dark" ? "light" : "dark")}
         aria-label="Toggle theme"
            >
              <Sun className="h-5 w-5 rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" />
              <Moon className="absolute h-5 w-5 rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" />
            </Button>
          </div>
        </div>
      </div>
    </nav>
  );
}
