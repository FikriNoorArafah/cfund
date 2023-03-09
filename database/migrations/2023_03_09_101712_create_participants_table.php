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
        Schema::create('participants', function (Blueprint $table) {
            $table->id('participant_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('intern_id');

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('intern_id')->references('intern_id')->on('interns');
            $table->text('cv_url');
            $table->string('schedule')->nullable();
            $table->string('place')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
