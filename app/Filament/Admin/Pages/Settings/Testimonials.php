<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Testimonials extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Testimonials';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 14;
    protected static ?string $title = 'Customer Testimonials';
    protected static string $view = 'filament.admin.pages.settings.testimonials';

    /** @var array<int, array{name: string, role: string, quote: string, rating: int}> */
    public array $items = [];

    public function mount(): void
    {
        $stored = Setting::get('testimonials', []);
        if (empty($stored)) {
            $this->items = [
                ['name' => 'Sophal K.', 'role' => 'Designer · Phnom Penh', 'quote' => 'Got my MacBook Pro M4 next-day. Perfectly authentic, official Apple warranty. Fastest service in town.', 'rating' => 5],
                ['name' => 'Vannak R.', 'role' => 'Engineer · Toul Kork', 'quote' => 'I was skeptical buying online but SR Mac Shop made it so easy. Free setup at my office. Highly recommend.', 'rating' => 5],
                ['name' => 'Channary P.', 'role' => 'Student · BKK1', 'quote' => 'They beat the price I saw at another store and threw in AppleCare for cheaper. Will buy from them again.', 'rating' => 5],
            ];
        } else {
            $this->items = $stored;
        }
    }

    public function addItem(): void
    {
        $this->items[] = ['name' => '', 'role' => '', 'quote' => '', 'rating' => 5];
    }

    public function removeItem(int $index): void
    {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function moveUp(int $index): void
    {
        if ($index > 0) {
            [$this->items[$index - 1], $this->items[$index]] = [$this->items[$index], $this->items[$index - 1]];
        }
    }

    public function moveDown(int $index): void
    {
        if ($index < count($this->items) - 1) {
            [$this->items[$index + 1], $this->items[$index]] = [$this->items[$index], $this->items[$index + 1]];
        }
    }

    public function save(): void
    {
        $clean = array_values(array_filter(
            $this->items,
            fn ($i) => ! empty(trim($i['quote'] ?? '')) && ! empty(trim($i['name'] ?? ''))
        ));

        foreach ($clean as &$item) {
            $item['rating'] = max(1, min(5, (int) ($item['rating'] ?? 5)));
        }

        Setting::set('testimonials', $clean);

        Notification::make()
            ->title('Testimonials saved')
            ->body(count($clean) . ' testimonial(s) updated.')
            ->success()
            ->send();
    }
}
