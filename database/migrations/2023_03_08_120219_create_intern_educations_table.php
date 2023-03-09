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
        Schema::create('intern_educations', function (Blueprint $table) {
            $table->unsignedBigInteger('intern_id');
            $table->foreign('intern_id')->references('intern_id')->on('interns');
            $table->unsignedBigInteger('education_id');
            $table->foreign('education_id')->references('education_id')->on('educations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_educations');
    }
};
