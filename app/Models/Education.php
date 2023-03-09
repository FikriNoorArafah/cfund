<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    public function interns()
    {
        return $this->belongsToMany(Intern::class, 'intern_educations', 'education_id', 'intern_id');
    }

    protected $fillable = [
        'education_id',
        'name',
    ];
}
