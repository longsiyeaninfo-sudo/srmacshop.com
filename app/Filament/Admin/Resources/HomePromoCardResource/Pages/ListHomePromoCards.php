<?php

namespace App\Filament\Admin\Resources\HomePromoCardResource\Pages;

use App\Filament\Admin\Resources\HomePromoCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomePromoCards extends ListRecords
{
    protected static string $resource = HomePromoCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
