<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $air = Category::where('slug', 'macbook-air')->first();
        $pro = Category::where('slug', 'macbook-pro')->first();
        $acc = Category::where('slug', 'accessories')->first();
        $prot = Category::where('slug', 'protection')->first();

        $photos = [
            'https://images.khmer24.co/26-03-31/s--ud83d-udc90-ud83d-udc4cmac-book-m2-16-quot-2023-ram-16gb-storage-512gb-102660177492325590717838-b.jpg',
            'https://images.khmer24.co/26-02-13/s--ud83d-udc90-ud83d-udc4cmac-book-m2-16-quot-2023-ram-16gb-storage-512gb-102660177098193261051870-f.jpg',
            'https://images.khmer24.co/26-02-13/s--ud83d-udc90-ud83d-udc4cmac-book-m2-16-quot-2023-ram-16gb-storage-512gb-102660177098193225414628-g.jpg',
            'https://images.khmer24.co/26-02-13/s--ud83d-udc90-ud83d-udc4cmac-book-m2-16-quot-2023-ram-16gb-storage-512gb-102660177098193262980888-h.jpg',
            'https://images.khmer24.co/26-02-14/s--ud83d-udc90-ud83d-udc4cmac-book-m2-16-quot-2023-ram-16gb-storage-512gb-102660177105345834798179-i.jpg',
            'https://images.khmer24.co/26-03-31/s--ud83d-udc90-ud83d-udc4cmac-book-m2-16-quot-2023-ram-16gb-storage-512gb-102660177492325574013397-g.jpg',
            'https://images.khmer24.co/26-03-31/s--ud83d-udc90-ud83d-udc4cmac-book-m2-16-quot-2023-ram-16gb-storage-512gb-102660177492325535819960-h.jpg',
            'https://images.khmer24.co/26-03-31/s--ud83d-udc90-ud83d-udc4cmac-book-m2-16-quot-2023-ram-16gb-storage-512gb-102660177492325646063651-i.jpg',
        ];

        $products = [
            [
                'name' => 'MacBook Air 13"',
                'spec' => 'M3 · 8-Core CPU · 8GB RAM · 256GB SSD',
                'price' => 109900,
                'emoji' => '💻',
                'category_id' => $air?->id,
                'stock' => 8,
                'badge' => 'new',
                'description' => "Brand new sealed MacBook Air M3.\nM3 chip, 8GB RAM, 256GB SSD.\n13.6\" Liquid Retina display with True Tone.\nMagic Keyboard with Touch ID.\n18-hour battery life.\nMagSafe 3 charging port.\nOfficial 2-year Apple warranty.\nFree setup & data transfer service.\nSame-day delivery in Phnom Penh.",
                'warranty' => '2 Year Apple Official',
                'color' => 'Midnight / Starlight / Space Gray / Sky Blue',
                'weight' => '1.24 kg',
                'is_active' => true,
                'sort_order' => 1,
                'photos' => array_slice($photos, 0, 8),
            ],
            [
                'name' => 'MacBook Air 13"',
                'spec' => 'M3 · 8-Core CPU · 16GB RAM · 512GB SSD',
                'price' => 129900,
                'emoji' => '💻',
                'category_id' => $air?->id,
                'stock' => 6,
                'badge' => '',
                'description' => "MacBook Air M3 with 16GB RAM for power users.\nHandles heavy multitasking, Photoshop, video editing.\n13.6\" Liquid Retina display.\nMagSafe 3 + 2x Thunderbolt 4 ports.\nWi-Fi 6E, Bluetooth 5.3.\nOfficial Apple 2-year warranty.\nFree screen protector included.",
                'warranty' => '2 Year Apple Official',
                'color' => 'Midnight / Starlight / Space Gray / Sky Blue',
                'weight' => '1.24 kg',
                'is_active' => true,
                'sort_order' => 2,
                'photos' => array_slice($photos, 0, 3),
            ],
            [
                'name' => 'MacBook Air 15"',
                'spec' => 'M3 · 8-Core CPU · 16GB RAM · 512GB SSD',
                'price' => 149900,
                'emoji' => '💻',
                'category_id' => $air?->id,
                'stock' => 4,
                'badge' => 'hot',
                'description' => "Biggest MacBook Air ever — 15.3\" Liquid Retina display.\nM3 chip, 16GB unified memory, 512GB SSD.\nPerfect for presentations, creative work, entertainment.\n18-hour battery. Fanless design — completely silent.\n6-speaker sound system with Spatial Audio.\nOfficial Apple warranty. Free delivery Phnom Penh.",
                'warranty' => '2 Year Apple Official',
                'color' => 'Midnight / Starlight / Space Gray / Sky Blue',
                'weight' => '1.51 kg',
                'is_active' => true,
                'sort_order' => 3,
                'photos' => array_slice($photos, 0, 4),
            ],
            [
                'name' => 'MacBook Air 13"',
                'spec' => 'M4 · 10-Core CPU · 16GB RAM · 256GB SSD',
                'price' => 109900,
                'emoji' => '💻',
                'category_id' => $air?->id,
                'stock' => 10,
                'badge' => 'new',
                'description' => "All-new MacBook Air with M4 chip — 2025 model.\n10-core CPU, 10-core GPU. Up to 32GB RAM available.\nAvailable in stunning Sky Blue color (new!).\nCenter Stage camera for video calls.\nMagSafe 3 charging. Wi-Fi 6E.\n18-hour battery life.\n2-year official Apple warranty.",
                'warranty' => '2 Year Apple Official',
                'color' => 'Sky Blue / Starlight / Midnight / Space Gray',
                'weight' => '1.24 kg',
                'is_active' => true,
                'sort_order' => 4,
                'photos' => array_slice($photos, 0, 3),
            ],
            [
                'name' => 'MacBook Pro 14"',
                'spec' => 'M4 · 10-Core CPU · 16GB RAM · 512GB SSD',
                'price' => 155500,
                'emoji' => '🖥️',
                'category_id' => $pro?->id,
                'stock' => 5,
                'badge' => 'new',
                'description' => "MacBook Pro 14\" with M4 chip — 2024 model.\n10-core CPU, 10-core GPU.\n14.2\" Liquid Retina XDR display — ProMotion 120Hz.\nThree Thunderbolt 4 ports + HDMI + SD card.\n1080p FaceTime HD camera.\nAdvanced six-speaker system with Spatial Audio.\nUp to 22 hours battery.\nSpace Black or Silver. 2-year Apple warranty.",
                'warranty' => '2 Year Apple Official',
                'color' => 'Space Black / Silver',
                'weight' => '1.6 kg',
                'is_active' => true,
                'sort_order' => 5,
                'photos' => array_slice($photos, 0, 4),
            ],
            [
                'name' => 'MacBook Pro 14"',
                'spec' => 'M4 Pro · 12-Core CPU · 24GB RAM · 1TB SSD',
                'price' => 194900,
                'emoji' => '🖥️',
                'category_id' => $pro?->id,
                'stock' => 3,
                'badge' => 'hot',
                'description' => "MacBook Pro 14\" M4 Pro — for serious professionals.\n12-core CPU, 20-core GPU, 24GB unified memory.\nProRes hardware acceleration for video editing.\nThunderbolt 5 ports — 120Gbps bandwidth.\n1TB SSD — ultra-fast storage.\nUp to 24 hours battery.\nPerfect for 4K/8K video, 3D, music production.",
                'warranty' => '2 Year Apple Official',
                'color' => 'Space Black / Silver',
                'weight' => '1.6 kg',
                'is_active' => true,
                'sort_order' => 6,
                'photos' => array_slice($photos, 0, 5),
            ],
            [
                'name' => 'MacBook Pro 16"',
                'spec' => 'M4 Pro · 12-Core CPU · 24GB RAM · 1TB SSD',
                'price' => 249900,
                'emoji' => '🖥️',
                'category_id' => $pro?->id,
                'stock' => 3,
                'badge' => '',
                'description' => "MacBook Pro 16\" — the largest Pro display.\n16.2\" Liquid Retina XDR — stunning detail.\nM4 Pro: 12-core CPU, 20-core GPU.\n24GB unified memory, 1TB SSD.\nSix-speaker Dolby Atmos sound system.\nThunderbolt 5, HDMI 2.1, SD card reader.\nUp to 24 hours battery.\n2-year Apple warranty included.",
                'warranty' => '2 Year Apple Official',
                'color' => 'Space Black / Silver',
                'weight' => '2.14 kg',
                'is_active' => true,
                'sort_order' => 7,
                'photos' => array_slice($photos, 0, 3),
            ],
            [
                'name' => 'MacBook Pro 16"',
                'spec' => 'M4 Max · 16-Core CPU · 48GB RAM · 1TB SSD',
                'price' => 314900,
                'emoji' => '🖥️',
                'category_id' => $pro?->id,
                'stock' => 1,
                'badge' => '',
                'description' => "The most powerful MacBook ever made.\nM4 Max: 16-core CPU, 40-core GPU, 48GB RAM.\nFor 8K video editing, complex 3D, ML workloads.\nThree Thunderbolt 5 + HDMI 2.1 + SD card.\n16.2\" Liquid Retina XDR display.\nUp to 24-hour battery.\nThe ultimate professional laptop. Limited stock.",
                'warranty' => '2 Year Apple Official',
                'color' => 'Space Black / Silver',
                'weight' => '2.14 kg',
                'is_active' => true,
                'sort_order' => 8,
                'photos' => array_slice($photos, 0, 2),
            ],
            [
                'name' => 'Magic Mouse',
                'spec' => 'Wireless Multi-Touch · Silver · USB-C',
                'price' => 7900,
                'emoji' => '🖱️',
                'category_id' => $acc?->id,
                'stock' => 15,
                'badge' => '',
                'description' => "Apple Magic Mouse with USB-C charging.\nMulti-Touch surface for gestures.\nPairs instantly with your Mac via Bluetooth.\nRechargeable — 1 month per charge.\nElegant aluminum design.\n1-year Apple warranty.",
                'warranty' => '1 Year Apple',
                'color' => 'Silver / Space Gray',
                'weight' => '99 g',
                'is_active' => true,
                'sort_order' => 9,
                'photos' => [],
            ],
            [
                'name' => 'Magic Keyboard',
                'spec' => 'Touch ID · Numeric Keypad · US English',
                'price' => 12900,
                'emoji' => '⌨️',
                'category_id' => $acc?->id,
                'stock' => 12,
                'badge' => '',
                'description' => "Apple Magic Keyboard with Touch ID and numeric keypad.\nTouch ID for instant secure login and Apple Pay.\nFull-size layout with numpad.\nBluetooth wireless — USB-C charging.\nCompatible with Mac, iPad, iPhone.\n1-year Apple warranty.",
                'warranty' => '1 Year Apple',
                'color' => 'Silver / Space Gray',
                'weight' => '243 g',
                'is_active' => true,
                'sort_order' => 10,
                'photos' => [],
            ],
            [
                'name' => 'USB-C Hub 7-in-1',
                'spec' => '4K HDMI · 100W PD · 3xUSB-A · SD Card',
                'price' => 4500,
                'emoji' => '🔌',
                'category_id' => $acc?->id,
                'stock' => 20,
                'badge' => 'sale',
                'description' => "Expand your MacBook ports instantly.\n7 ports in one compact hub:\n- 4K HDMI output @60Hz\n- 100W Power Delivery passthrough\n- 3x USB-A 3.0 (5Gbps)\n- SD card reader\n- MicroSD card reader\nAluminum build, plug-and-play.\n1-year warranty.",
                'warranty' => '1 Year',
                'color' => 'Space Gray',
                'weight' => '68 g',
                'is_active' => true,
                'sort_order' => 11,
                'photos' => [],
            ],
            [
                'name' => 'MagSafe 3 Charger',
                'spec' => '140W · USB-C · MacBook Pro 14"/16"',
                'price' => 4900,
                'emoji' => '🔋',
                'category_id' => $acc?->id,
                'stock' => 18,
                'badge' => '',
                'description' => "Apple MagSafe 3 charger — 140W for MacBook Pro.\nFast-charge to 50% in just 30 minutes.\nMagnetic snap connector — no fraying.\n2m braided cable included.\nCompatible with MacBook Pro 14\" and 16\" (M3/M4).\n1-year Apple warranty.",
                'warranty' => '1 Year Apple',
                'color' => 'Silver / Midnight',
                'weight' => '212 g',
                'is_active' => true,
                'sort_order' => 12,
                'photos' => [],
            ],
            [
                'name' => 'AppleCare+ for Mac',
                'spec' => '3 Years · Unlimited Repairs · 24/7 Support',
                'price' => 29900,
                'emoji' => '🛡️',
                'category_id' => $prot?->id,
                'stock' => 99,
                'badge' => '',
                'description' => "Extend your MacBook coverage to 3 full years.\nUnlimited accidental damage repairs.\nCovers screen, battery, water damage.\nPriority 24/7 Apple expert support.\nOnsite repair service available.\nTransferable if you sell your Mac.\nPeace of mind — fully covered.",
                'warranty' => '3 Years Full Coverage',
                'color' => '—',
                'weight' => '—',
                'is_active' => true,
                'sort_order' => 13,
                'photos' => [],
            ],
            [
                'name' => 'MacBook Pro 14"',
                'spec' => 'M4 Max · 14-Core CPU · 36GB RAM · 1TB SSD',
                'price' => 314900,
                'emoji' => '🖥️',
                'category_id' => $pro?->id,
                'stock' => 2,
                'badge' => 'hot',
                'description' => "MacBook Pro 14\" with M4 Max chip.\n14-core CPU, 32-core GPU, 36GB unified memory.\nFor architects, film editors, ML researchers.\n14.2\" Liquid Retina XDR — ProMotion 120Hz.\nThunderbolt 5 with 120Gbps bandwidth.\nBest MacBook Pro 14\" ever built.",
                'warranty' => '2 Year Apple Official',
                'color' => 'Space Black / Silver',
                'weight' => '1.6 kg',
                'is_active' => true,
                'sort_order' => 14,
                'photos' => array_slice($photos, 0, 4),
            ],
        ];

        foreach ($products as $data) {
            $photoUrls = $data['photos'] ?? [];
            unset($data['photos']);

            $slug = Str::slug($data['name'] . ' ' . $data['spec']);
            $data['slug'] = $slug;

            $product = Product::updateOrCreate(['slug' => $slug], $data);

            if ($product->wasRecentlyCreated || $product->getMedia('gallery')->isEmpty()) {
                foreach ($photoUrls as $url) {
                    try {
                        $product->addMediaFromUrl($url)
                            ->toMediaCollection('gallery');
                    } catch (\Exception $e) {
                        // Skip if URL is unreachable
                    }
                }
            }
        }
    }
}
