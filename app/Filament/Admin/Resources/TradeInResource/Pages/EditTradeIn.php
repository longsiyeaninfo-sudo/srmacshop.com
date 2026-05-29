<?php

namespace App\Filament\Admin\Resources\TradeInResource\Pages;

use App\Filament\Admin\Resources\TradeInResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTradeIn extends EditRecord
{
    protected static string $resource = TradeInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
