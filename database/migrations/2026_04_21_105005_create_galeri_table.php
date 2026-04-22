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
        Schema::create('galeri', function (Blueprint $table) {
            $table->id('galeri_id');
            $table->string('judul');
            $table->string('gambar');
            $table->unsignedBigInteger('profil_id');
            $table->unsignedBigInteger('promosi_id')->nullable();
            $table->timestamps();

            $table->foreign('profil_id')->references('profil_id')->on('profil_usaha')->onDelete('cascade');
            $table->foreign('promosi_id')->references('promosi_id')->on('promosi')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
