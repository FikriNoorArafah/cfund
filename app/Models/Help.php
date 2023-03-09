<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Help extends Model
{
    protected $table = 'helps';
    protected $primaryKey = 'help_id';
    use HasFactory;
}
