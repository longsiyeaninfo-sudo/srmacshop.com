<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_slides', function (Blueprint $t) {
            $t->id();
            $t->string('image_path')->nullable();
            $t->string('title_en')->nullable();
            $t->string('title_km')->nullable();
            $t->string('title_zh')->nullable();
            $t->string('link_url', 500)->nullable();
            $t->unsignedInteger('sort_order')->default(0)->index();
            $t->boolean('is_active')->default(true)->index();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_slides');
    }
};
