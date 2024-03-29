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
        Schema::create('majors', function (Blueprint $table) {
            $table->id('major_id');
            $table->string('name');

            $table->timestamps();
        });

        DB::table('majors')->insert([
            ['name' => 'Front End Developer'],
            ['name' => 'Back End Developer'],
            ['name' => 'Data Science'],
            ['name' => 'Graphic Design'],
            ['name' => 'Content Creator'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
