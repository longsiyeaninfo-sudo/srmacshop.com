<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TopMacbookResource\Pages;
use App\Models\Product;
use App\Models\TopMacbook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TopMacbookResource extends Resource
{
    protected static ?string $model = TopMacbook::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Marketing';

    protected static ?string $navigationLabel = 'Top MacBooks';

    protected static ?string $modelLabel = 'Top MacBook';

    protected static ?string $pluralModelLabel = 'Top MacBooks';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form->schema([

            // ── 1. Pick the MacBook ──────────────────────────────────────────
            Forms\Components\Section::make('Pick a MacBook')
                ->description('Choose which MacBook to feature in the homepage "Top MacBooks in Cambodia" section.')
                ->icon('heroicon-o-cube')
                ->schema([
                    Forms\Components\Select::make('product_id')
                        ->label('MacBook')
                        ->relationship(
                            'product',
                            'name',
                            fn (Builder $query) => $query
                                ->where('is_active', true)
                                ->whereHas('category', fn ($c) => $c->whereIn('slug', ['macbook-air', 'macbook-pro']))
                                ->orderBy('name')
                        )
                        ->getOptionLabelFromRecordUsing(
                            fn (Product $r) =>
                                $r->name
                                . ' — $' . number_format($r->price / 100, 0)
                                . ($r->badge ? '  [' . strtoupper($r->badge) . ']' : '')
                        )
                        ->searchable()
                        ->preload()
                        ->required()
                        ->helperText('Only active MacBook Air / MacBook Pro products are listed.')
                        ->columnSpanFull(),
                ])
                ->columns(1),

            // ── 2. Rank label (trilingual, optional) ─────────────────────────
            Forms\Components\Section::make('Rank label (optional)')
                ->description('A short ribbon shown on the card, e.g. "Best Overall", "Best Value", "Best for Students".')
                ->icon('heroicon-o-pencil')
                ->schema([
                    Forms\Components\TextInput::make('label_en')
                        ->label('English')
                        ->maxLength(40)
                        ->placeholder('Best Overall'),
                    Forms\Components\TextInput::make('label_km')
                        ->label('ខ្មែរ (Khmer)')
                        ->maxLength(60),
                    Forms\Components\TextInput::make('label_zh')
                        ->label('中文 (Chinese)')
                        ->maxLength(40),
                ])
                ->columns(3),

            // ── 3. Display settings ──────────────────────────────────────────
            Forms\Components\Section::make('Display')
                ->icon('heroicon-o-adjustments-horizontal')
                ->schema([
                    Forms\Components\TextInput::make('sort_order')
                        ->label('Order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first.'),
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
                Tables\Columns\ImageColumn::make('product.media')
                    ->label('Photo')
                    ->getStateUsing(fn (TopMacbook $r): ?string =>
                        $r->product?->getFirstMediaUrl('gallery') ?: null)
                    ->width(110)
                    ->height(62)
                    ->extraImgAttributes(['style' => 'object-fit:cover;border-radius:6px']),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('MacBook')
                    ->searchable()
                    ->limit(30)
                    ->description(fn (TopMacbook $r): string =>
                        $r->product?->price
                            ? '$' . number_format($r->product->price / 100, 0)
                            : ''
                    ),

                Tables\Columns\TextColumn::make('label_en')
                    ->label('Rank label')
                    ->placeholder('—')
                    ->limit(30),

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
            ->emptyStateHeading('No top picks yet')
            ->emptyStateDescription('Add your first MacBook — pick a product and label why it\'s a top choice.')
            ->emptyStateIcon('heroicon-o-trophy');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['product.media']);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTopMacbooks::route('/'),
            'create' => Pages\CreateTopMacbook::route('/create'),
            'edit'   => Pages\EditTopMacbook::route('/{record}/edit'),
        ];
    }
}
