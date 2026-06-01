<?php

namespace App\Filament\Admin\Resources\TopMacbookResource\Pages;

use App\Filament\Admin\Resources\TopMacbookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTopMacbook extends EditRecord
{
    protected static string $resource = TopMacbookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
