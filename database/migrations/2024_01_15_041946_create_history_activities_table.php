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
        Schema::create('history_activities', function (Blueprint $table) {
            $table->id();
            $table->boolean("system_message")->default(false);
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("kelas_id");
            $table->boolean("isBendahara")->default(false);
            $table->text("description");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("kelas_id")->references("id")->on("class");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_activities');
    }
};
