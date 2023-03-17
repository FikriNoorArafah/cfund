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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url_icon')->nullable();
            $table->timestamps();
        });
        DB::table('partners')->insert([
            [
                'name' => 'Uber',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046088/careerfund/asset/Uber_b7pvgb.svg',
            ],
            [
                'name' => 'Tesla',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046088/careerfund/asset/Tesla_hk7xum.svg',
            ],
            [
                'name' => 'Meta',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046087/careerfund/asset/Meta_c4noqy.svg',
            ],
            [
                'name' => 'Samsung',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046087/careerfund/asset/Samsung_kv7w44.svg',
            ],
            [
                'name' => 'Google',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046086/careerfund/asset/Google_qqxcfe.svg',
            ],
            [
                'name' => 'Amazon',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046086/careerfund/asset/Amazon_homfh9.svg',
            ],
            [
                'name' => 'Microsoft',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046086/careerfund/asset/Microsoft_uie9d2.svg',
            ],
            [
                'name' => 'Apple',
                'url_icon' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046086/careerfund/asset/Apple_qt76cv.svg',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
