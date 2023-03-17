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
            $table->timestamps();
        });

        DB::table('whattheysays')->insert([
            [
                'name' => 'John doe',
                'position' => 'Google Front End Developer',
                'quote' => 'Kamu akan bekerja dengan rekan-rekan yang membantumu bertumbuh & jadi versi terbaik diri. Semua orang bersemangat dalam bekerja & punya rasa kepemilikan yang tinggi.',
            ],
            [
                'name' => 'John doe',
                'position' => 'Google Front End Developer',
                'quote' => 'Kamu akan bekerja dengan rekan-rekan yang membantumu bertumbuh & jadi versi terbaik diri. Semua orang bersemangat dalam bekerja & punya rasa kepemilikan yang tinggi.',
            ],
            [
                'name' => 'John doe',
                'position' => 'Google Front End Developer',
                'quote' => 'Kamu akan bekerja dengan rekan-rekan yang membantumu bertumbuh & jadi versi terbaik diri. Semua orang bersemangat dalam bekerja & punya rasa kepemilikan yang tinggi.',
            ],
            [
                'name' => 'John doe',
                'position' => 'Google Front End Developer',
                'quote' => 'Kamu akan bekerja dengan rekan-rekan yang membantumu bertumbuh & jadi versi terbaik diri. Semua orang bersemangat dalam bekerja & punya rasa kepemilikan yang tinggi.',
            ],
            [
                'name' => 'John doe',
                'position' => 'Google Front End Developer',
                'quote' => 'Kamu akan bekerja dengan rekan-rekan yang membantumu bertumbuh & jadi versi terbaik diri. Semua orang bersemangat dalam bekerja & punya rasa kepemilikan yang tinggi.',
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
