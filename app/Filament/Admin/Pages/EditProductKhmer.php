<?php

namespace App\Filament\Admin\Pages;

use App\Models\Category;
use App\Models\Product;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EditProductKhmer extends Page
{
    use WithFileUploads;

    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Edit Product';
    protected static string $view = 'filament.admin.pages.edit-product-khmer';

    public static function getRoutePath(): string
    {
        return '/edit-product/{record}';
    }

    public Product $record;

    public ?int $category_id = null;

    /** @var array<\Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $photos = [];

    /** @var array<int,int> Existing media IDs the admin wants to keep */
    public array $existing_media_ids = [];

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:64')]
    public string $brand = 'Apple';

    #[Validate('required|in:new,used')]
    public string $condition = 'new';

    public string $screen_size = '';
    public string $storage = '';
    public string $ram = '';
    public string $cpu = '';
    public string $vga = '';

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

    // Top MacBooks homepage pick (optional, only meaningful for MacBook products)
    public bool $is_top_pick = false;
    public ?string $top_label_en = null;
    public ?string $top_label_km = null;
    public ?string $top_label_zh = null;

    public function mount(Product $record): void
    {
        $this->record = $record->load('media', 'category');

        $top = \App\Models\TopMacbook::where('product_id', $this->record->id)->first();
        $this->is_top_pick   = (bool) $top;
        $this->top_label_en  = $top?->label_en;
        $this->top_label_km  = $top?->label_km;
        $this->top_label_zh  = $top?->label_zh;

        $this->category_id = $this->record->category_id;
        $this->name = $this->record->name;
        $this->price = $this->record->price / 100;
        $this->stock = $this->record->stock ?? 1;
        $this->badge = $this->record->badge;
        $this->description = $this->record->description ?? '';
        $this->warranty = $this->record->warranty ?? '2 Year Apple Official';

        $this->original_price = $this->record->original_price ? $this->record->original_price / 100 : null;
        $this->sale_ends_at = $this->record->sale_ends_at?->format('Y-m-d\TH:i');
        $this->is_flash_deal = (bool) $this->record->is_flash_deal;

        $this->existing_media_ids = $this->record->getMedia('gallery')->pluck('id')->all();

        $this->parseSpec($this->record->spec ?? '');
    }

    /**
     * Best-effort parser: spec was concatenated in this order:
     * cpu · ram+" RAM" · storage · screen_size · vga(optional, !=Integrated)
     */
    protected function parseSpec(string $spec): void
    {
        if ($spec === '') return;

        $parts = array_map('trim', preg_split('/\s*·\s*/', $spec) ?: []);

        foreach ($parts as $part) {
            if (in_array($part, $this->cpuOptions ?? $this->getCpuOptionsProperty(), true)) {
                $this->cpu = $part;
            } elseif (str_ends_with($part, ' RAM')) {
                $ram = trim(substr($part, 0, -4));
                if (in_array($ram, $this->getRamOptionsProperty(), true)) {
                    $this->ram = $ram;
                }
            } elseif (in_array($part, $this->getStorageOptionsProperty(), true)) {
                $this->storage = $part;
            } elseif (in_array($part, $this->getScreenSizesProperty(), true)) {
                $this->screen_size = $part;
            } elseif (in_array($part, $this->getVgaOptionsProperty(), true)) {
                $this->vga = $part;
            }
        }
    }

    public function getCategoriesProperty()
    {
        return Category::orderBy('name')->get();
    }

    public function getIsMacbookProperty(): bool
    {
        $cat = $this->category_id ? Category::find($this->category_id) : null;

        return $cat !== null && in_array($cat->slug, ['macbook-air', 'macbook-pro'], true);
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

    public function removeExistingMedia(int $id): void
    {
        $this->existing_media_ids = array_values(array_filter($this->existing_media_ids, fn ($x) => $x !== $id));
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

    public function submit(): void
    {
        $this->validate([
            'photos.*' => 'image|max:8192',
            'cpu' => 'required|string',
            'ram' => 'required|string',
            'storage' => 'required|string',
            'screen_size' => 'required|string',
        ]);
        $this->validate();

        $totalPhotos = count($this->existing_media_ids) + count($this->photos);
        if ($totalPhotos === 0) {
            $this->addError('photos', 'Please keep or upload at least one photo.');
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

        if ($this->name !== $this->record->name) {
            $slug = Str::slug($this->name);
            $base = $slug;
            $i = 2;
            while (Product::where('slug', $slug)->where('id', '!=', $this->record->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $this->record->slug = $slug;
        }

        // Resolve original_price for strike-through.
        $originalPriceCents = null;
        if ($this->original_price && $this->original_price > 0) {
            $originalPriceCents = (int) round($this->original_price * 100);
        } elseif ($this->discount && $this->discount > 0) {
            $originalPriceCents = (int) round(((float) $this->price) * 100);
        }
        if ($originalPriceCents !== null && $originalPriceCents <= $finalPrice) {
            $originalPriceCents = null;
        }

        $this->record->update([
            'name'          => $this->name,
            'slug'          => $this->record->slug,
            'spec'          => $spec,
            'price'         => $finalPrice,
            'original_price'=> $originalPriceCents,
            'sale_ends_at'  => $this->sale_ends_at ?: null,
            'is_flash_deal' => $this->is_flash_deal,
            'category_id'   => $this->category_id,
            'stock'         => $this->stock,
            'badge'         => $this->badge,
            'description'   => $this->description,
            'warranty'      => $this->warranty,
        ]);

        // Top MacBooks homepage pick — create/update when ticked (macbook only), else remove.
        if ($this->is_top_pick && $this->is_macbook) {
            \App\Models\TopMacbook::updateOrCreate(
                ['product_id' => $this->record->id],
                [
                    'label_en'  => $this->top_label_en ?: null,
                    'label_km'  => $this->top_label_km ?: null,
                    'label_zh'  => $this->top_label_zh ?: null,
                    'is_active' => true,
                ]
            );
        } else {
            \App\Models\TopMacbook::where('product_id', $this->record->id)->delete();
        }

        // Remove media the admin deleted
        $currentMediaIds = $this->record->getMedia('gallery')->pluck('id')->all();
        $toDelete = array_diff($currentMediaIds, $this->existing_media_ids);
        if (! empty($toDelete)) {
            Media::whereIn('id', $toDelete)->delete();
        }

        // Attach new uploads
        foreach ($this->photos as $photo) {
            $this->record->addMedia($photo->getRealPath())
                ->usingFileName($photo->getClientOriginalName())
                ->toMediaCollection('gallery');
        }

        Notification::make()
            ->title('Product updated')
            ->body($this->record->name . ' has been saved.')
            ->success()
            ->send();

        $this->photos = [];
        $this->record->refresh();
        $this->existing_media_ids = $this->record->getMedia('gallery')->pluck('id')->all();
    }
}
