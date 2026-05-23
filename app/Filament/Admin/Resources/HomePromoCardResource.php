<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\HomePromoCardResource\Pages;
use App\Models\HomePromoCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomePromoCardResource extends Resource
{
    protected static ?string $model = HomePromoCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Marketing';

    protected static ?string $navigationLabel = 'Social Promo Cards';

    protected static ?string $modelLabel = 'Promo Card';

    protected static ?string $pluralModelLabel = 'Social Promo Cards';

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Card')
                ->description('The clickable card shown on the homepage Computer Sales section.')
                ->schema([
                    Forms\Components\Select::make('platform')
                        ->options([
                            'facebook' => '📘 Facebook ad style (1:1 image)',
                            'tiktok'   => '🎵 TikTok video style (9:16 portrait)',
                        ])
                        ->required()
                        ->default('facebook')
                        ->native(false),
                    Forms\Components\FileUpload::make('image_path')
                        ->image()
                        ->imageEditor()
                        ->directory('promos')
                        ->disk('public')
                        ->maxSize(2048)
                        ->helperText('Square 1:1 works best for Facebook style; 9:16 portrait for TikTok style. Max 2 MB.'),
                    Forms\Components\TextInput::make('link_url')
                        ->label('Link URL (Facebook post / TikTok video)')
                        ->required()
                        ->url()
                        ->maxLength(500)
                        ->placeholder('https://facebook.com/srmacshop/posts/... or https://www.tiktok.com/@srmacshop/video/...'),
                ])
                ->columns(1),

            Forms\Components\Section::make('Headline')
                ->description('Main bold text on the card.')
                ->schema([
                    Forms\Components\TextInput::make('headline_en')
                        ->label('English')
                        ->required()
                        ->maxLength(120),
                    Forms\Components\TextInput::make('headline_km')
                        ->label('ខ្មែរ (Khmer)')
                        ->maxLength(160),
                    Forms\Components\TextInput::make('headline_zh')
                        ->label('中文 (Chinese)')
                        ->maxLength(120),
                ])
                ->columns(3),

            Forms\Components\Section::make('Subtext (optional)')
                ->description('Short blurb shown under the headline.')
                ->schema([
                    Forms\Components\TextInput::make('subtext_en')
                        ->label('English')
                        ->maxLength(180),
                    Forms\Components\TextInput::make('subtext_km')
                        ->label('ខ្មែរ (Khmer)')
                        ->maxLength(220),
                    Forms\Components\TextInput::make('subtext_zh')
                        ->label('中文 (Chinese)')
                        ->maxLength(180),
                ])
                ->columns(3),

            Forms\Components\Section::make('Call-to-action button label')
                ->schema([
                    Forms\Components\TextInput::make('cta_label_en')
                        ->label('English')
                        ->maxLength(40)
                        ->default('View Post →'),
                    Forms\Components\TextInput::make('cta_label_km')
                        ->label('ខ្មែរ (Khmer)')
                        ->maxLength(60)
                        ->default('មើលប្រកាស →'),
                    Forms\Components\TextInput::make('cta_label_zh')
                        ->label('中文 (Chinese)')
                        ->maxLength(40)
                        ->default('查看帖子 →'),
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
                    ->square(),
                Tables\Columns\TextColumn::make('platform')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tiktok' => 'gray',
                        default  => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'tiktok' => '🎵 TikTok',
                        default  => '📘 Facebook',
                    }),
                Tables\Columns\TextColumn::make('headline_en')
                    ->label('Headline')
                    ->searchable()
                    ->limit(40),
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
                Tables\Filters\SelectFilter::make('platform')
                    ->options([
                        'facebook' => '📘 Facebook',
                        'tiktok'   => '🎵 TikTok',
                    ]),
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
            'index'  => Pages\ListHomePromoCards::route('/'),
            'create' => Pages\CreateHomePromoCard::route('/create'),
            'edit'   => Pages\EditHomePromoCard::route('/{record}/edit'),
        ];
    }
}
