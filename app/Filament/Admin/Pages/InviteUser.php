<?php

namespace App\Filament\Admin\Pages;

use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class InviteUser extends Page
{
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Invite a Teammate';
    protected static string $view = 'filament.admin.pages.invite-user';

    public static function getRoutePath(): string
    {
        return '/invite-user';
    }

    #[Validate('required|string|max:120')]
    public string $name = '';

    #[Validate('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|in:admin,staff')]
    public string $role = 'staff';

    public ?string $generatedPassword = null;
    public ?int $createdUserId = null;

    public function submit(): void
    {
        $this->validate();

        $password = $this->generatePassword();

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($password),
            'role'     => $this->role,
            'email_verified_at' => now(),
        ]);

        $this->generatedPassword = $password;
        $this->createdUserId = $user->id;

        Notification::make()
            ->title('Teammate invited')
            ->body("{$user->name} can now log in with the generated password.")
            ->success()
            ->send();
    }

    protected function generatePassword(): string
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $lower    = 'abcdefghjkmnpqrstuvwxyz';
        $digits   = '23456789';
        $symbols  = '!@#$%&*';

        return str_shuffle(
            $alphabet[random_int(0, strlen($alphabet) - 1)]
            . $lower[random_int(0, strlen($lower) - 1)]
            . $digits[random_int(0, strlen($digits) - 1)]
            . $symbols[random_int(0, strlen($symbols) - 1)]
            . Str::random(8)
        );
    }

    public function reset_form(): void
    {
        $this->name = '';
        $this->email = '';
        $this->role = 'staff';
        $this->generatedPassword = null;
        $this->createdUserId = null;
    }
}
