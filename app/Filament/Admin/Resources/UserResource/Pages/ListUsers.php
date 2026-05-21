<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Pages\InviteUser;
use App\Filament\Admin\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('invite')
                ->label('Invite a teammate')
                ->icon('heroicon-o-user-plus')
                ->color('primary')
                ->url(fn () => InviteUser::getUrl()),
        ];
    }
}
