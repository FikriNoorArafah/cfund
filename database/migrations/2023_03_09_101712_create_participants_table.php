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
            $table->text('contract_template_url')->nullable();
            $table->text('contract_url')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        DB::table('participants')->insert([
            [
                'user_id' => 1,
                'intern_id' => 1,
                'schedule' => '14 Januari 2022',
                'place' => 'Zoom',
                'cv_url' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679056564/careerfund/cv/PM_Baidouwi_Hakim_CV_g6kemp.pdf',
                'status' => 'success',
                'contract_url' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679056608/careerfund/contract/kontrak_kerja_w6limi.pdf',
            ],
            [
                'user_id' => 1,
                'intern_id' => 2,
                'schedule' => '23 Januari 2023',
                'place' => 'Zoom',
                'cv_url' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679056564/careerfund/cv/PM_Baidouwi_Hakim_CV_g6kemp.pdf',
                'status' => 'accepted',
                'contract_url' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679056608/careerfund/contract/kontrak_kerja_w6limi.pdf',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
