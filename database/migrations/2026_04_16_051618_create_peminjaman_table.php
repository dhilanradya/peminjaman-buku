<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->integer('jumlah')->default(1); // tambahkan ini
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali')->nullable();
            $table->date('tgl_kembali_actual')->nullable();
            $table->integer('denda')->default(0);
            $table->enum('status_denda', ['Tidak Ada Denda', 'Belum Dibayar', 'Sudah Dibayar'])
                  ->default('Tidak Ada Denda');
            $table->enum('status', ['Menunggu', 'Diterima', 'Menunggu Pengembalian', 'Dikembalikan'])
                ->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
};
