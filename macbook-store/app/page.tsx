import Link from "next/link";
import { Nav } from "@/components/storefront/nav";
import { Footer } from "@/components/storefront/footer";
import { Button } from "@/components/ui/button";

export default function HomePage() {
  return (
    <>
   <Nav />
      <main>
        {/* Hero Section */}
        <section className="relative bg-black text-white py-24 md:py-32">
          <div className="mx-auto max-w-7xl px-6 text-center">
        <h1 className="text-5xl md:text-7xl lg:text-8xl font-bold tracking-tight mb-6">
              The new MacBook lineup
            </h1>
          <p className="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto">
              Supercharged by the M4 chip. Mind-blowing performance. All-day battery life.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Button
                asChild
           size="lg"
            className="rounded-full px-8 py-6 text-base bg-[#0071e3] hover:bg-[#0077ed]"
          >
            <Link href="/shop">Buy</Link>
              </Button>
          <Button
                asChild
                variant="outline"
           size="lg"
                className="rounded-full px-8 py-6 text-base border-white/20 hover:bg-white/10"
          >
                <Link href="/shop">Learn more</Link>
              </Button>
         </div>
          </div>
        </section>

        {/* Featured Products Preview */}
        <section className="py-24 md:py-32 bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-900 dark:to-black">
          <div className="mx-auto max-w-7xl px-6">
            <h2 className="text-4xl md:text-5xl font-bold tracking-tight text-center mb-16">
          Choose your MacBook
            </h2>
            <div className="grid md:grid-cols-2 gap-8">
              {/* MacBook Pro Card */}
              <div className="group relative rounded-3xl bg-[var(--surface)] border border-[var(--border)] p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
              <div className="aspect-[4/3] bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-900 rounded-2xl mb-6 flex items-center justify-center">
           <div className="text-6xl">💻</div>
                </div>
              <h3 className="text-2xl font-semibold mb-2">MacBook Pro</h3>
                <p className="text-[var(--muted)] mb-4">
                Mind-blowing. Head-turning.
                </p>
                <p className="text-lg font-semibold mb-6">From $1,999</p>
            <Button asChild className="rounded-full w-full">
                  <Link href="/shop?category=macbook-pro">Shop MacBook Pro</Link>
                </Button>
              </div>

           {/* MacBook Air Card */}
              <div className="group relative rounded-3xl bg-[var(--surface)] border border-[var(--border)] p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <div className="aspect-[4/3] bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-950 rounded-2xl mb-6 flex items-center justify-center">
            <div className="text-6xl">💻</div>
                </div>
                <h3 className="text-2xl font-semibold mb-2">MacBook Air</h3>
                <p className="text-[var(--muted)] mb-4">
             Lean. Mean. M4 machine.
                </p>
             <p className="text-lg font-semibold mb-6">From $1,199</p>
                <Button asChild className="rounded-full w-full">
                  <Link href="/shop?category=macbook-air">Shop MacBook Air</Link>
         </Button>
              </div>
          </div>
      </div>
        </section>
      </main>
      <Footer />
    </>
  );
}
