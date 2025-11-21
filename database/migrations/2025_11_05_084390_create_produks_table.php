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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toko_id')->references('id')->on('tokos');
            $table->foreignId('kategori_id')->references('id')->on('kategoris');
            $table->string('nama_produk');
            $table->integer('harga_produk');
            $table->integer('stok');
            $table->text('deskripsi_produk');
            $table->date('tanggal_upload');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
