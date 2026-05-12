<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Products table indexes
        Schema::table('products', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('is_active');
            $table->index('is_featured');
       $table->index(['is_active', 'is_featured']);
            $table->index('slug');
      });

        // Orders table indexes
        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id');
         $table->index('status');
         $table->index('payment_status');
            $table->index(['user_id', 'status']);
            $table->index('created_at');
        });

        // Reviews table indexes
        Schema::table('reviews', function (Blueprint $table) {
            $table->index('product_id');
          $table->index('user_id');
            $table->index('is_approved');
            $table->index(['product_id', 'is_approved']);
        });

        // Categories table indexes
        Schema::table('categories', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('sort_order');
            $table->index('slug');
        });

        // Addresses table indexes
        Schema::table('addresses', function (Blueprint $table) {
          $table->index('user_id');
         $table->index(['user_id', 'is_default']);
        });

      // Wishlists table indexes
        Schema::table('wishlists', function (Blueprint $table) {
            $table->index('user_id');
         $table->index('product_id');
            $table->index(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
        $table->dropIndex(['is_active']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['is_active', 'is_featured']);
            $table->dropIndex(['slug']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_status']);
      $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['is_approved']);
          $table->dropIndex(['product_id', 'is_approved']);
        });

     Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['slug']);
        });

        Schema::table('addresses', function (Blueprint $table) {
          $table->dropIndex(['user_id']);
            $table->dropIndex(['user_id', 'is_default']);
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        $table->dropIndex(['product_id']);
            $table->dropIndex(['user_id', 'product_id']);
        });
    }
};
