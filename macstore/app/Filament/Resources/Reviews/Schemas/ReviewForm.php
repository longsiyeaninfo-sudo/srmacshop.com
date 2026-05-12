<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Select::make('product_id')
          ->relationship('product', 'name')
                    ->required()
                  ->searchable()
                    ->preload(),
                Select::make('user_id')
             ->relationship('user', 'name')
                  ->required()
               ->searchable()
                    ->preload(),
            Select::make('rating')
                    ->options([
               5 => '5 Stars',
                      4 => '4 Stars',
                 3 => '3 Stars',
                2 => '2 Stars',
                        1 => '1 Star',
                ])
                 ->required(),
                Textarea::make('comment')
             ->required()
                    ->rows(4)
                 ->columnSpanFull(),
                Toggle::make('is_approved')
                 ->label('Approved')
                  ->default(false),
            ]);
    }
}
