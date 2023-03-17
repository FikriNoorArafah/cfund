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

        DB::table('intern_majors')->insert([
            [
                'intern_id' => '1',
                'major_id' => '1',
            ],
            [
                'intern_id' => '2',
                'major_id' => '5',
            ],
            [
                'intern_id' => '3',
                'major_id' => '1',
            ],
            [
                'intern_id' => '4',
                'major_id' => '3',
            ],
            [
                'intern_id' => '5',
                'major_id' => '5',
            ],
            [
                'intern_id' => '6',
                'major_id' => '2',
            ],
            [
                'intern_id' => '7',
                'major_id' => '4',
            ],
            [
                'intern_id' => '8',
                'major_id' => '5',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_majors');
    }
};
