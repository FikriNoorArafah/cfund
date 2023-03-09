<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $table = 'interests';
    protected $primaryKey = 'interest_id';
    use HasFactory;
}
