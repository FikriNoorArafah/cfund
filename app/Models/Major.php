<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $table = 'majors';

    public function intern()
    {
        return $this->belongsTo('App\Models\Intern');
    }
    protected $fillable = [
        'major_id',
        'name',
    ];
}
