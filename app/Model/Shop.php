<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable=['shop_category_id','shop_name','shop_img','shop_rating','brand','on_time','fengniao','bao','piao','zhun','start_send','send_cost','notice','discount','status'];
    //获取文章的作者 1对多反向
    public function shopCategory(){
        return $this->belongsTo(ShopCategory::class);
    }
}
