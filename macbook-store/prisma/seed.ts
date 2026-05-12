import { PrismaClient } from "@prisma/client";

const prisma = new PrismaClient();

async function main() {
  console.log("Starting seed...");

  // Create categories
  const macbookPro = await prisma.category.upsert({
    where: { slug: "macbook-pro" },
    update: {},
    create: {
      slug: "macbook-pro",
      name: "MacBook Pro",
    },
  });

  const macbookAir = await prisma.category.upsert({
    where: { slug: "macbook-air" },
    update: {},
    create: {
      slug: "macbook-air",
      name: "MacBook Air",
    },
  });

  console.log("Categories created");

  // MacBook Pro 14" M4
  const mbp14 = await prisma.product.upsert({
    where: { slug: "macbook-pro-14-m4" },
    update: {},
    create: {
      slug: "macbook-pro-14-m4",
      name: "MacBook Pro 14\"",
      tagline: "Mind-blowing. Head-turning.",
      description:
        "The most advanced MacBook Pro ever. Supercharged by M4 chip with up to 14-core CPU and 20-core GPU. Up to 24 hours of battery life. Liquid Retina XDR display.",
      basePrice: 199900,
      categoryId: macbookPro.id,
      featured: true,
      inStock: true,
      images: {
        create: [
          {
            url: "https://picsum.photos/seed/mbp14-1/800/600",
            alt: "MacBook Pro 14 inch front view",
            order: 0,
          },
          {
          url: "https://picsum.photos/seed/mbp14-2/800/600",
            alt: "MacBook Pro 14 inch side view",
          order: 1,
          },
        ],
    },
      variants: {
        create: [
          {
            chip: "M4",
            ram: 16,
            storage: 512,
       color: "Space Black",
            priceDelta: 0,
            sku: "MBP14-M4-16-512-SB",
            stock: 10,
     },
        {
         chip: "M4",
            ram: 16,
            storage: 1024,
            color: "Space Black",
            priceDelta: 20000,
            sku: "MBP14-M4-16-1024-SB",
            stock: 8,
      },
          {
            chip: "M4",
            ram: 24,
            storage: 1024,
            color: "Space Black",
       priceDelta: 40000,
            sku: "MBP14-M4-24-1024-SB",
            stock: 5,
          },
          {
         chip: "M4",
            ram: 16,
            storage: 512,
         color: "Silver",
            priceDelta: 0,
         sku: "MBP14-M4-16-512-SV",
         stock: 12,
          },
        ],
      },
  });

  // MacBook Pro 16" M4 Pro
  const mbp16 = await prisma.product.upsert({
    where: { slug: "macbook-pro-16-m4-pro" },
    update: {},
    create: {
      slug: "macbook-pro-16-m4-pro",
      name: "MacBook Pro 16\"",
      tagline: "Mover. Maker. Boundary breaker.",
      description:
        "The ultimate pro notebook. M4 Pro chip with up to 16-core CPU and 40-core GPU. Up to 48GB unified memory. Stunning 16-inch Liquid Retina XDR display.",
      basePrice: 249900,
      categoryId: macbookPro.id,
      featured: true,
      inStock: true,
      images: {
        create: [
          {
            url: "https://picsum.photos/seed/mbp16-1/800/600",
            alt: "MacBook Pro 16 inch front view",
            order: 0,
          },
          {
            url: "https://picsum.photos/seed/mbp16-2/800/600",
            alt: "MacBook Pro 16 inch side view",
            order: 1,
          },
        ],
      },
      variants: {
        create: [
          {
            chip: "M4 Pro",
            ram: 24,
            storage: 512,
            color: "Space Black",
            priceDelta: 0,
            sku: "MBP16-M4PRO-24-512-SB",
            stock: 7,
          },
          {
            chip: "M4 Pro",
          ram: 36,
         storage: 1024,
         color: "Space Black",
            priceDelta: 40000,
            sku: "MBP16-M4PRO-36-1024-SB",
            stock: 4,
          },
          {
            chip: "M4 Max",
          ram: 48,
            storage: 2048,
         color: "Space Black",
            priceDelta: 100000,
     sku: "MBP16-M4MAX-48-2048-SB",
      stock: 2,
          },
        ],
      },
    },
  });

  // MacBook Air 13" M4
  const mba13 = await prisma.product.upsert({
    where: { slug: "macbook-air-13-m4" },
    update: {},
    create: {
      slug: "macbook-air-13-m4",
      name: "MacBook Air 13\"",
      tagline: "Lean. Mean. M4 machine.",
    description:
        "Superlight and supercharged. M4 chip delivers incredible performance. Up to 18 hours of battery life. Stunning Liquid Retina display.",
      basePrice: 119900,
      categoryId: macbookAir.id,
      featured: true,
      inStock: true,
      images: {
        create: [
        {
         url: "https://picsum.photos/seed/mba13-1/800/600",
            alt: "MacBook Air 13 inch front view",
            order: 0,
          },
          {
          url: "https://picsum.photos/seed/mba13-2/800/600",
          alt: "MacBook Air 13 inch side view",
        order: 1,
          },
        ],
      },
      variants: {
        create: [
          {
            chip: "M4",
            ram: 8,
          storage: 256,
         color: "Midnight",
       priceDelta: 0,
          sku: "MBA13-M4-8-256-MN",
          stock: 15,
       },
          {
            chip: "M4",
            ram: 16,
        storage: 512,
        color: "Midnight",
            priceDelta: 20000,
            sku: "MBA13-M4-16-512-MN",
            stock: 12,
          },
          {
         chip: "M4",
            ram: 16,
         storage: 512,
            color: "Starlight",
            priceDelta: 20000,
          sku: "MBA13-M4-16-512-SL",
            stock: 10,
          },
        ],
    },
    },
  });

  // MacBook Air 15" M4
  const mba15 = await prisma.product.upsert({
    where: { slug: "macbook-air-15-m4" },
    update: {},
    create: {
      slug: "macbook-air-15-m4",
      name: "MacBook Air 15\"",
      tagline: "Impressively big. Impossibly thin.",
      description:
        "The spacious 15-inch Liquid Retina display. M4 chip for incredible performance. All-day battery life. Remarkably thin and light design.",
      basePrice: 139900,
      categoryId: macbookAir.id,
      featured: false,
      inStock: true,
      images: {
        create: [
          {
            url: "https://picsum.photos/seed/mba15-1/800/600",
            alt: "MacBook Air 15 inch front view",
            order: 0,
          },
          {
            url: "https://picsum.photos/seed/mba15-2/800/600",
            alt: "MacBook Air 15 inch side view",
            order: 1,
          },
        ],
      },
      variants: {
    create: [
          {
            chip: "M4",
            ram: 8,
            storage: 256,
            color: "Midnight",
            priceDelta: 0,
            sku: "MBA15-M4-8-256-MN",
            stock: 8,
          },
          {
            chip: "M4",
          ram: 16,
            storage: 512,
       color: "Midnight",
            priceDelta: 20000,
            sku: "MBA15-M4-16-512-MN",
            stock: 6,
          },
          {
            chip: "M4",
            ram: 24,
            storage: 1024,
            color: "Space Gray",
          priceDelta: 40000,
          sku: "MBA15-M4-24-1024-SG",
            stock: 3,
          },
        ],
      },
    },
  });

  console.log("Products created:", { mbp14, mbp16, mba13, mba15 });
  console.log("Seed completed successfully!");
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
