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
        Schema::create('class', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kelas');
            $table->string('nama_kelas');
            $table->text('deskripsi');
            $table->integer('jumlah_maksimal_siswa')->default(0);
            $table->text('profile_kelas')->nullable();
            $table->unsignedBigInteger('harga_kas');
            // $table->enum("tipe_kas", ["mingguan", "harian"]);
            $table->unsignedBigInteger("saldo_fisik")->default(0);
            $table->unsignedBigInteger("saldo_digital")->default(0);
            $table->unsignedBigInteger("jumlah_pengeluaran")->default(0);
            // $table->unsignedBigInteger("total_saldo")->default(0);
            $table->text("payout_password");
      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class');
    }
};
