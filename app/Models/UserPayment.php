<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    use HasFactory;
    protected $table = 'user_payments';
    protected $primaryKey = 'id_payment';

    protected $fillable = [
        'type',
        'credit_number'
    ];
}
