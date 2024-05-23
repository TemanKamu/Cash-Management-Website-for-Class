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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string("no_hp");
            $table->string('password');
            $table->boolean("isBendahara")->default(false);
            $table->unsignedBigInteger("kelas_id")->nullable();
            $table->boolean("status_verifikasi_kelas")->default(false);
            $table->text("profile_user")->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign("kelas_id")->references("id")->on("class");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
