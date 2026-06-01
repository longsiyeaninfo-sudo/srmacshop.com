<?php

namespace App\Filament\Admin\Resources\TopMacbookResource\Pages;

use App\Filament\Admin\Resources\TopMacbookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTopMacbooks extends ListRecords
{
    protected static string $resource = TopMacbookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
