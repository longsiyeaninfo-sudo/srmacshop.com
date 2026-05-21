<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Pages\PostProduct;
use App\Filament\Admin\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    public function mount(): void
    {
        $this->redirect(PostProduct::getUrl());
    }
}
