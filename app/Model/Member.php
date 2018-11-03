<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;
    protected $fillable=['username', 'email', 'password','tel','keywords','img'];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
