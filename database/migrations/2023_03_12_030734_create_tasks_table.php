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
            $table->text('summary_url')->nullable();
            $table->boolean('verified')->default(false);
            $table->timestamps();

            $table->foreign('semester_id')->references('semester_id')->on('semesters')->onDelete('cascade');
            $table->foreign('participant_id')->references('participant_id')->on('participants')->onDelete('cascade');
        });
        DB::table('tasks')->insert([
            [
                'participant_id' => 1,
                'name' => 'Belajar Laravel',
                'semester_id' => 1,
            ],
            [
                'participant_id' => 1,
                'name' => 'Login register Laravel',
                'semester_id' => 1,
            ],
            [
                'participant_id' => 1,
                'name' => 'Routes Laravel',
                'semester_id' => 1,
            ],
            [
                'participant_id' => 1,
                'name' => 'CRUD Laravel',
                'semester_id' => 2,
            ],
            [
                'participant_id' => 1,
                'name' => 'Simple Franchise Web',
                'semester_id' => 3,
            ],
            [
                'participant_id' => 2,
                'name' => 'Belajar Marketing',
                'semester_id' => 1,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
