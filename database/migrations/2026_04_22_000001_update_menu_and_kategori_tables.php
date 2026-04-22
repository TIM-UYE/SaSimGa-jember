<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->string('nama_menu')->after('id')->nullable();
            $table->text('deskripsi')->after('nama_menu')->nullable();
            $table->decimal('harga', 12, 2)->after('deskripsi')->nullable();
            $table->unsignedBigInteger('kategori_id')->after('harga')->nullable();
            $table->string('gambar')->after('kategori_id')->nullable();
            $table->boolean('is_available')->after('gambar')->default(true);
            $table->integer('stok')->after('is_available')->default(0);
            $table->string('ukuran')->after('stok')->nullable();
            $table->text('bahan')->after('ukuran')->nullable();
            $table->integer('durasi_persiapan')->after('bahan')->default(15);
        });

        Schema::table('kategori_menu', function (Blueprint $table) {
            $table->string('nama_kategori')->after('id')->nullable();
            $table->text('deskripsi')->after('nama_kategori')->nullable();
            $table->string('ikon')->after('deskripsi')->nullable();
            $table->boolean('is_active')->after('ikon')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropColumn([
                'nama_menu', 'deskripsi', 'harga', 'kategori_id',
                'gambar', 'is_available', 'stok', 'ukuran', 'bahan', 'durasi_persiapan'
            ]);
        });

        Schema::table('kategori_menu', function (Blueprint $table) {
            $table->dropColumn(['nama_kategori', 'deskripsi', 'ikon', 'is_active']);
        });
    }
};
