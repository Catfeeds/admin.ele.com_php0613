<?php

namespace App\Http\Controllers;

use App\Model\Nav;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class NavController extends Controller
{

    //添加导航
    public function create(){
        //用户权限验证
        if(!Auth::user()->can('nav.create')){
            return view('error.noPermission');
        }
        $navs=Nav::all();
        $permissions=Permission::all();
        return view('nav.add',compact('navs','permissions'));
    }
    //保存添加的导航
    public function store(Request $request){
        //用户权限验证
        if(!Auth::user()->can('nav.create')){
            return view('error.noPermission');
        }
        //验证
        $this->validate($request,[
            'name'=>'required| unique:navs',
            'url'=>'required',
            'permission'=>'required',
        ],[
            'name.required'=>'导航名必填',
            'name.unique'=>'导航名已存在',
            'url.required'=>'链接地址必填',
            'permission.required'=>'请选择权限路由',
        ]);
        Nav::create([
            'name'=>$request->name,
            'url'=>$request->url,
            'pid'=>$request->pid ?? 0,
            'permission_id'=>$request->permission,
            'sort'=>$request->sort,
        ]);
        return redirect()->route('nav.index')->with('success','菜单添加成功!');
    }

    //修改导航菜单
    public function edit(Nav $nav){
        //用户权限验证
        if(!Auth::user()->can('nav.edit')){
            return view('error.noPermission');
        }
        $navs=Nav::all();
        $permissions=Permission::all();
        return view('nav.edit',compact('nav','navs','permissions'));
    }
    public function update(Nav $nav,Request $request){
        //用户权限验证
        if(!Auth::user()->can('nav.edit')){
            return view('error.noPermission');
        }
        //验证
        $this->validate($request,[
            'name'=>'required',
            'url'=>'required',
            'permission'=>'required',
        ],[
            'name.required'=>'导航名必填',
            'url.required'=>'链接地址必填',
            'permission.required'=>'请选择权限路由',
        ]);
        $nav->update([
            'name'=>$request->name,
            'url'=>$request->url,
            'sort'=>$request->sort,
            'permission_id'=>$request->permission,
            'pid'=>$request->pid ?? 0,
        ]);
        return redirect()->route('nav.index')->with('success','菜单修改成功!');
    }

    //列表
    public function index(){
        $navs=Nav::all();
        return view('nav.index',compact('navs'));
    }
    //删除
    public function destroy(Nav $nav){
        //用户权限验证
        if(!Auth::user()->can('nav.destroy')){
            return view('error.noPermission');
        }
        $nav->delete();
        return 'success';
    }
}
