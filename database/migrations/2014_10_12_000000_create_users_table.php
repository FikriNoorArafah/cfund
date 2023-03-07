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
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@careerfund.com',
            'telephone' => '081234567890',
            'username' => 'user',
            'url_icon' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.F7_dhF3xRAyYpc_N7t1jPwHaHa%26pid%3DApi&f=1&ipt=50adfb0d1f73d49f3fae81042bfb0e74942c993a08daf1cf5301570528ad73b9&ipo=images',
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
