<?php

namespace Tests\Feature;

use App\Filament\Admin\Pages\PostProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PostProductTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    public function test_admin_can_create_product_via_post_product_page(): void
    {
        Storage::fake('public');

        $admin = User::firstOrCreate(['email' => 'admin@srmacshop.com'], [
            'name'     => 'Admin',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($admin);

        $category = Category::firstOrCreate(['slug' => 'macbook-pro'], ['name' => 'MacBook Pro']);

        $photo1 = UploadedFile::fake()->image('photo1.jpg', 800, 800);
        $photo2 = UploadedFile::fake()->image('photo2.jpg', 800, 800);

        Livewire::test(PostProduct::class)
            ->set('category_id', $category->id)
            ->call('nextStep')
            ->assertSet('step', 2)
            ->set('photos', [$photo1, $photo2])
            ->set('name', 'MacBook Pro 14" M4 Pro Test')
            ->set('brand', 'Apple')
            ->set('condition', 'new')
            ->set('screen_size', '14.2"')
            ->set('storage', '512GB SSD')
            ->set('ram', '16GB')
            ->set('cpu', 'Apple M4 Pro')
            ->set('vga', 'Apple GPU')
            ->set('price', 2199)
            ->set('discount', 10)
            ->set('discount_type', '%')
            ->set('description', 'Brand new MacBook Pro with M4 Pro chip.')
            ->set('province', 'Phnom Penh')
            ->set('address', 'Sangkat Kambol, Khan Kambol')
            ->set('contact_name', 'SR MAC SHOP')
            ->set('contact_phone', '+855 98 33 47 55')
            ->set('stock', 5)
            ->set('free_delivery', true)
            ->call('submit')
            ->assertHasNoErrors();

        $product = Product::where('name', 'MacBook Pro 14" M4 Pro Test')->first();
        $this->assertNotNull($product, 'Product should be created');
        $this->assertEquals($category->id, $product->category_id);
        $this->assertEquals(5, $product->stock);
        $this->assertEquals('Apple M4 Pro · 16GB RAM · 512GB SSD · 14.2" · Apple GPU', $product->spec);

        // Price: $2199 * (1 - 0.10) = $1979.10 → 197910 cents
        $this->assertEquals(197910, $product->price);

        $this->assertEquals(2, $product->getMedia('gallery')->count(), 'Two photos should be attached');
    }

    public function test_validation_blocks_submit_without_photos(): void
    {
        $admin = User::firstOrCreate(['email' => 'admin@srmacshop.com'], [
            'name' => 'Admin', 'password' => bcrypt('password'),
        ]);
        $this->actingAs($admin);

        $category = Category::firstOrCreate(['slug' => 'macbook-air'], ['name' => 'MacBook Air']);

        Livewire::test(PostProduct::class)
            ->set('category_id', $category->id)
            ->call('nextStep')
            ->set('name', 'Test Product')
            ->set('screen_size', '13"')
            ->set('storage', '256GB SSD')
            ->set('ram', '8GB')
            ->set('cpu', 'Apple M3')
            ->set('price', 999)
            ->set('description', 'Test description here.')
            ->call('submit')
            ->assertHasErrors(['photos']);

        $this->assertNull(Product::where('name', 'Test Product')->first());
    }

    public function test_step_1_requires_category(): void
    {
        $admin = User::firstOrCreate(['email' => 'admin@srmacshop.com'], [
            'name' => 'Admin', 'password' => bcrypt('password'),
        ]);
        $this->actingAs($admin);

        Livewire::test(PostProduct::class)
            ->set('category_id', null)
            ->call('nextStep')
            ->assertSet('step', 1)
            ->assertHasErrors('category_id');
    }
}
