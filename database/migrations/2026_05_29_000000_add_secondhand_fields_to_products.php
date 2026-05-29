<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Cosmetic condition grade for second-hand devices: A+, A, B, C.
            if (! Schema::hasColumn('products', 'condition_grade')) {
                $table->string('condition_grade', 8)->nullable()->after('color');
            }

            // Battery health percentage (0–100). Null for non-battery items.
            if (! Schema::hasColumn('products', 'battery_health')) {
                $table->unsignedTinyInteger('battery_health')->nullable()->after('condition_grade');
            }

            // Storage capacity, e.g. "256GB".
            if (! Schema::hasColumn('products', 'storage')) {
                $table->string('storage', 16)->nullable()->after('battery_health');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            foreach (['condition_grade', 'battery_health', 'storage'] as $col) {
                if (Schema::hasColumn('products', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
