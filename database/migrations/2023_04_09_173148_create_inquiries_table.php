<?php

use App\Models\Inquiry;
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
        Schema::create(Inquiry::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('username');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on(Product::TABLE);
            $table->bigInteger('count')->default(1);
            $table->longText('inquiry');
            $table->boolean('read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Inquiry::TABLE);
    }
};
