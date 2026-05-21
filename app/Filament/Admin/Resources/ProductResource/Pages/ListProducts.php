<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Pages\PostProduct;
use App\Filament\Admin\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('addProduct')
                ->label('+ Add Product')
                ->color('warning')
                ->icon('heroicon-o-plus-circle')
                ->url(PostProduct::getUrl()),
        ];
    }
}
