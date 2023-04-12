<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(Product::TABLE, function (Blueprint $table) {
            $table->boolean('in_stock')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(Product::TABLE, function (Blueprint $table) {
            $table->dropColumn('in_stock');
        });
    }
};
