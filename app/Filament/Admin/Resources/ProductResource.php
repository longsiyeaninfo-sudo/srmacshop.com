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
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
                    ->afterStateUpdated(fn ($state, callable $set, $record) =>
                        $record?->exists ? null : $set('slug', Str::slug(($state ?? '') . ' ' . ''))
                    ),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
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
                Forms\Components\TextInput::make('emoji')->maxLength(8)->placeholder('💻'),
                Forms\Components\Select::make('category_id')->relationship('category', 'name'),
                Forms\Components\TextInput::make('stock')->numeric()->default(0)->required(),
                Forms\Components\Select::make('badge')
                    ->options(['new' => '🆕 New', 'hot' => '🔥 Hot', 'sale' => '💰 Sale'])
                    ->placeholder('None'),
            ])->columns(2),

            Forms\Components\Section::make('Details')->schema([
                Forms\Components\Textarea::make('description')->rows(5)->columnSpanFull(),
                Forms\Components\TextInput::make('warranty')->placeholder('2 Year Apple Official'),
                Forms\Components\TextInput::make('color')->placeholder('Space Black / Silver'),
                Forms\Components\TextInput::make('weight')->placeholder('1.6 kg'),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->default(true)->inline(false),
            ])->columns(2),

            Forms\Components\Section::make('Product Photos')->schema([
                Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('gallery')
                    ->multiple()
                    ->reorderable()
                    ->maxFiles(10)
                    ->image()
                    ->imageEditor()
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('gallery')
                    ->collection('gallery')
                    ->label('Photo')
                    ->conversion('thumb')
                    ->defaultImageUrl(fn ($record) => null),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
