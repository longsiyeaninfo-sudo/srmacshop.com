import Link from "next/link";
import { Nav } from "@/components/storefront/nav";
import { Footer } from "@/components/storefront/footer";
import { prisma } from "@/lib/prisma";
import { Button } from "@/components/ui/button";

export default async function ShopPage({
  searchParams,
}: {
  searchParams: Promise<{ category?: string }>;
}) {
  const params = await searchParams;
  const categorySlug = params.category;

  // Fetch products
  const products = await prisma.product.findMany({
    where: categorySlug
      ? {
        category: {
         slug: categorySlug,
          },
     }
      : undefined,
    include: {
      category: true,
      images: {
        orderBy: { order: "asc" },
        take: 1,
      },
    variants: {
        orderBy: { priceDelta: "asc" },
        take: 1,
      },
    },
    orderBy: {
      createdAt: "desc",
    },
  });

  // Group by category
  const categories = await prisma.category.findMany({
    include: {
      _count: {
        select: { products: true },
      },
    },
  });

  const groupedProducts = categories.map((category) => ({
    category,
  products: products.filter((p) => p.categoryId === category.id),
  }));

  return (
    <>
      <Nav />
      <main className="min-h-screen">
        {/* Hero */}
        <section className="py-16 md:py-24 bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-900 dark:to-black">
          <div className="mx-auto max-w-7xl px-6 text-center">
          <h1 className="text-5xl md:text-6xl font-bold tracking-tight mb-4">
              {categorySlug
         ? categories.find((c) => c.slug === categorySlug)?.name
                : "Shop MacBook"}
            </h1>
            <p className="text-xl text-[var(--muted)] max-w-2xl mx-auto">
      Choose your perfect MacBook. Supercharged by M4.
            </p>
          </div>
        </section>

        {/* Products by Category */}
      {groupedProducts.map(
          ({ category, products: categoryProducts }) =>
            categoryProducts.length > 0 && (
              <section key={category.id} className="py-16 md:py-24">
             <div className="mx-auto max-w-7xl px-6">
              <h2 className="text-4xl md:text-5xl font-bold tracking-tight mb-12">
                    {category.name}
                  </h2>
                  <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
               {categoryProducts.map((product) => {
           const baseVariant = product.variants[0];
                      const startingPrice = product.basePrice + (baseVariant?.priceDelta || 0);
                      const image = product.images[0];

                  return (
                      <Link
                        key={product.id}
                 href={`/shop/${product.slug}`}
                          className="group"
                    >
                       <div className="rounded-3xl bg-[var(--surface)] border border-[var(--border)] p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                 {/* Product Image */}
                     <div className="aspect-[4/3] bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-900 rounded-2xl mb-6 overflow-hidden">
                       {image ? (
                         <img
                         src={image.url}
                         alt={image.alt}
                   className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                       />
                       ) : (
                 <div className="w-full h-full flex items-center justify-center text-6xl">
                         💻
                   </div>
                       )}
                          </div>

                       {/* Product Info */}
                <h3 className="text-2xl font-semibold mb-2">
                            {product.name}
                    </h3>
                        <p className="text-[var(--muted)] mb-4 line-clamp-1">
                           {product.tagline}
                    </p>
                    <p className="text-lg font-semibold">
                  From ${(startingPrice / 100).toLocaleString()}
                         </p>
                       </div>
                    </Link>
             );
                    })}
             </div>
            </div>
              </section>
            )
        )}

        {products.length === 0 && (
      <section className="py-24 text-center">
            <p className="text-xl text-[var(--muted)]">No products found.</p>
          </section>
     )}
      </main>
      <Footer />
    </>
  );
}
