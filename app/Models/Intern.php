<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;

    protected $table = 'interns';
    protected $primaryKey = 'intern_id';

    protected $fillable = [
        'intern_id',
        'name',
        'description',
        'address',
        'company_id',
        'start',
        'close',
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function educations()
    {
        return $this->belongsToMany(Education::class, 'intern_educations', 'intern_id', 'education_id');
    }

    public function majors()
    {
        return $this->hasMany('App\Models\Major');
    }
}
