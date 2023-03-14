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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('task_id');
            $table->unsignedBigInteger('participant_id');
            $table->string('name');
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->text('description')->nullable();
            $table->text('summary_url')->nullable();
            $table->boolean('verified')->default(false);
            $table->timestamps();

            $table->foreign('semester_id')->references('semester_id')->on('semesters')->onDelete('cascade');
            $table->foreign('participant_id')->references('participant_id')->on('participants')->onDelete('cascade');
        });
        DB::table('tasks')->insert([
            'participant_id' => 3,
            'name' => 'Belajar Laravel',
            'semester_id' => 1,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
