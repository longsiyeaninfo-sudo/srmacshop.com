<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
             ImageColumn::make('images')
             ->label('Image')
          ->circular()
         ->defaultImageUrl('/images/placeholder-macbook.png'),
                    
          TextColumn::make('name')
          ->searchable()
           ->sortable()
               ->limit(30),
                    
                TextColumn::make('category.name')
             ->sortable()
              ->searchable(),
                    
            TextColumn::make('base_price')
              ->money('USD')
                    ->sortable(),
                  
                TextColumn::make('sale_price')
                    ->money('USD')
                    ->sortable()
               ->placeholder('—'),
            
                TextColumn::make('condition')
            ->badge()
                    ->color(fn (string $state): string => match ($state) {
                     'new' => 'success',
            'refurbished' => 'warning',
                     'used' => 'gray',
                    }),
                    
                IconColumn::make('is_featured')
               ->boolean()
                ->label('Featured'),
               
              IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            
                TextColumn::make('created_at')
                    ->dateTime()
              ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            SelectFilter::make('category')
               ->relationship('category', 'name'),
           
                SelectFilter::make('condition')
                ->options([
               'new' => 'New',
                     'refurbished' => 'Refurbished',
                        'used' => 'Used',
           ]),
                    
             SelectFilter::make('is_featured')
                ->options([
                      1 => 'Featured',
                   0 => 'Not Featured',
                    ])
             ->label('Featured'),
            ])
            ->actions([
         EditAction::make(),
         ])
      ->bulkActions([
                DeleteBulkAction::make(),
            ])
          ->defaultSort('created_at', 'desc');
    }
}
