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
            'name' => 'Facebook',
            'url_icon' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.hGaetDAQWapgIJbIOhPhXwHaHa%26pid%3DApi&f=1&ipt=aa022992fa87a14ac3ec1bf230fa2bdd7d7462ff628d3c5464a9cb4882ee1754&ipo=images',
        ]);
        DB::table('partners')->insert([
            'name' => 'Twitter',
            'url_icon' => 'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2F1000logos.net%2Fwp-content%2Fuploads%2F2017%2F06%2FTwitter-Logo.png&f=1&nofb=1&ipt=0f218baebb0b619c49612cc5fab5600c97f999a5507d768c5470499acce68763&ipo=images',
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
