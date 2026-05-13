<?php

namespace App\Services;

use App\Models\ProductVariant;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function checkAvailability(int $variantId, int $quantity): bool
    {
        $variant = ProductVariant::find($variantId);

        if (!$variant || !$variant->track_inventory) {
          return true;
        }

      return $variant->stock_quantity >= $quantity;
    }

    public function reserveStock(int $variantId, int $quantity): bool
    {
        $variant = ProductVariant::find($variantId);

        if (!$variant || !$variant->track_inventory) {
            return true;
        }

      if ($variant->stock_quantity < $quantity) {
            return false;
        }

        $variant->decrement('stock_quantity', $quantity);
        return true;
    }

    public function releaseStock(int $variantId, int $quantity): void
    {
        $variant = ProductVariant::find($variantId);

        if ($variant && $variant->track_inventory) {
            $variant->increment('stock_quantity', $quantity);
        }
    }

    public function processOrderInventory(Order $order): bool
    {
        return DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                if (!$this->reserveStock($item->product_variant_id, $item->quantity)) {
                  // Rollback will happen automatically
                 throw new \Exception("Insufficient stock for {$item->product_name}");
                }
            }
            return true;
        });
    }

    public function cancelOrderInventory(Order $order): void
    {
      foreach ($order->items as $item) {
            $this->releaseStock($item->product_variant_id, $item->quantity);
        }
    }

    public function getLowStockVariants()
    {
        return ProductVariant::where('track_inventory', true)
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->with('product')
            ->get();
    }

    public function getOutOfStockVariants()
    {
        return ProductVariant::where('track_inventory', true)
            ->where('stock_quantity', 0)
            ->with('product')
            ->get();
    }

    public function updateStock(int $variantId, int $quantity, ?string $reason = null): void
    {
        $variant = ProductVariant::find($variantId);

        if ($variant) {
            $variant->update(['stock_quantity' => $quantity]);

            // Log inventory change if needed
            // InventoryLog::create([...]);
        }
    }
}
