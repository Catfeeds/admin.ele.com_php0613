<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $fillable=['title','content','signup_start','signup_end','prize_date','signup_num','img','amount','is_prize'];
    //获取报名信息 1对多
    public function prizeMember(){
        return $this->hasMany(PrizeMember::class,'prize_id');
    }
}
