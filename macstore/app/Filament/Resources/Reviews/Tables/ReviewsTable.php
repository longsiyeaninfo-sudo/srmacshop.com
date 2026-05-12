<?php

namespace App\Filament\Resources\Reviews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                ->searchable()
             ->sortable(),
           TextColumn::make('user.name')
                    ->searchable()
                 ->sortable(),
                TextColumn::make('rating')
             ->badge()
                    ->color(fn ($state) => match(true) {
               $state >= 4 => 'success',
                $state >= 3 => 'warning',
                   default => 'danger',
                    })
                 ->sortable(),
            TextColumn::make('comment')
                  ->limit(50)
                  ->searchable(),
            IconColumn::make('is_approved')
                    ->boolean()
                    ->label('Approved'),
            TextColumn::make('created_at')
                 ->dateTime()
                 ->sortable(),
            ])
            ->filters([
         SelectFilter::make('rating')
               ->options([
           5 => '5 Stars',
                        4 => '4 Stars',
                    3 => '3 Stars',
                        2 => '2 Stars',
                     1 => '1 Star',
                ]),
          SelectFilter::make('is_approved')
                    ->options([
             1 => 'Approved',
                        0 => 'Pending',
               ])
                ->label('Status'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
            BulkActionGroup::make([
                 DeleteBulkAction::make(),
                ]),
          ])
            ->defaultSort('created_at', 'desc');
    }
}
