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
        Schema::create('semesters', function (Blueprint $table) {
            $table->id('semester_id');
            $table->unsignedBigInteger('participant_id');
            $table->integer('semester_number');
            $table->integer('payment_amount')->nullable();
            $table->string('payment_id')->nullable();
            $table->timestamps();

            $table->foreign('participant_id')->references('participant_id')->on('participants')->onDelete('cascade');
        });

        DB::table('semesters')->insert([
            [
                'participant_id' => 1,
                'semester_number' => 1,
                'payment_amount' => 2000000,
                'payment_id' => 'inipembayarantiputipu',
            ],
            [
                'participant_id' => 1,
                'semester_number' => 2,
                'payment_amount' => 2500000,
                'payment_id' => 'inipembayarantiputipu',
            ],
            [
                'participant_id' => 1,
                'semester_number' => 3,
                'payment_amount' => 2800000,
                'payment_id' => 'inipembayarantiputipu',
            ],
            [
                'participant_id' => 2,
                'semester_number' => 1,
                'payment_amount' => 2000000,
                'payment_id' => 'inipembayarantiputipu',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
