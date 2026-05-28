<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\HomeSlideResource\Pages;
use App\Models\HomeSlide;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomeSlideResource extends Resource
{
    protected static ?string $model = HomeSlide::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Marketing';

    protected static ?string $navigationLabel = 'Homepage Slideshow';

    protected static ?string $modelLabel = 'Slide';

    protected static ?string $pluralModelLabel = 'Homepage Slides';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([

            // ── 1. Product link (primary action — top of form) ──────────────
            Forms\Components\Section::make('Link to a product')
                ->description('Pick a product and everything fills in automatically — title, price and photo.')
                ->icon('heroicon-o-link')
                ->schema([
                    Forms\Components\Select::make('product_id')
                        ->label('Product')
                        ->relationship(
                            'product',
                            'name',
                            fn (\Illuminate\Database\Eloquent\Builder $query) =>
                                $query->where('is_active', true)->orderBy('name')
                        )
                        ->getOptionLabelFromRecordUsing(
                            fn (Product $r) =>
                                $r->name
                                . ' — $' . number_format($r->price / 100, 0)
                                . ($r->badge ? '  [' . strtoupper($r->badge) . ']' : '')
                        )
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->live()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            if (! $state) return;
                            $product = Product::find($state);
                            if (! $product) return;
                            // Auto-fill title only if the field is still empty
                            if (! $get('title_en')) {
                                $set('title_en', $product->name);
                            }
                        })
                        ->placeholder('— No product (image-only slide) —')
                        ->helperText('Select a product → the title auto-fills and its gallery photo is used automatically. You can still upload a custom image below to override it.')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('link_url')
                        ->label('Custom URL (optional override)')
                        ->url()
                        ->maxLength(500)
                        ->placeholder('https://srmacshop.com/special')
                        ->helperText('Only needed if you want the slide to link somewhere other than the linked product page.')
                        ->columnSpanFull(),
                ])
                ->columns(1),

            // ── 2. Custom image (optional when product is linked) ────────────
            Forms\Components\Section::make('Slide image')
                ->description('Leave blank to use the product\'s own gallery photo automatically.')
                ->icon('heroicon-o-camera')
                ->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Upload image')
                        ->image()
                        ->imageEditor()
                        ->directory('slides')
                        ->disk('public')
                        ->maxSize(4096)
                        ->required(fn (Forms\Get $get): bool => empty($get('product_id')))
                        ->helperText('16:9 landscape works best (e.g. 1600×900). Max 4 MB. Leave blank to use the product\'s photo.')
                        ->columnSpanFull(),
                ])
                ->columns(1),

            // ── 3. Caption overrides (all optional) ─────────────────────────
            Forms\Components\Section::make('Caption title (optional)')
                ->description('Custom slide title. Leave blank to auto-use the linked product\'s name.')
                ->icon('heroicon-o-pencil')
                ->schema([
                    Forms\Components\TextInput::make('title_en')
                        ->label('English')
                        ->maxLength(120)
                        ->placeholder('(auto-fills from product name)'),
                    Forms\Components\TextInput::make('title_km')
                        ->label('ខ្មែរ (Khmer)')
                        ->maxLength(160),
                    Forms\Components\TextInput::make('title_zh')
                        ->label('中文 (Chinese)')
                        ->maxLength(120),
                ])
                ->columns(3)
                ->collapsed(),

            // ── 4. Display settings ──────────────────────────────────────────
            Forms\Components\Section::make('Display')
                ->icon('heroicon-o-adjustments-horizontal')
                ->schema([
                    Forms\Components\TextInput::make('sort_order')
                        ->label('Order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first in the slideshow.'),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active (visible on homepage)')
                        ->default(true)
                        ->inline(false),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Thumbnail — falls back to product gallery photo
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Slide')
                    ->disk('public')
                    ->defaultImageUrl(fn (HomeSlide $r): ?string =>
                        $r->product?->getFirstMediaUrl('gallery') ?: null)
                    ->width(110)
                    ->height(62)
                    ->extraImgAttributes(['style' => 'object-fit:cover;border-radius:6px']),

                // Product name + price
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->limit(28)
                    ->placeholder('— image only —')
                    ->description(fn (HomeSlide $r): string =>
                        $r->product?->price
                            ? '$' . number_format($r->product->price / 100, 0)
                            : ''
                    ),

                // Custom title (if any)
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Custom title')
                    ->searchable()
                    ->limit(30)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                // Custom image indicator
                Tables\Columns\IconColumn::make('image_path')
                    ->label('Custom img')
                    ->boolean()
                    ->trueIcon('heroicon-o-photo')
                    ->falseIcon('heroicon-o-arrow-path')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->tooltip(fn (HomeSlide $r) => $r->image_path ? 'Custom upload' : 'Using product photo'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->emptyStateHeading('No slides yet')
            ->emptyStateDescription('Create your first slide — pick a product and it\'s ready in seconds.')
            ->emptyStateIcon('heroicon-o-photo');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHomeSlides::route('/'),
            'create' => Pages\CreateHomeSlide::route('/create'),
            'edit'   => Pages\EditHomeSlide::route('/{record}/edit'),
        ];
    }
}
