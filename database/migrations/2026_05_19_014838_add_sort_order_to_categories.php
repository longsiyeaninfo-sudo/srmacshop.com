<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('name');
        });

        DB::table('categories')->orderBy('id')->get()->each(function ($cat, $i) {
            DB::table('categories')->where('id', $cat->id)->update(['sort_order' => $i + 1]);
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
