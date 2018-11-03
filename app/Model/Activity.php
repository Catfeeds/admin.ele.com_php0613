<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable=['title','content','start_time','end_time'];
}
