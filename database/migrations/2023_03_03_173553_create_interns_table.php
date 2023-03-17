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
        Schema::create('interns', function (Blueprint $table) {
            $table->id('intern_id');
            $table->text('description');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('company_id')->on('companies')->onDelete('cascade');
            $table->string('status')->nullable();
            $table->text('skill')->nullable();
            $table->text('require')->nullable();
            $table->timestamps();
        });

        DB::table('interns')->insert([
            [
                'description' => 'Looking for an intern to assist with web development tasks. Must have experience with HTML, CSS, and JavaScript.',
                'company_id' => 1,
                'status' => 'Started',
                'skill' => 'HTML, CSS, JavaScript',
                'require' => 'Experience with web development',
            ],
            [
                'description' => 'We are seeking an intern to help with our social media marketing efforts. Must have experience with Facebook Ads and Google Analytics.',
                'company_id' => 2,
                'status' => 'Open',
                'skill' => 'Facebook Ads, Google Analytics',
                'require' => 'Experience with social media marketing',
            ],
            [
                'description' => 'Frontend web developer internship',
                'company_id' => 1,
                'status' => 'Open',
                'skill' => 'HTML, CSS, JavaScript',
                'require' => 'Currently enrolled in a relevant course',
            ],
            [
                'description' => 'Marketing intern',
                'company_id' => 2,
                'status' => 'Open',
                'skill' => 'Social media, Google Ads, copywriting',
                'require' => 'Strong written and verbal communication skills',
            ],
            [
                'description' => 'Data science intern',
                'company_id' => 3,
                'status' => 'Open',
                'skill' => 'Python, SQL, machine learning',
                'require' => 'Experience with data analysis tools',
                'created_at' => now(),        'updated_at' => now(),
            ],
            [
                'description' => 'Backend developer internship',
                'company_id' => 4,
                'status' => 'Open',
                'skill' => 'PHP, MySQL, Laravel',
                'require' => 'Experience with web development frameworks',
            ],
            [
                'description' => 'Graphic design intern',
                'company_id' => 5,
                'status' => 'Open',
                'skill' => 'Adobe Photoshop, Illustrator, InDesign',
                'require' => 'Experience with graphic design software',
            ],
            [
                'description' => 'Content writing intern',
                'company_id' => 1,
                'status' => 'Open',
                'skill' => 'Copywriting, SEO, blog writing',
                'require' => 'Strong written and verbal communication skills',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
