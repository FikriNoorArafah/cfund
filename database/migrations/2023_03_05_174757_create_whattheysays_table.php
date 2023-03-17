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
        Schema::create('whattheysays', function (Blueprint $table) {
            $table->id('wts_id');
            $table->string('name');
            $table->string('position');
            $table->text('quote');
            $table->text('icon_url');
            $table->timestamps();
        });

        DB::table('whattheysays')->insert([
            [
                'name' => 'John doe',
                'position' => 'Google Front End Developer',
                'quote' => 'Kamu akan bekerja dengan rekan-rekan yang membantumu bertumbuh & jadi versi terbaik diri. Semua orang bersemangat dalam bekerja & punya rasa kepemilikan yang tinggi.',
                'icon_url' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046798/careerfund/user/male_portrait_profile_social_media_cv_young_elegant_suit-459413_bperfh.jpg',
            ],
            [
                'name' => 'John doe',
                'position' => 'Google Front End Developer',
                'quote' => 'Kamu akan bekerja dengan rekan-rekan yang membantumu bertumbuh & jadi versi terbaik diri. Semua orang bersemangat dalam bekerja & punya rasa kepemilikan yang tinggi.',
                'icon_url' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046798/careerfund/user/male_portrait_profile_social_media_cv_young_elegant_suit-459413_bperfh.jpg',
            ],
            [
                'name' => 'John doe',
                'position' => 'Google Front End Developer',
                'quote' => 'Kamu akan bekerja dengan rekan-rekan yang membantumu bertumbuh & jadi versi terbaik diri. Semua orang bersemangat dalam bekerja & punya rasa kepemilikan yang tinggi.',
                'icon_url' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046798/careerfund/user/male_portrait_profile_social_media_cv_young_elegant_suit-459413_bperfh.jpg',
            ],
            [
                'name' => 'John doe',
                'position' => 'Google Front End Developer',
                'quote' => 'Kamu akan bekerja dengan rekan-rekan yang membantumu bertumbuh & jadi versi terbaik diri. Semua orang bersemangat dalam bekerja & punya rasa kepemilikan yang tinggi.',
                'icon_url' => 'https://res.cloudinary.com/dzv0ki3hh/image/upload/v1679046798/careerfund/user/male_portrait_profile_social_media_cv_young_elegant_suit-459413_bperfh.jpg',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whattheysays');
    }
};
