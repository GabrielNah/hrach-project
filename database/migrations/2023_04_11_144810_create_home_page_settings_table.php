<?php

use App\Models\HomePageSettings;
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
        Schema::create(HomePageSettings::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('section_name');
            $table->string('products');
            $table->bigInteger('showable_count');
            $table->boolean('main')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(HomePageSettings::TABLE);
    }
};
