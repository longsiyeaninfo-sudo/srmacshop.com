<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\HomeSlideResource\Pages;
use App\Models\HomeSlide;
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
            Forms\Components\Section::make('Image')
                ->description('Photo shown in the homepage slideshow at the top of the page.')
                ->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->image()
                        ->imageEditor()
                        ->directory('slides')
                        ->disk('public')
                        ->maxSize(4096)
                        ->required()
                        ->helperText('16:9 landscape works best (e.g. 1600×900). Max 4 MB.'),
                ])
                ->columns(1),

            Forms\Components\Section::make('Link this slide to a product')
                ->description('When linked, the slide caption auto-shows the product title + price, and clicking the Shop button opens that product page.')
                ->schema([
                    Forms\Components\Select::make('product_id')
                        ->label('Product')
                        ->relationship('product', 'name', fn ($query) => $query->where('is_active', true)->orderBy('name'))
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->placeholder('— No product (image-only slide) —')
                        ->helperText('Optional. Leave blank for an image-only slide with no price or shop button.'),
                    Forms\Components\TextInput::make('link_url')
                        ->label('Custom link URL (overrides product link)')
                        ->url()
                        ->maxLength(500)
                        ->placeholder('https://example.com/special-page')
                        ->helperText('Optional. Use only if you want the Shop button to go somewhere other than the linked product page.'),
                ])
                ->columns(1),

            Forms\Components\Section::make('Caption title (optional)')
                ->description('Custom title shown on the slide. Leave blank to use the linked product\'s name automatically.')
                ->schema([
                    Forms\Components\TextInput::make('title_en')
                        ->label('English')
                        ->maxLength(120)
                        ->placeholder('(uses product name if blank)'),
                    Forms\Components\TextInput::make('title_km')
                        ->label('ខ្មែរ (Khmer)')
                        ->maxLength(160),
                    Forms\Components\TextInput::make('title_zh')
                        ->label('中文 (Chinese)')
                        ->maxLength(120),
                ])
                ->columns(3),

            Forms\Components\Section::make('Display')
                ->schema([
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first.'),
                    Forms\Components\Toggle::make('is_active')
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
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->size(80),
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title')
                    ->searchable()
                    ->limit(40)
                    ->placeholder('(no title)'),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Linked product')
                    ->searchable()
                    ->limit(30)
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->label('#'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
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
            ->reorderable('sort_order');
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
