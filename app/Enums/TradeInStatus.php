<?php

namespace App\Enums;

enum TradeInStatus: string
{
    case New = 'new';
    case Reviewing = 'reviewing';
    case Quoted = 'quoted';
    case Accepted = 'accepted';
    case Declined = 'declined';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Reviewing => 'Reviewing',
            self::Quoted => 'Quoted',
            self::Accepted => 'Accepted',
            self::Declined => 'Declined',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::New => 'warning',
            self::Reviewing => 'info',
            self::Quoted => 'primary',
            self::Accepted => 'success',
            self::Declined => 'danger',
        };
    }
}
