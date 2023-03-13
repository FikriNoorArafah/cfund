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


    public function educations()
    {
        return $this->belongsToMany(Education::class, 'intern_educations', 'intern_id', 'education_id');
    }

    public function levels()
    {
        return $this->belongsToMany(Education::class, 'intern_levels', 'intern_id', 'level_id');
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'intern_majors', 'intern_id', 'major_id');
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'intern_interests', 'intern_id', 'interest_id');
    }

    public function companies()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function participants()
    {
        return $this->belongsTo(Participant::class, 'intern_id');
    }
}
