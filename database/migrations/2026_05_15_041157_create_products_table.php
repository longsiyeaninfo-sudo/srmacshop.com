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
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('spec')->nullable();
            $table->unsignedInteger('price')->default(0); // cents
            $table->string('emoji', 8)->nullable();
        $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('stock')->default(0);
            $table->string('badge')->nullable();
        $table->text('description')->nullable();
            $table->string('warranty')->nullable();
        $table->string('color')->nullable();
            $table->string('weight')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
          $table->timestamps();

            $table->index('is_active');
            $table->index('badge');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
