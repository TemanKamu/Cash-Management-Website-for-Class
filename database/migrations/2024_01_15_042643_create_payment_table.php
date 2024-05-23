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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("pemasukan_id");
            $table->text("external_id");
            $table->text("checkout_link");
            $table->timestamp("expired_date");
            $table->unsignedBigInteger("amount");
            $table->string("status")->default("pending");
            $table->timestamps();

            $table->foreign("pemasukan_id")->references("id")->on("pemasukan");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
