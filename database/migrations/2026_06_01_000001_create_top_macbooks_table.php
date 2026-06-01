<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('top_macbooks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->string('label_en')->nullable();
            $t->string('label_km')->nullable();
            $t->string('label_zh')->nullable();
            $t->unsignedInteger('sort_order')->default(0)->index();
            $t->boolean('is_active')->default(true)->index();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('top_macbooks');
    }
};
