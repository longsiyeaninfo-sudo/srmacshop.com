<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Pages\InviteUser;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Settings Users';
    protected static ?string $navigationLabel = 'Team';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(120),
            Forms\Components\TextInput::make('email')->email()->required()->maxLength(255)->unique(ignoreRecord: true),
            Forms\Components\Select::make('role')
                ->options(['admin' => 'Admin', 'staff' => 'Staff'])
                ->default('staff')
                ->required(),
            Forms\Components\DateTimePicker::make('email_verified_at')->label('Verified at')->displayFormat('d M Y H:i'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ViewColumn::make('name')
                    ->label('Member')
                    ->view('filament.admin.tables.user-cell')
                    ->searchable(['name', 'email']),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => ucfirst($state ?? '—'))
                    ->color(fn (?string $state) => match ($state) {
                        'admin' => 'primary',
                        'staff' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-clock'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last activity')
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('role')->options(['admin' => 'Admin', 'staff' => 'Staff']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('reset_password')
                    ->label('Send reset')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $status = Password::sendResetLink(['email' => $record->email]);
                        $sent = $status === Password::RESET_LINK_SENT;
                        Notification::make()
                            ->title($sent ? 'Reset link sent' : 'Could not send reset link')
                            ->body($sent ? "Password reset email sent to {$record->email}" : __($status))
                            ->color($sent ? 'success' : 'danger')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('bulk_reset')
                        ->label('Send password resets')
                        ->icon('heroicon-o-key')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $count = 0;
                            foreach ($records as $u) {
                                if (Password::sendResetLink(['email' => $u->email]) === Password::RESET_LINK_SENT) {
                                    $count++;
                                }
                            }
                            Notification::make()
                                ->title("Sent {$count} reset link" . ($count === 1 ? '' : 's'))
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No teammates yet')
            ->emptyStateDescription('Invite your first teammate to start collaborating.')
            ->emptyStateActions([
                Tables\Actions\Action::make('invite')
                    ->label('Invite a teammate')
                    ->icon('heroicon-o-user-plus')
                    ->color('primary')
                    ->url(fn () => InviteUser::getUrl()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit'  => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
