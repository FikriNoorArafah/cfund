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
        Schema::create('levels', function (Blueprint $table) {
            $table->id('level_id');
            $table->string('name')->unique();
            $table->decimal('power');
            $table->timestamps();
        });

        DB::table('levels')->insert([
            'name' => 'SD',
            'power' => '10',
        ]);

        DB::table('levels')->insert([
            'name' => 'SMP',
            'power' => '20',
        ]);

        DB::table('levels')->insert([
            'name' => 'SMA',
            'power' => '30',
        ]);

        DB::table('levels')->insert([
            'name' => 'SMK',
            'power' => '30',
        ]);

        DB::table('levels')->insert([
            'name' => 'D1',
            'power' => '31',
        ]);

        DB::table('levels')->insert([
            'name' => 'D2',
            'power' => '32',
        ]);

        DB::table('levels')->insert([
            'name' => 'D3',
            'power' => '33',
        ]);

        DB::table('levels')->insert([
            'name' => 'D4',
            'power' => '40',
        ]);

        DB::table('levels')->insert([
            'name' => 'S1',
            'power' => '40',
        ]);

        DB::table('levels')->insert([
            'name' => 'S2',
            'power' => '50',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
