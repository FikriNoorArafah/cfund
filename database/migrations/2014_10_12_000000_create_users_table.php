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
            $table->string('email')->unique();
            $table->string('telephone')->unique();
            $table->string('username')->unique();
            $table->text('url_icon')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('postal')->nullable();
            $table->string('education')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@careerfund.com',
            'telephone' => '081234567890',
            'username' => 'user',
            'url_icon' => 'https://oduvbujtzradsetbgtxm.supabase.co/storage/v1/object/sign/src/Logo.png?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cmwiOiJzcmMvTG9nby5wbmciLCJpYXQiOjE2NzgzNTQ5NDAsImV4cCI6MTcwOTg5MDk0MH0.xa8ZHdGdQz5xLalc80MKYg0mdydYn4hz3dwPOPYWMjs&t=2023-03-09T09%3A42%3A24.512Z',
            'password' => bcrypt('user'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
