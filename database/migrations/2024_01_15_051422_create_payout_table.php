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
        Schema::create('payout', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("kelas_id");
            $table->unsignedBigInteger("pengeluaran_id");
            $table->unsignedBigInteger("channel_payout_id");
            $table->text("external_id");
            $table->unsignedBigInteger("amount");
            $table->text("description");
            $table->string("status");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("kelas_id")->references("id")->on("class");
            $table->foreign("channel_payout_id")->references("id")->on("channel_payout");
            $table->foreign("pengeluaran_id")->references("id")->on("pengeluaran");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout');
    }
};
