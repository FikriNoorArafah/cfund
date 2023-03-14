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
        return $this->belongsTo(User::class);
    }

    public function interns()
    {
        return $this->belongsTo(Intern::class);
    }

    public function semesters()
    {
        return $this->belongsTo(Semester::class);
    }
}
