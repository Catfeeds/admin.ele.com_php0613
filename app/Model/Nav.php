<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class Nav extends Model
{
    protected $fillable=['name','url','pid','permission_id','sort'];

    public static function getNavs(){
        $user=Auth::user();
        //获取所有一级菜单
        $navs=Nav::where('pid',0)->orderBy('sort','asc')->get();
        $html=''; //用于保存整个导航的html
        $nav_html=''; //用于保存一个导航菜单的html
        if($user){
            //遍历一级菜单
            foreach($navs as $nav){
                //获取该一级菜单的子菜单
                $children=Nav::where('pid',$nav['id'])->get();
                $children_html='';
                foreach($children as $child){
                    //can('此处用权限名不能用id')
                    $permission=Permission::find($child['permission_id'])->name;
                    if ($user->can($permission)){
                        $children_html .= '<li><a href="' . $child['url'] . '">' . $child['name'] . '</a></li>';
                    }
                }
                if($children_html){
                    $nav_html.= '<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$nav->name.'<span class="caret"></span></a>
                        <ul class="dropdown-menu">';
                    $nav_html.=$children_html;
                    $nav_html.='</ul></li>';
                }elseif(count($nav)==1){
                    $permission=Permission::find($nav['permission_id'])->name;
                    if ($user->can($permission)) {
                        $nav_html .= '<li><a href="' . $nav['url'] . '">' . $nav['name'] . '<span class="sr-only">(current)</span></a></li>';
                    }
                }
            }
            $html=$nav_html;
        }
        return $html;
    }

}
