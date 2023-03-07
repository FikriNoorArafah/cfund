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
        Schema::create('intern_majors', function (Blueprint $table) {
            $table->unsignedBigInteger('intern_id');
            $table->foreign('intern_id')->references('intern_id')->on('interns');
            $table->unsignedBigInteger('major_id');
            $table->foreign('major_id')->references('major_id')->on('majors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_majors');
    }
};
