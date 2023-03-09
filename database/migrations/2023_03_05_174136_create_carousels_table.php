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
        Schema::create('carousels', function (Blueprint $table) {
            $table->id('carousel_id');
            $table->string('image_name');
            $table->text('url_image');
            $table->string('meta_image')->nullable();
            $table->timestamps();
        });

        DB::table('carousels')->insert([
            'image_name' => "Carousel 1",
            'url_image' => "https://oduvbujtzradsetbgtxm.supabase.co/storage/v1/object/sign/src/1134392.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzcmMvMTEzNDM5Mi5wbmciLCJpYXQiOjE2NzgzNTQ5MTIsImV4cCI6MTcwOTg5MDkxMn0.3m-mV50a0A6tgDR3pOFX6W7ZiDIIoosol96yT1rDXI8&t=2023-03-09T09%3A41%3A55.948Z",
            'meta_image' => "Carousel meta",
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousels');
    }
};
