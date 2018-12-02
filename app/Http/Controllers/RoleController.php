<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    //添加角色
    public function create(){
        //用户权限验证
        if(!Auth::user()->can('role.create')){
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
        return view('role.add',compact('permissions'));
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

    //保存添加的角色
    public function store(Request $request){
        //用户权限验证
        if(!Auth::user()->can('role.create')){
            return view('error.noPermission');
        }
        $this->validate($request,[
            'name'=>'required | unique:roles,name',
        ],[
            'name.required'=>'角色名称必填',
            'name.unique'=>'角色名已存在',
        ]);
        $role=Role::create([ 'name'=>$request->name,]);
        //同时添加多个权限
        $role->syncPermissions($request->permission);
        return redirect()->route('role.index')->with('success','添加成功!');
    }
    //角色列表
    public function index(){
        $roles=Role::paginate(10);
        return view('role.index',['roles'=>$roles]);
    }
    public function edit(Role $role){
        //用户权限验证
        if(!Auth::user()->can('role.edit')){
            return view('error.noPermission');
        }
        //从角色权限表里读出该角色的权限
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
        return view('role.edit',compact('role','permissions'));
    }
    public function update(Role $role,Request $request){
        //用户权限验证
        if(!Auth::user()->can('role.edit')){
            return view('error.noPermission');
        }
        $role->update([ 'name' => $request->name]);
        //同时更新多个权限
        $role->syncPermissions($request->permission);
        return redirect()->route('role.index')->with('success','修改成功!');
    }
    public function destroy(Role $role){
        //用户权限验证
        if(!Auth::user()->can('role.destroy')){
            return view('error.noPermission');
        }
        $role->delete();
        return 'success';
    }
}
