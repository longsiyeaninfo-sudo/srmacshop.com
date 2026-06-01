<?php

namespace App\Filament\Admin\Pages;

use App\Models\Category;
use App\Models\Product;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class PostProduct extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationLabel = 'Add Product';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?int $navigationSort = -1;
    protected static ?string $title = 'Add a Product';
    protected static string $view = 'filament.admin.pages.post-product';

    public int $step = 1;

    public ?int $category_id = null;

    /** @var array<\Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $photos = [];

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:64')]
    public string $brand = 'Apple';

    #[Validate('required|in:new,used')]
    public string $condition = 'new';

    #[Validate('required|string')]
    public string $screen_size = '';

    #[Validate('required|string')]
    public string $storage = '';

    #[Validate('required|string')]
    public string $ram = '';

    #[Validate('required|string')]
    public string $cpu = '';

    #[Validate('nullable|string')]
    public string $vga = '';

    #[Validate('nullable|numeric|min:0')]
    public ?float $discount = null;

    #[Validate('required|in:%,$')]
    public string $discount_type = '%';

    #[Validate('required|numeric|min:0.01')]
    public ?float $price = null;

    public bool $free_delivery = false;

    #[Validate('required|string|max:5000')]
    public string $description = '';

    #[Validate('required|string')]
    public string $province = 'Phnom Penh';

    #[Validate('required|string|max:255')]
    public string $address = 'Sangkat Kambol, Khan Kambol';

    public ?float $latitude = 11.5564;
    public ?float $longitude = 104.9282;

    #[Validate('required|string|max:120')]
    public string $contact_name = 'SR MAC SHOP';

    /** @var array<int,string> */
    #[Validate(['contact_phones' => 'required|array|min:1', 'contact_phones.*' => 'required|string|max:32'])]
    public array $contact_phones = ['+855 98 33 47 55'];

    #[Validate('nullable|email|max:255')]
    public string $contact_email = '';

    #[Validate('nullable|integer|min:0')]
    public int $stock = 1;

    #[Validate('nullable|in:new,hot,sale')]
    public ?string $badge = null;

    public string $warranty = '2 Year Apple Official';

    // Sale/promo fields (Phase 1)
    #[Validate('nullable|numeric|min:0')]
    public ?float $original_price = null;

    #[Validate('nullable|date')]
    public ?string $sale_ends_at = null;

    public bool $is_flash_deal = false;

    public function mount(): void
    {
        if ($default = Category::orderBy('name')->first()) {
            $this->category_id = $default->id;
        }
        $this->applyMemory();
    }

    /**
     * Overlay the last-saved product's reusable fields (brand, condition, location,
     * contact + warranty) on top of the hardcoded defaults so repeat entry is faster.
     * Deliberately does NOT remember product-specific fields (name, specs, price,
     * discount, stock, badge, description, sale fields).
     */
    protected function applyMemory(): void
    {
        $mem = session('product_entry_memory');
        if (! is_array($mem)) {
            return;
        }

        if (! empty($mem['category_id'])) {
            $this->category_id = (int) $mem['category_id'];
        }

        foreach (['brand', 'condition', 'discount_type', 'province', 'address', 'contact_name', 'contact_email', 'warranty'] as $key) {
            if (isset($mem[$key]) && $mem[$key] !== null) {
                $this->{$key} = $mem[$key];
            }
        }

        if (array_key_exists('latitude', $mem)) {
            $this->latitude = $mem['latitude'] !== null ? (float) $mem['latitude'] : null;
        }
        if (array_key_exists('longitude', $mem)) {
            $this->longitude = $mem['longitude'] !== null ? (float) $mem['longitude'] : null;
        }

        if (array_key_exists('free_delivery', $mem)) {
            $this->free_delivery = (bool) $mem['free_delivery'];
        }

        if (! empty($mem['contact_phones']) && is_array($mem['contact_phones'])) {
            $phones = array_values(array_filter($mem['contact_phones'], fn ($p) => trim((string) $p) !== ''));
            $this->contact_phones = $phones ?: ['+855 98 33 47 55'];
        }
    }

    public function getCategoriesProperty()
    {
        return Category::orderBy('name')->get();
    }

    public function getBrandsProperty(): array
    {
        return ['Apple', 'Dell', 'HP', 'Lenovo', 'Asus', 'Acer', 'MSI', 'Razer', 'Microsoft', 'Samsung', 'Other'];
    }

    public function getScreenSizesProperty(): array
    {
        return ['11"', '12"', '13"', '13.3"', '13.6"', '14"', '14.2"', '15"', '15.4"', '15.6"', '16"', '16.2"', '17"'];
    }

    public function getStorageOptionsProperty(): array
    {
        return ['128GB SSD', '256GB SSD', '512GB SSD', '1TB SSD', '2TB SSD', '4TB SSD', '8TB SSD'];
    }

    public function getRamOptionsProperty(): array
    {
        return ['4GB', '8GB', '16GB', '24GB', '32GB', '48GB', '64GB', '96GB', '128GB'];
    }

    public function getCpuOptionsProperty(): array
    {
        return [
            'Apple M1', 'Apple M2', 'Apple M3', 'Apple M3 Pro', 'Apple M3 Max',
            'Apple M4', 'Apple M4 Pro', 'Apple M4 Max',
            'Intel Core i3', 'Intel Core i5', 'Intel Core i7', 'Intel Core i9',
            'AMD Ryzen 5', 'AMD Ryzen 7', 'AMD Ryzen 9',
        ];
    }

    public function getVgaOptionsProperty(): array
    {
        return ['Integrated', 'Apple GPU', 'NVIDIA RTX 3050', 'NVIDIA RTX 3060', 'NVIDIA RTX 4050', 'NVIDIA RTX 4060', 'NVIDIA RTX 4070', 'NVIDIA RTX 4080', 'NVIDIA RTX 4090', 'AMD Radeon'];
    }

    public function getProvincesProperty(): array
    {
        return [
            'Phnom Penh', 'Banteay Meanchey', 'Battambang', 'Kampong Cham', 'Kampong Chhnang',
            'Kampong Speu', 'Kampong Thom', 'Kampot', 'Kandal', 'Kep', 'Koh Kong',
            'Kratié', 'Mondulkiri', 'Oddar Meanchey', 'Pailin', 'Preah Sihanouk',
            'Preah Vihear', 'Prey Veng', 'Pursat', 'Ratanakiri', 'Siem Reap',
            'Stung Treng', 'Svay Rieng', 'Takéo', 'Tboung Khmum',
        ];
    }

    public function nextStep(): void
    {
        if (! $this->category_id) {
            $this->addError('category_id', 'Please choose a category.');
            return;
        }
        $this->step = 2;
    }

    public function prevStep(): void
    {
        $this->step = 1;
    }

    public function removePhoto(int $index): void
    {
        if (isset($this->photos[$index])) {
            unset($this->photos[$index]);
            $this->photos = array_values($this->photos);
        }
    }

    public function addPhone(): void
    {
        if (count($this->contact_phones) < 5) {
            $this->contact_phones[] = '';
        }
    }

    public function removePhone(int $index): void
    {
        if (count($this->contact_phones) > 1 && isset($this->contact_phones[$index])) {
            unset($this->contact_phones[$index]);
            $this->contact_phones = array_values($this->contact_phones);
        }
    }

    public function reset_form(): void
    {
        $this->resetExcept(['categories']);
        $this->step = 1;
        $this->brand = 'Apple';
        $this->condition = 'new';
        $this->discount_type = '%';
        $this->province = 'Phnom Penh';
        $this->address = 'Sangkat Kambol, Khan Kambol';
        $this->contact_name = 'SR MAC SHOP';
        $this->contact_phones = ['+855 98 33 47 55'];
        $this->warranty = '2 Year Apple Official';
        $this->stock = 1;
        $this->latitude = 11.5564;
        $this->longitude = 104.9282;
        $this->mount();
    }

    /**
     * Forget the remembered fields and restore the hardcoded system defaults
     * for the reusable fields (without touching product-specific input).
     */
    public function clearMemory(): void
    {
        session()->forget('product_entry_memory');

        $this->category_id   = optional(Category::orderBy('name')->first())->id;
        $this->brand         = 'Apple';
        $this->condition     = 'new';
        $this->discount_type = '%';
        $this->free_delivery = false;
        $this->province      = 'Phnom Penh';
        $this->address       = 'Sangkat Kambol, Khan Kambol';
        $this->latitude      = 11.5564;
        $this->longitude     = 104.9282;
        $this->contact_name  = 'SR MAC SHOP';
        $this->contact_phones = ['+855 98 33 47 55'];
        $this->contact_email = '';
        $this->warranty      = '2 Year Apple Official';

        Notification::make()
            ->title('Reset to blank defaults')
            ->body('Brand, condition, location, contact and warranty are back to the shop defaults.')
            ->success()
            ->send();
    }

    public function submit(): void
    {
        $this->validate([
            'photos.*' => 'image|max:8192',
        ]);
        $this->validate();

        if (count($this->photos) === 0) {
            $this->addError('photos', 'Please upload at least one photo.');
            return;
        }

        $specParts = array_filter([
            $this->cpu,
            $this->ram . ' RAM',
            $this->storage,
            $this->screen_size,
            $this->vga !== '' && $this->vga !== 'Integrated' ? $this->vga : null,
        ]);
        $spec = implode(' · ', $specParts);

        $finalPrice = (int) round(((float) $this->price) * 100);
        if ($this->discount && $this->discount > 0) {
            if ($this->discount_type === '%') {
                $finalPrice = (int) round($finalPrice * (1 - ((float) $this->discount / 100)));
            } else {
                $finalPrice = max(0, $finalPrice - (int) round(((float) $this->discount) * 100));
            }
        }

        $slug = Str::slug($this->name);
        $base = $slug;
        $i = 2;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        $emojiMap = ['Apple' => '💻', 'Dell' => '🖥️', 'HP' => '🖥️', 'Lenovo' => '💻', 'Asus' => '💻'];

        // Resolve original_price for strike-through. Priority:
        // 1) explicit $original_price set by admin
        // 2) auto-derived from $discount > 0 (the pre-discount price the admin typed)
        // 3) null (no sale)
        $originalPriceCents = null;
        if ($this->original_price && $this->original_price > 0) {
            $originalPriceCents = (int) round($this->original_price * 100);
        } elseif ($this->discount && $this->discount > 0) {
            $originalPriceCents = (int) round(((float) $this->price) * 100);
        }
        if ($originalPriceCents !== null && $originalPriceCents <= $finalPrice) {
            $originalPriceCents = null; // not actually on sale
        }

        $product = Product::create([
            'name'          => $this->name,
            'slug'          => $slug,
            'spec'          => $spec,
            'price'         => $finalPrice,
            'original_price'=> $originalPriceCents,
            'sale_ends_at'  => $this->sale_ends_at ?: null,
            'is_flash_deal' => $this->is_flash_deal,
            'emoji'         => $emojiMap[$this->brand] ?? '💻',
            'category_id'   => $this->category_id,
            'stock'         => $this->stock,
            'badge'         => $this->badge,
            'description'   => $this->description,
            'warranty'      => $this->warranty,
            'is_active'     => true,
            'sort_order'    => 0,
        ]);

        foreach ($this->photos as $photo) {
            $product->addMedia($photo->getRealPath())
                ->usingFileName($photo->getClientOriginalName())
                ->toMediaCollection('gallery');
        }

        Notification::make()
            ->title('Product posted successfully')
            ->body($product->name . ' has been added to your catalog.')
            ->success()
            ->send();

        // Remember reusable fields so the next product is mostly pre-filled.
        session()->put('product_entry_memory', [
            'category_id'    => $this->category_id,
            'brand'          => $this->brand,
            'condition'      => $this->condition,
            'discount_type'  => $this->discount_type,
            'free_delivery'  => $this->free_delivery,
            'province'       => $this->province,
            'address'        => $this->address,
            'latitude'       => $this->latitude,
            'longitude'      => $this->longitude,
            'contact_name'   => $this->contact_name,
            'contact_phones' => $this->contact_phones,
            'contact_email'  => $this->contact_email,
            'warranty'       => $this->warranty,
        ]);

        $this->reset_form();

        $this->redirect(\App\Filament\Admin\Pages\EditProductKhmer::getUrl(['record' => $product->id]));
    }

    public static function getNavigationBadge(): ?string
    {
        return null;
    }
}
