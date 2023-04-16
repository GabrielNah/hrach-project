<?php

use App\Models\SiteAppearance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Services\Enums\SITE_APPEARANCE;
use App\Services\Enums\DECORATION_TYPES;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SiteAppearance::TABLE, function (Blueprint $table) {
            $table->id();
            $table->enum('section',array_column(SITE_APPEARANCE::cases(),'value'));
            $table->enum('type',array_column(DECORATION_TYPES::cases(),'value'));
            $table->string('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SiteAppearance::TABLE);
    }
};
