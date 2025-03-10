<?php

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
        Schema::table('class', function (Blueprint $table) {
            $table->unsignedBigInteger("owner_room_id");
            $table->foreign("owner_room_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class', function (Blueprint $table) {
            Schema::dropIfExists('class');
        });
    }
};
