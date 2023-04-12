<?php

use App\Models\ContactInfo;
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
        Schema::create(ContactInfo::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('introduction');
            $table->string('address');
            $table->string('email');
            $table->string('phone');
            $table->string('working_hours');
            $table->string('new_settler_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ContactInfo::TABLE);
    }
};
