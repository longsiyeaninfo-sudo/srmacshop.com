<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
       $table->string('email');
            $table->string('phone');
            $table->enum('status', ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
          $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method');
       $table->decimal('subtotal', 10, 2);
        $table->decimal('discount_total', 10, 2)->default(0);
            $table->decimal('shipping_total', 10, 2)->default(0);
            $table->decimal('tax_total', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->json('shipping_address');
            $table->json('billing_address')->nullable();
            $table->string('coupon_code')->nullable();
            $table->text('notes')->nullable();
        $table->timestamp('paid_at')->nullable();
        $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
         $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
