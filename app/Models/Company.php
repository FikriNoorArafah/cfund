<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use HasFactory, HasFactory, Notifiable, Authenticatable;

    protected $primaryKey = 'company_id';

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'username',
        'url_icon',
        'password',
    ];

    public static function generateUsername(string $name): string
    {
        $username = str_replace(' ', '', $name);
        $username = strtolower($username);
        $i = 1;
        while (static::where('username', $username)->exists()) {
            $username = $username . $i;
            $i++;
        }
        return $username;
    }


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
