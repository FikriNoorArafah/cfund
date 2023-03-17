<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $table = 'participants';
    protected $primaryKey = 'participant_id';
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function interns()
    {
        return $this->belongsTo(Intern::class, 'intern_id');
    }

    public function majors()
    {
        return $this->intern->majors();
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class, 'participant_id');
    }
}
