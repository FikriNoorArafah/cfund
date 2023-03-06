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
        Schema::create('helps', function (Blueprint $table) {
            $table->id('help_id');
            $table->string('question');
            $table->text('answer');
            $table->timestamps();
        });

        DB::table('helps')->insert([
            'question' => 'Question Example?',
            'answer' => 'Answer Example',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helps');
    }
};
