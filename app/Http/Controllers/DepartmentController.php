<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function createTables()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id('department_id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('intern_departments', function (Blueprint $table) {
            $table->unsignedBigInteger('intern_id');
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('intern_id')->references('intern_id')->on('interns')->onDelete('cascade');
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
        });

        return response()->json(['message' => 'Tables created successfully.']);
    }

    public function insertData()
    {
        DB::table('departments')->insert([
            ['name' => 'Fakultas Komputer'],
            ['name' => 'Fakultas Teknik'],
            ['name' => 'Fakultas Kedokteran'],
        ]);
        DB::table('intern_departments')->insert([
            ['intern_id' => 1, 'department_id' => 1],
        ]);
        return response()->json(['message' => 'Data inserted successfully.']);
    }
}
