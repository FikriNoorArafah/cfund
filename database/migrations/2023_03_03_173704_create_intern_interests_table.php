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
        Schema::create('intern_interests', function (Blueprint $table) {
            $table->unsignedBigInteger('intern_id');
            $table->unsignedBigInteger('interest_id');

            $table->foreign('intern_id')->references('intern_id')->on('interns')->onDelete('cascade');
            $table->foreign('interest_id')->references('interest_id')->on('interests')->onDelete('cascade');

            $table->primary(['intern_id', 'interest_id']);
        });

        DB::table('intern_interests')->insert([
            'intern_id' => '1',
            'interest_id' => '1',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_interests');
    }
};
