<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Original price (cents) — for strike-through display when on sale.
            // Null = no sale.
            if (! Schema::hasColumn('products', 'original_price')) {
                $table->unsignedInteger('original_price')->nullable()->after('price');
            }

            // Optional sale end for countdown timers. Null = no countdown.
            if (! Schema::hasColumn('products', 'sale_ends_at')) {
                $table->timestamp('sale_ends_at')->nullable()->after('original_price');
            }

            // Pick which products appear in the home Flash Deals swipe reel.
            if (! Schema::hasColumn('products', 'is_flash_deal')) {
                $table->boolean('is_flash_deal')->default(false)->after('sale_ends_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'sale_ends_at', 'is_flash_deal']);
        });
    }
};
