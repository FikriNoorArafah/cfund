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
        Schema::create('interests', function (Blueprint $table) {
            $table->id('interest_id');
            $table->string('name');
            $table->string('desc');
            $table->timestamps();
        });

        DB::table('interests')->insert([
            'name' => 'Teknologi',
            'desc' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Optio asperiores repellat facere ut voluptatum placeat ratione. Sapiente tempore sed, eos ad architecto rerum eveniet odio provident excepturi placeat id deserunt.'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interests');
    }
};
