<?php

namespace App\Filament\Admin\Resources;

use App\Enums\TradeInStatus;
use App\Filament\Admin\Resources\TradeInResource\Pages;
use App\Models\TradeIn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class TradeInResource extends Resource
{
    protected static ?string $model = TradeIn::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Main';
    protected static ?string $navigationLabel = 'Trade-ins';
    protected static ?string $modelLabel = 'trade-in';
    protected static ?string $navigationBadgeColor = 'warning';

    public static function getNavigationBadge(): ?string
    {
        $count = TradeIn::where('status', TradeInStatus::New)->count();
        return $count > 0 ? (string) $count : null;
    }

    /** Normalise a local Cambodian number to a wa.me-friendly international form. */
    public static function waPhone(?string $phone): string
    {
        $digits = preg_replace('/\D/', '', (string) $phone);
        if (str_starts_with($digits, '0')) {
            $digits = '855' . substr($digits, 1);
        }
        return $digits;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Device')->schema([
                Forms\Components\TextInput::make('ticket_number')->disabled(),
                Forms\Components\Select::make('device_type')
                    ->options(['iPhone' => 'iPhone', 'iPad' => 'iPad', 'MacBook' => 'MacBook', 'Apple Watch' => 'Apple Watch', 'Other' => 'Other'])
                    ->required(),
                Forms\Components\TextInput::make('model')->required(),
                Forms\Components\TextInput::make('storage'),
                Forms\Components\Select::make('condition_grade')
                    ->label('Condition')
                    ->options(['A+' => 'A+', 'A' => 'A', 'B' => 'B', 'C' => 'C']),
                Forms\Components\TextInput::make('battery_health')->numeric()->suffix('%')->minValue(0)->maxValue(100),
                Forms\Components\Textarea::make('description')->label('Seller notes')->columnSpanFull(),
                Forms\Components\Placeholder::make('photos')
                    ->label('Photos')
                    ->columnSpanFull()
                    ->content(function (?TradeIn $record): HtmlString {
                        if (! $record) {
                            return new HtmlString('<span style="color:#888">—</span>');
                        }
                        $media = $record->getMedia('photos');
                        if ($media->isEmpty()) {
                            return new HtmlString('<span style="color:#888">No photos uploaded.</span>');
                        }
                        $imgs = $media->map(fn ($m) =>
                            '<a href="' . e($m->getUrl()) . '" target="_blank" rel="noopener">'
                            . '<img src="' . e($m->getUrl()) . '" style="width:120px;height:120px;object-fit:cover;border-radius:8px;border:1px solid #e5e5e5">'
                            . '</a>'
                        )->implode('');
                        return new HtmlString('<div style="display:flex;gap:10px;flex-wrap:wrap">' . $imgs . '</div>');
                    }),
            ])->columns(2),

            Forms\Components\Section::make('Seller')->schema([
                Forms\Components\TextInput::make('customer_name')->required(),
                Forms\Components\TextInput::make('customer_phone')->tel()->required(),
                Forms\Components\Select::make('contact_method')
                    ->options(['whatsapp' => 'WhatsApp', 'telegram' => 'Telegram', 'phone' => 'Phone']),
            ])->columns(3),

            Forms\Components\Section::make('Deal')->schema([
                Forms\Components\TextInput::make('asking_price_dollars')
                    ->label('Asking price (USD)')
                    ->numeric()->prefix('$')->disabled()->dehydrated(false)
                    ->afterStateHydrated(fn ($record, callable $set) =>
                        $set('asking_price_dollars', $record && $record->asking_price ? $record->asking_price / 100 : null)
                    ),
                Forms\Components\TextInput::make('offer_price_dollars')
                    ->label('Your offer (USD)')
                    ->numeric()->prefix('$')->dehydrated(false)
                    ->afterStateHydrated(fn ($record, callable $set) =>
                        $set('offer_price_dollars', $record && $record->offer_price ? $record->offer_price / 100 : null)
                    )
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('offer_price', $state !== null && $state !== '' ? (int) round(((float) $state) * 100) : null)
                    ),
                Forms\Components\Hidden::make('offer_price'),
                Forms\Components\Select::make('status')
                    ->options(collect(TradeInStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])->all())
                    ->required(),
                Forms\Components\Textarea::make('admin_notes')->label('Internal notes')->columnSpanFull(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')->label('Ref')->weight('bold')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('device_type')->badge()->color('primary'),
                Tables\Columns\TextColumn::make('model')
                    ->description(fn (TradeIn $r) => collect([$r->storage, $r->condition_grade ? "Grade {$r->condition_grade}" : null, $r->battery_health ? "🔋{$r->battery_health}%" : null])->filter()->implode(' · '))
                    ->searchable(),
                Tables\Columns\TextColumn::make('asking_price')->label('Asking')->money('USD', divideBy: 100)->placeholder('—'),
                Tables\Columns\TextColumn::make('offer_price')->label('Offer')->money('USD', divideBy: 100)->placeholder('—')->weight('bold'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (TradeInStatus $state) => $state->label())
                    ->color(fn (TradeInStatus $state) => $state->color()),
                Tables\Columns\TextColumn::make('customer_phone')->label('Phone')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable()->label('Received'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(TradeInStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])->all()),
                Tables\Filters\SelectFilter::make('device_type')
                    ->options(['iPhone' => 'iPhone', 'iPad' => 'iPad', 'MacBook' => 'MacBook', 'Apple Watch' => 'Apple Watch', 'Other' => 'Other']),
            ])
            ->actions([
                Tables\Actions\Action::make('reviewing')
                    ->label('Reviewing')->icon('heroicon-o-magnifying-glass')->color('info')
                    ->visible(fn (TradeIn $r) => $r->status === TradeInStatus::New)
                    ->action(fn (TradeIn $r) => $r->update(['status' => TradeInStatus::Reviewing])),
                Tables\Actions\Action::make('quoted')
                    ->label('Quoted')->icon('heroicon-o-currency-dollar')->color('primary')
                    ->visible(fn (TradeIn $r) => in_array($r->status, [TradeInStatus::New, TradeInStatus::Reviewing], true))
                    ->action(fn (TradeIn $r) => $r->update(['status' => TradeInStatus::Quoted])),
                Tables\Actions\Action::make('accept')
                    ->label('Accept')->icon('heroicon-o-check-circle')->color('success')
                    ->visible(fn (TradeIn $r) => $r->status !== TradeInStatus::Accepted && $r->status !== TradeInStatus::Declined)
                    ->action(fn (TradeIn $r) => $r->update(['status' => TradeInStatus::Accepted])),
                Tables\Actions\Action::make('decline')
                    ->label('Decline')->icon('heroicon-o-x-circle')->color('danger')->requiresConfirmation()
                    ->visible(fn (TradeIn $r) => $r->status !== TradeInStatus::Declined)
                    ->action(fn (TradeIn $r) => $r->update(['status' => TradeInStatus::Declined])),
                Tables\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')->icon('heroicon-o-chat-bubble-left-right')->color('success')
                    ->url(fn (TradeIn $r) => 'https://wa.me/' . self::waPhone($r->customer_phone))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTradeIns::route('/'),
            'create' => Pages\CreateTradeIn::route('/create'),
            'edit'   => Pages\EditTradeIn::route('/{record}/edit'),
        ];
    }
}
