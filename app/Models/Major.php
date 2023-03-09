<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $table = 'majors';
    protected $primaryKey = 'major_id';

    // public function intern()
    // {
    //     return $this->hasMany(InternMajor::class, 'major_id');
    // }
    protected $fillable = [
        'major_id',
        'name',
    ];
}
