<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name_snapshot');
            $table->string('product_spec_snapshot')->nullable();
          $table->unsignedInteger('unit_price'); // cents
        $table->unsignedInteger('quantity');
            $table->unsignedInteger('line_total'); // cents
            $table->timestamps();
     });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
