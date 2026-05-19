<?php

namespace App\Filament\Admin\Pages;

use App\Models\Category;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class CategoriesPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Categories';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?int $navigationSort = 2;
    protected static ?string $title = 'Categories';
    protected static string $view = 'filament.admin.pages.categories';

    public bool $showCreateModal = false;
    public ?int $editingId = null;

    #[Validate('required|string|max:120')]
    public string $newName = '';

    public ?string $editingName = null;

    public function getCategoriesProperty()
    {
        return Category::ordered()->withCount('products')->get();
    }

    public function openCreate(): void
    {
        $this->newName = '';
        $this->resetErrorBag();
        $this->showCreateModal = true;
    }

    public function closeCreate(): void
    {
        $this->showCreateModal = false;
    }

    public function create(): void
    {
        $this->validate();

        $slug = $this->uniqueSlug($this->newName);
        $maxOrder = (int) Category::max('sort_order');

        Category::create([
            'name'       => $this->newName,
            'slug'       => $slug,
            'sort_order' => $maxOrder + 1,
        ]);

        $this->showCreateModal = false;
        $this->newName = '';

        Notification::make()->title('Category created')->success()->send();
    }

    public function startEdit(int $id): void
    {
        $cat = Category::find($id);
        if (! $cat) return;
        $this->editingId = $id;
        $this->editingName = $cat->name;
    }

    public function saveEdit(): void
    {
        if (! $this->editingId || ! trim((string) $this->editingName)) {
            $this->cancelEdit();
            return;
        }
        $cat = Category::find($this->editingId);
        if (! $cat) return;
        $name = trim($this->editingName);
        if ($name !== $cat->name) {
            $cat->update(['name' => $name, 'slug' => $this->uniqueSlug($name, $cat->id)]);
            Notification::make()->title('Renamed')->success()->send();
        }
        $this->cancelEdit();
    }

    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->editingName = null;
    }

    public function delete(int $id): void
    {
        $cat = Category::withCount('products')->find($id);
        if (! $cat) return;
        if ($cat->products_count > 0) {
            Notification::make()
                ->title("Can't delete — has {$cat->products_count} products")
                ->body('Move or remove the products first.')
                ->danger()
                ->send();
            return;
        }
        $cat->delete();
        Notification::make()->title('Category deleted')->success()->send();
    }

    /** @param array<int,int> $orderedIds */
    public function reorder(array $orderedIds): void
    {
        foreach ($orderedIds as $i => $id) {
            Category::where('id', $id)->update(['sort_order' => $i + 1]);
        }
    }

    protected function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'category';
        $slug = $base;
        $i = 2;
        while (Category::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
