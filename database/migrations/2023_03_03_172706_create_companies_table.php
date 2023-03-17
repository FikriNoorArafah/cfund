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
        Schema::create('companies', function (Blueprint $table) {
            $table->id('company_id');
            $table->string('name');
            $table->string('email');
            $table->string('username');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telephone')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('postal')->nullable();
            $table->text('url_icon')->nullable();
            $table->text('rememberToken')->nullable();
            $table->timestamps();
        });

        DB::table('companies')->insert([
            [
                'name' => 'Facebook',
                'email' => 'Facebook@careerfund.com',
                'username' => 'Facebook',
                'password' => bcrypt('Facebook'),
                'region' => 'USA',
                'city' => 'NEW YORK',
                'postal' => '23415',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679053252/careerfund/company/Facebook_WC_uy8nos.svg',
            ],
            [
                'name' => 'Twitter',
                'email' => 'Twitter@careerfund.com',
                'username' => 'Twitter',
                'password' => bcrypt('Twitter'),
                'region' => 'USA',
                'city' => 'NEW YORK',
                'postal' => '23415',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679053252/careerfund/company/Twitter_WC_o7vpt0.svg',
            ],
            [
                'name' => 'Google',
                'email' => 'Google@careerfund.com',
                'username' => 'Google',
                'password' => bcrypt('Google'),
                'region' => 'USA',
                'city' => 'NEW YORK',
                'postal' => '23415',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679053252/careerfund/company/Google_WC_sctd3w.svg',
            ],
            [
                'name' => 'Spotify',
                'email' => 'Spotify@careerfund.com',
                'username' => 'Spotify',
                'password' => bcrypt('Spotify'),
                'region' => 'USA',
                'city' => 'NEW YORK',
                'postal' => '23415',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679053252/careerfund/company/Spotify_WC_h1sxch.svg',
            ],
            [
                'name' => 'Paypal',
                'email' => 'Paypal@careerfund.com',
                'username' => 'Paypal',
                'password' => bcrypt('Paypal'),
                'region' => 'USA',
                'city' => 'NEW YORK',
                'postal' => '23415',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679053252/careerfund/company/PayPal_1_WC_sxrpzq.svg',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
