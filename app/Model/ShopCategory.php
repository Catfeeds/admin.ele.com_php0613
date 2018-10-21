<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    //可接收的变量
    protected $fillable=['name','img','status'];
}
