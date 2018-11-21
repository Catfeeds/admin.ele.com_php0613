<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    protected $guard_name = 'web'; //或者你想要使用的任何警卫
    //
    protected $fillable=['name', 'email', 'password',];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
