<?php

namespace App\Filament\Admin\Resources\HomePromoCardResource\Pages;

use App\Filament\Admin\Resources\HomePromoCardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomePromoCard extends EditRecord
{
    protected static string $resource = HomePromoCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
