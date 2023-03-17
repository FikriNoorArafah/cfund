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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name');
            $table->string('second_name')->nullable();
            $table->string('email');
            $table->string('telephone');
            $table->string('username');
            $table->text('url_icon')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('postal')->nullable();
            $table->string('education')->nullable();
            $table->text('rememberToken')->nullable();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name' => 'Frankie',
            'second_name' => 'Tobias',
            'email' => 'FrankieTobias@careerfund.com',
            'telephone' => '081234567890',
            'username' => 'FrankieTobias',
            'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046798/careerfund/user/male_portrait_profile_social_media_cv_young_elegant_suit-459413_bperfh.jpg',
            'password' => bcrypt('Frankie123'),
            'region' => 'Indonesia',
            'city' => 'Jakarta',
            'postal' => '15324',
            'education' => 'S1',
        ]);
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
