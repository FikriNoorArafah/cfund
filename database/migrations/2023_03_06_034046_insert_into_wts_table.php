<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('whattheysays')->insert([
            'name' => 'John doe',
            'position' => 'Google Front End Developer',
            'comment' => 'Kamu akan bekerja dengan rekan-rekan yang membantumu bertumbuh & jadi versi terbaik diri. Semua orang bersemangat dalam bekerja & punya rasa kepemilikan yang tinggi.',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            //
        });
    }
};
