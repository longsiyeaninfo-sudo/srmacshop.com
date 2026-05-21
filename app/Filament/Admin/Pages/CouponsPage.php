<?php

namespace App\Filament\Admin\Pages;

use App\Models\Coupon;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class CouponsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Coupons';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?int $navigationSort = 3;
    protected static ?string $title = 'Coupons';
    protected static string $view = 'filament.admin.pages.coupons';

    public bool $showModal = false;
    public ?int $editingId = null;

    #[Validate('required|string|max:32|regex:/^[A-Z0-9_-]+$/')]
    public string $code = '';

    #[Validate('required|in:percent,fixed')]
    public string $type = 'percent';

    #[Validate('required|numeric|min:1')]
    public ?float $value = null;

    #[Validate('nullable|numeric|min:0')]
    public ?float $min_subtotal = 0;

    #[Validate('nullable|integer|min:0')]
    public int $max_uses = 0;

    #[Validate('nullable|date')]
    public ?string $expires_at = null;

    public bool $is_active = true;

    public function getCouponsProperty()
    {
        return Coupon::orderByDesc('id')->get();
    }

    public function openCreate(): void
    {
        $this->resetFields();
        $this->resetErrorBag();
        $this->code = $this->generateCode();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $c = Coupon::find($id);
        if (! $c) return;
        $this->resetErrorBag();
        $this->editingId = $c->id;
        $this->code = $c->code;
        $this->type = $c->type;
        $this->value = $c->type === 'percent' ? (float) $c->value : $c->value / 100;
        $this->min_subtotal = $c->min_subtotal / 100;
        $this->max_uses = (int) $c->max_uses;
        $this->expires_at = $c->expires_at?->format('Y-m-d\TH:i');
        $this->is_active = (bool) $c->is_active;
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->resetFields();
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'code'         => strtoupper(trim($this->code)),
            'type'         => $this->type,
            'value'        => $this->type === 'percent' ? (int) $this->value : (int) round($this->value * 100),
            'min_subtotal' => (int) round(((float) $this->min_subtotal) * 100),
            'max_uses'     => (int) $this->max_uses,
            'expires_at'   => $this->expires_at ?: null,
            'is_active'    => $this->is_active,
        ];

        if ($this->type === 'percent' && ($data['value'] < 1 || $data['value'] > 100)) {
            $this->addError('value', 'Percent must be between 1 and 100.');
            return;
        }

        if ($this->editingId) {
            $c = Coupon::find($this->editingId);
            if (! $c) return;
            if (Coupon::where('code', $data['code'])->where('id', '!=', $c->id)->exists()) {
                $this->addError('code', 'That code is already taken.');
                return;
            }
            $c->update($data);
            Notification::make()->title('Coupon updated')->success()->send();
        } else {
            if (Coupon::where('code', $data['code'])->exists()) {
                $this->addError('code', 'That code is already taken.');
                return;
            }
            Coupon::create($data);
            Notification::make()->title('Coupon created')->success()->send();
        }

        $this->showModal = false;
        $this->resetFields();
    }

    public function delete(int $id): void
    {
        $c = Coupon::find($id);
        if (! $c) return;
        $c->delete();
        Notification::make()->title('Coupon deleted')->success()->send();
    }

    public function regenerateCode(): void
    {
        $this->code = $this->generateCode();
    }

    protected function generateCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Coupon::where('code', $code)->exists());
        return $code;
    }

    protected function resetFields(): void
    {
        $this->editingId = null;
        $this->code = '';
        $this->type = 'percent';
        $this->value = null;
        $this->min_subtotal = 0;
        $this->max_uses = 0;
        $this->expires_at = null;
        $this->is_active = true;
    }

    public function statusOf(Coupon $c): array
    {
        if (! $c->is_active) {
            return ['Inactive', 'gray'];
        }
        if ($c->expires_at && $c->expires_at->isPast()) {
            return ['Expired', 'gray'];
        }
        if ($c->max_uses > 0 && $c->used_count >= $c->max_uses) {
            return ['Used Up', 'orange'];
        }
        return ['Active', 'green'];
    }
}
