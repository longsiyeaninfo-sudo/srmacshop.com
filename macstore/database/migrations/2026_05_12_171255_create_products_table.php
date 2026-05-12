<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
          $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->json('name');
          $table->string('slug')->unique();
            $table->string('sku_prefix')->nullable();
         $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
         $table->enum('condition', ['new', 'refurbished', 'used'])->default('new');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
      $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
