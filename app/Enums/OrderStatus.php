<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';

    public function label(): string
    {
      return match ($this) {
            self::Pending => 'Pending',
            self::Confirmed => 'Confirmed',
            self::Delivered => 'Delivered',
            self::Cancelled => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
          self::Pending => 'warning',
      self::Confirmed => 'info',
            self::Delivered => 'success',
            self::Cancelled => 'danger',
      };
    }
}
