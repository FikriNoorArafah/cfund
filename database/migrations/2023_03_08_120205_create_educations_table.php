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
        Schema::create('educations', function (Blueprint $table) {
            $table->id('education_id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('educations')->insert([
            ['name' => 'SD'],
            ['name' => 'SMP'],
            ['name' => 'SMA'],
            ['name' => 'SMK'],
            ['name' => 'D1'],
            ['name' => 'D2'],
            ['name' => 'D3'],
            ['name' => 'D4'],
            ['name' => 'S1'],
            ['name' => 'S2']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
