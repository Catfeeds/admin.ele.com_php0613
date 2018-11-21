<?php

namespace App\Http\Controllers;

use App\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    //列表
    public function index(){
        $admins=Admin::paginate(10);
        return view('admin.index',compact('admins'));
    }
    //新增
    public function create(){
        //用户权限验证
        if(!Auth::user()->can('admin.create')){
            return view('error.noPermission');
        }
        //查询出角色
        $roles=Role::all();
        return view('admin.add',compact('roles'));
    }
    public  function store(Request $request){
        //用户权限验证
        if(!Auth::user()->can('admin.create')){
            return view('error.noPermission');
        }
        //验证数据
        $this->validate($request,[
            'name' => 'required|min:3|max:20|unique:admins',
            'email' => 'email|unique:admins',
            'password' => [
                'required',
                'regex:/^\w{6,16}$/',
                'confirmed'
            ],
            'password_confirmation' => 'required|same:password',
            'role'=>'required',
        ],[
            'name.required' => '用户名不能为空',
            'name.min' => '用户名不能少于三位',
            'name.max' => '用户名不能多于20位',
            'name.unique' => '用户名已存在',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '此邮箱已存在',
            'password.required' => '请输入密码',
            'password.regex' => '6-16为密码.可以是数字,字母或下划线',
            'password.confirmed' => "密码与确认密码不匹配",
            'password_confirmation.required' => "确认密码不能为空",
            'password_confirmation.same' => '',
            'role.required'=>'请选择用户角色',
        ]);

        $admin=Admin::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);

        //给admin 添加赋予角色
        $admin->assignRole($request->role);
        return redirect()->route('admin.index')->with('success','管理员添加成功!');
    }
    //修改
    public function edit(Admin $admin){
        //用户权限验证
        if(!Auth::user()->can('admin.edit')){
            return view('error.noPermission');
        }
        //查询出角色
        $roles=Role::all();
        return view('admin.edit',compact('admin','roles'));
    }
    public function update(Admin $admin,Request $request){
        //用户权限验证
        if(!Auth::user()->can('admin.edit')){
            return view('error.noPermission');
        }
        //验证
        $this->validate($request,[
            'email' => 'email',],[
            'email.email' => '邮箱格式不正确',
        ]);
        $admin->update([
            'email'=>$request->email,
        ]);
        //这个地方有bug,没有权限管理员修改自己的资料时权限会重置
        //更新角色
        $admin->syncRoles($request->role);
        return redirect()->route('admin.index')->with('success','管理员修改成功!');
    }

    //删除
    public function destroy(Admin $admin){
        //用户权限验证
        if(!Auth::user()->can('admin.destroy')){
            return view('error.noPermission');
        }
        $admin->delete();
        return redirect()->route('admin.index')->with('success','删除成功');
    }

    //修改密码
    public function show(Admin $admin){
        return view('admin.editpwd',compact('admin'));
    }
    public function setPassword(Admin $admin,Request $request){
        //验证
        $this->validate($request,[
            'oldpassword'=>'required',
            'password' => ['required', 'regex:/^\w{6,16}$/', 'confirmed','different:oldpassword'],
            'password_confirmation' => 'required|same:password',
        ],[
            'oldpassword.required' => '请输入旧密码',
            'password.required' => '请输入密码',
            'password.regex' => '6-16为密码.可以是数字,字母或下划线',
            'password.confirmed' => '密码与确认密码不一致',
            'password.different' => '新密码不能和旧密码相同',
            'password_confirmation.required' => "确认密码不能为空",
            'password_confirmation.same' => '',
        ]);
        if(Hash::check($request->oldpassword, $admin->password)){
            $admin->update([
                'password'=>bcrypt($request->password),
            ]);
            Auth::logout(); //修改成功后退出登陆
        }else{
            return back()->withInput();
        }
        return redirect()->route('login')->with('success','密码修改成功！请重新登陆');

    }

}
