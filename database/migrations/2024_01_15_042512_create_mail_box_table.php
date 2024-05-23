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
        Schema::create('mail_box', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->string("messager_name");
            $table->enum("isBendahara", ["true", "false", "system"])->default("system");
            $table->unsignedBigInteger("for_user_id");
            $table->text("description");
            $table->boolean("isRead")->default(false);
            $table->timestamps();

            $table->foreign("for_user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_box');
    }
};
