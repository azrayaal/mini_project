<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create pelanggans table
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id(); // Auto-increment integer ID
            $table->string('id_pelanggan')->unique(); // ID khusus sebagai referensi, contoh: PELANGGAN_1
            $table->string('nama');
            $table->string('domisili');
            $table->string('jenis_kelamin');
            $table->timestamps();
        });

        // Create barangs table
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // Kode khusus, contoh: BRG_1
            $table->string('nama');
            $table->string('kategori');
            $table->integer('harga');
            $table->timestamps();
        });

        // Create penjualans table
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('id_nota')->unique(); // Nota khusus, contoh: NOTA_1
            $table->date('tgl');
            $table->unsignedBigInteger('kode_pelanggan'); // Menggunakan unsignedBigInteger untuk foreign key ke tabel pelanggans
            $table->integer('subtotal');
            $table->foreign('kode_pelanggan')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->timestamps();
        });

        // Create item_penjualans table
        Schema::create('item_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('nota'); // Menggunakan unsignedBigInteger untuk foreign key ke tabel penjualans
            $table->unsignedBigInteger('kode_barang'); // Menggunakan unsignedBigInteger untuk foreign key ke tabel barangs
            $table->integer('qty');
            $table->foreign('nota')->references('id_nota')->on('penjualans')->onDelete('cascade');
            $table->foreign('kode_barang')->references('id')->on('barangs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_penjualans');
        Schema::dropIfExists('penjualans');
        Schema::dropIfExists('barangs');
        Schema::dropIfExists('pelanggans');
    }
};
