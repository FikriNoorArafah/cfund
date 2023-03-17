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
        Schema::create('intern_departments', function (Blueprint $table) {
            $table->unsignedBigInteger('intern_id');
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('intern_id')->references('intern_id')->on('interns')->onDelete('cascade');
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
        });

        DB::table('intern_departments')->insert([
            ['intern_id' => 1, 'department_id' => 1],
            ['intern_id' => 2, 'department_id' => 1],
            ['intern_id' => 3, 'department_id' => 1],
            ['intern_id' => 4, 'department_id' => 1],
            ['intern_id' => 5, 'department_id' => 1],
            ['intern_id' => 6, 'department_id' => 1],
            ['intern_id' => 7, 'department_id' => 1],
            ['intern_id' => 8, 'department_id' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_departments');
    }
};
