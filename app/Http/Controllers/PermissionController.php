<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    //添加权限 名称和路由一致
    public function create(){
        //用户权限验证
        if(!Auth::user()->can('permission.create')){
            return view('error.noPermission');
        }
        $permissions=Permission::all();
        //重构permission格式 使它可以分组显示
        $datas=[];
        foreach($permissions as $permission){
            $data=[
                'id'=>$permission->id,
                'name'=>$permission->name,
                'explain'=>$permission->explain,
                'pid'=>$permission->pid,
            ];
            $datas[]=$data;
        }
        $permissions=$this->getDatas($datas,0);
        return view('permission.add',compact('permissions'));
    }
    //递归重新给datas排序
    public function getDatas($datas,$pid){
        static $result=[]; //定义一个静态变量用于储存排序后的结果
        foreach($datas as $v){
            if($v['pid']==$pid){
                $result[]=$v;
                $this->getDatas($datas,$v['id']); //递归入口调用自己
            }
        }
        return $result;
    }

    //保存添加的权限
    public function store(Request $request){
        //用户权限验证
        if(!Auth::user()->can('permission.create')){
            return view('error.noPermission');
        }
        $this->validate($request,[
            'name'=>'required | unique:permissions',
        ],[
            'name.required'=>'权限名称必填',
            'name.unique'=>'权限名已存在',
        ]);
        Permission::create([ 'name'=>$request->name,
            'explain'=>$request->explain,
            'pid'=>$request->pid ?? 0,
            ]);
        return redirect()->route('permission.index')->with('success','添加成功!');
    }
    //权限列表
    public function index(){
        $permissions=Permission::orderBy('id','desc')->paginate(10);
        return view('permission.index',compact('permissions'));
    }
    public function edit(Permission $permission)
    {
        //用户权限验证
        if(!Auth::user()->can('permission.edit')){
            return view('error.noPermission');
        }
        $permissions=Permission::all();
        //重构permission格式 使它可以分组显示
        $datas=[];
        foreach($permissions as $per){
            $dat=[
                'id'=>$per->id,
                'name'=>$per->name,
                'explain'=>$per->explain,
                'pid'=>$per->pid,
            ];
            $datas[]=$dat;
        }
        $datas=$this->getDatas($datas,0);
        return view('permission.edit', compact('datas','permission'));
    }
    public function update(Permission $permission,Request $request){
        //用户权限验证
        if(!Auth::user()->can('permission.edit')){
            return view('error.noPermission');
        }
        $permission->update([
            'name' => $request->name,
            'explain'=>$request->explain,
            'pid'=>$request->pid ?? 0,]);
        return redirect()->route('permission.index')->with('success','修改成功!');
    }
    public function destroy(Permission $permission){
        //用户权限验证
        if(!Auth::user()->can('permission.destroy')){
            return view('error.noPermission');
        }
        $permission->delete();
        return 'success';
    }
}
