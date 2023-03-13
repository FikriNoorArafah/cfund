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
        Schema::create('abouts', function (Blueprint $table) {
            $table->string('title');
            $table->text('subtitle');
            $table->timestamps();
        });

        DB::table('abouts')->insert([
            'title' => 'Menumbuhkan Harapan, Memberi Kesempatan Untuk Masa Depan',
            'subtitle' => 'Memberikan solusi keuangan bagi generasi muda yang memiliki keinginan untuk meraih cita-cita dan melanjutkan pendidikan ke jenjang yang lebih tinggi. Kami memahami bahwa biaya pendidikan yang tinggi dapat menjadi hambatan bagi banyak orang untuk mencapai impian mereka, itulah mengapa kami hadir untuk memberikan pinjaman dana dengan syarat-syarat yang mudah',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
