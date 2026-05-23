<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_promo_cards', function (Blueprint $t) {
            $t->id();
            $t->string('platform')->default('facebook')->index(); // 'facebook' | 'tiktok'
            $t->string('image_path')->nullable();
            $t->string('headline_en');
            $t->string('headline_km')->nullable();
            $t->string('headline_zh')->nullable();
            $t->string('subtext_en')->nullable();
            $t->string('subtext_km')->nullable();
            $t->string('subtext_zh')->nullable();
            $t->string('link_url', 500);
            $t->string('cta_label_en', 60)->default('View Post →');
            $t->string('cta_label_km', 80)->nullable();
            $t->string('cta_label_zh', 60)->nullable();
            $t->unsignedInteger('sort_order')->default(0)->index();
            $t->boolean('is_active')->default(true)->index();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_promo_cards');
    }
};
