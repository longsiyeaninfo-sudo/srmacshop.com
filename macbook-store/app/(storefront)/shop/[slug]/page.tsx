import { notFound } from "next/navigation";
import { Nav } from "@/components/storefront/nav";
import { Footer } from "@/components/storefront/footer";
import { prisma } from "@/lib/prisma";
import { ProductConfigurator } from "@/components/storefront/product-configurator";

export default async function ProductPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;

  const product = await prisma.product.findUnique({
    where: { slug },
    include: {
      category: true,
      images: {
        orderBy: { order: "asc" },
      },
      variants: {
        orderBy: { priceDelta: "asc" },
      },
    },
  });

  if (!product) {
    notFound();
  }

  return (
    <>
      <Nav />
      <main className="min-h-screen py-12 md:py-24">
        <div className="mx-auto max-w-7xl px-6">
          {/* Hero */}
        <div className="text-center mb-16">
        <h1 className="text-5xl md:text-7xl font-bold tracking-tight mb-4">
              {product.name}
        </h1>
            <p className="text-2xl md:text-3xl text-[var(--muted)]">
            {product.tagline}
         </p>
          </div>

          {/* Product Grid */}
          <div className="grid lg:grid-cols-2 gap-12">
            {/* Image Gallery */}
            <div className="space-y-4">
              {product.images.map((image) => (
                <div
               key={image.id}
              className="aspect-[4/3] bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-900 rounded-3xl overflow-hidden"
                >
                  <img
            src={image.url}
                    alt={image.alt}
                  className="w-full h-full object-cover"
               />
                </div>
        ))}
            </div>

            {/* Configurator */}
            <div className="lg:sticky lg:top-24 h-fit">
              <div className="rounded-3xl bg-[var(--surface)] border border-[var(--border)] p-8">
                <ProductConfigurator
         basePrice={product.basePrice}
              variants={product.variants}
                  productName={product.name}
                  productImage={product.images[0]?.url}
                />
              </div>
            </div>
        </div>

          {/* Description */}
          <section className="mt-24 max-w-4xl mx-auto">
            <h2 className="text-3xl font-bold mb-6">Overview</h2>
            <p className="text-lg text-[var(--muted)] leading-relaxed">
              {product.description}
        </p>
        </section>

          {/* Specs */}
          <section className="mt-24 max-w-4xl mx-auto">
            <h2 className="text-3xl font-bold mb-8">Tech Specs</h2>
            <div className="rounded-3xl bg-[var(--surface)] border border-[var(--border)] divide-y divide-[var(--border)]">
            <div className="p-6 grid md:grid-cols-2 gap-4">
         <div className="font-semibold">Display</div>
                <div className="text-[var(--muted)]">
                  Liquid Retina XDR display
             </div>
           </div>
            <div className="p-6 grid md:grid-cols-2 gap-4">
                <div className="font-semibold">Chip</div>
                <div className="text-[var(--muted)]">
                  Apple M4 chip
                </div>
              </div>
              <div className="p-6 grid md:grid-cols-2 gap-4">
                <div className="font-semibold">Battery Life</div>
              <div className="text-[var(--muted)]">
          Up to 24 hours
                </div>
              </div>
           <div className="p-6 grid md:grid-cols-2 gap-4">
                <div className="font-semibold">Weight</div>
           <div className="text-[var(--muted)]">
               Starting at 3.4 pounds
                </div>
              </div>
            </div>
          </section>
        </div>
      </main>
      <Footer />
    </>
  );
}
