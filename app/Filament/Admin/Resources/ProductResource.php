<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Basic Info')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('slug', Str::slug($state ?? ''))
                    ),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('Auto-filled from the name — edit if you want a custom URL.'),
                Forms\Components\TextInput::make('spec')->columnSpanFull(),

                Forms\Components\TextInput::make('price_dollars')
                    ->label('Price (USD)')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->dehydrated(false)
                    ->afterStateHydrated(fn ($state, $record, callable $set) =>
                        $set('price_dollars', $record ? $record->price / 100 : 0)
                    )
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('price', (int) round(((float) $state) * 100))
                    ),
                Forms\Components\Hidden::make('price'),

                Forms\Components\TextInput::make('discount_percent')
                    ->label('Discount %')
                    ->numeric()
                    ->suffix('%')
                    ->minValue(0)->maxValue(95)
                    ->dehydrated(false)
                    ->helperText('Optional. Enter a % → the sale price + original (strike-through) price fill in automatically.')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $base = (float) $get('price_dollars');
                        if ($state > 0 && $base > 0) {
                            $sale = round($base * (1 - ((float) $state) / 100), 2);
                            // The currently typed price becomes the "was" price
                            $set('original_price_dollars', $base);
                            $set('original_price', (int) round($base * 100));
                            $set('price_dollars', $sale);
                            $set('price', (int) round($sale * 100));
                        }
                    }),

                Forms\Components\TextInput::make('original_price_dollars')
                    ->label('Original price (USD)')
                    ->numeric()
                    ->prefix('$')
                    ->dehydrated(false)
                    ->helperText('Strike-through “was” price. Leave blank if not on sale. Auto-fills from Discount %.')
                    ->afterStateHydrated(fn ($state, $record, callable $set) =>
                        $set('original_price_dollars', $record && $record->original_price ? $record->original_price / 100 : null)
                    )
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('original_price', $state ? (int) round(((float) $state) * 100) : null)
                    ),
                Forms\Components\Hidden::make('original_price'),

                Forms\Components\TextInput::make('emoji')
                    ->maxLength(8)
                    ->placeholder('💻')
                    ->helperText('Auto-suggested from the category — change it if you like.'),

                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (! $state) return;
                        $cat = \App\Models\Category::find($state);
                        if (! $cat) return;

                        $key = Str::lower(($cat->slug ?? '') . ' ' . $cat->name);

                        // Auto emoji
                        $set('emoji', match (true) {
                            str_contains($key, 'smartphone') || str_contains($key, 'phone') => '📱',
                            str_contains($key, 'tablet')  || str_contains($key, 'ipad')     => '📱',
                            str_contains($key, 'macbook') || str_contains($key, 'computer') || str_contains($key, 'laptop') => '💻',
                            str_contains($key, 'accessor') => '🎧',
                            str_contains($key, 'protect')  => '🛡️',
                            default => '💻',
                        });

                        // Auto warranty
                        $isApple = (bool) preg_match('/macbook|smartphone|phone|tablet|ipad|apple/', $key);
                        $set('warranty', $isApple ? '2 Year Apple Official' : '1 Year Warranty');
                    }),

                Forms\Components\TextInput::make('stock')->numeric()->default(0)->required(),
                Forms\Components\Select::make('badge')
                    ->options(['new' => '🆕 New', 'hot' => '🔥 Hot', 'sale' => '💰 Sale'])
                    ->placeholder('None'),
            ])->columns(2),

            Forms\Components\Section::make('Details')->schema([
                Forms\Components\Textarea::make('description')->rows(5)->columnSpanFull(),

                Forms\Components\Select::make('condition_grade')
                    ->label('Condition')
                    ->options([
                        'A+' => 'A+ — Like new (no scratches)',
                        'A'  => 'A — Excellent (minor wear)',
                        'B'  => 'B — Good (light scratches)',
                        'C'  => 'C — Fair (visible wear)',
                    ])
                    ->placeholder('Select grade'),
                Forms\Components\TextInput::make('battery_health')
                    ->label('Battery health')
                    ->numeric()->minValue(0)->maxValue(100)->suffix('%')
                    ->helperText('Leave blank for devices without a battery (e.g. accessories).'),
                Forms\Components\Select::make('storage')
                    ->label('Storage')
                    ->options(['64GB' => '64GB', '128GB' => '128GB', '256GB' => '256GB', '512GB' => '512GB', '1TB' => '1TB', '2TB' => '2TB'])
                    ->searchable()
                    ->placeholder('Select capacity'),

                Forms\Components\TextInput::make('warranty')->placeholder('2 Year Apple Official'),
                Forms\Components\TextInput::make('color')->placeholder('Space Black / Silver'),
                Forms\Components\TextInput::make('weight')->placeholder('1.6 kg'),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->default(true)->inline(false),
            ])->columns(2),

            Forms\Components\Section::make('Product Photos')
                ->description('Upload photos via the Media section after saving the product. Use the file manager to add images directly.')
                ->schema([
                    Forms\Components\Placeholder::make('photo_info')
                        ->label('')
                        ->content('Save the product first, then upload photos using the "Upload Photos" action on the products list.'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('emoji')->label('')->size('lg'),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('category.name')->sortable()->badge()->color('primary'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('USD', divideBy: 100)
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('stock')
                    ->color(fn ($state) => $state <= 3 ? 'danger' : ($state <= 10 ? 'warning' : 'success'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('badge')->badge()->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('badge')
                    ->options(['new' => 'New', 'hot' => 'Hot', 'sale' => 'Sale']),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary')
                    ->url(fn (\App\Models\Product $r) => \App\Filament\Admin\Pages\EditProductKhmer::getUrl(['record' => $r->id])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
        ];
    }
}
