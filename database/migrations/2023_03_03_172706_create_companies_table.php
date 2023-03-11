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
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telephone')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('postal')->nullable();
            $table->string('detail')->nullable();
            $table->text('url_icon')->nullable();
            $table->timestamps();
        });

        DB::table('companies')->insert([
            'name' => 'Facebook',
            'email' => 'Facebook@careerfund.com',
            'username' => 'Facebook',
            'password' => bcrypt('Facebook'),
            'region' => 'usa',
            'city' => 'new york',
            'postal' => '23415',
            'detail' => 'by meta',
            'url_icon' => 'https://oduvbujtzradsetbgtxm.supabase.co/storage/v1/object/sign/src/Logo.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzcmMvTG9nby5wbmciLCJpYXQiOjE2NzgwMzUzMTMsImV4cCI6MTcwOTU3MTMxM30.n_ccn8nTcp8HA4ORIewNyk1yr4huHsyfbtyivLpO3KM&t=2023-03-05T16%3A55%3A14.087Z',
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
