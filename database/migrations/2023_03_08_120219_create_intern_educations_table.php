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

        DB::table('intern_educations')->insert([
            [
                'intern_id' => 1,
                'education_id' => 5
            ],
            [
                'intern_id' => 2,
                'education_id' => 7
            ],
            [
                'intern_id' => 3,
                'education_id' => 7
            ],
            [
                'intern_id' => 3,
                'education_id' => 8
            ],
            [
                'intern_id' => 4,
                'education_id' => 5
            ],
            [
                'intern_id' => 5,
                'education_id' => 5
            ],
            [
                'intern_id' => 5,
                'education_id' => 6
            ],
            [
                'intern_id' => 6,
                'education_id' => 5
            ],
            [
                'intern_id' => 7,
                'education_id' => 5
            ],
            [
                'intern_id' => 7,
                'education_id' => 6
            ],
            [
                'intern_id' => 8,
                'education_id' => 6
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_educations');
    }
};
