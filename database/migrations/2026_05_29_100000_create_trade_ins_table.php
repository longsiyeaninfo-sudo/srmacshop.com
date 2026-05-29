<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('trade_ins')) {
            return;
        }

        Schema::create('trade_ins', function (Blueprint $t) {
            $t->id();
            $t->string('ticket_number')->unique();
            $t->string('device_type');            // iPhone / iPad / MacBook / Apple Watch / Other
            $t->string('model');                  // free text, e.g. "iPhone 13 Pro"
            $t->string('storage')->nullable();
            $t->string('condition_grade', 8)->nullable();   // A+/A/B/C
            $t->unsignedTinyInteger('battery_health')->nullable();
            $t->integer('asking_price')->nullable();        // cents — seller's expectation
            $t->integer('offer_price')->nullable();         // cents — shop's offer (admin)
            $t->text('description')->nullable();
            $t->string('customer_name');
            $t->string('customer_phone', 50);
            $t->string('contact_method')->nullable();       // whatsapp / telegram / phone
            $t->string('status')->default('new')->index();
            $t->text('admin_notes')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_ins');
    }
};
