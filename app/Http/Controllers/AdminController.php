<?php

namespace App\Http\Controllers;

use App\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //列表
    public function index(){
        $admins=Admin::paginate(10);
        return view('admin.index',compact('admins'));
    }
    //新增
    public function create(){
        return view('admin.add');
    }
    public  function store(Request $request){
        //验证数据
        $res=$this->validate($request,[
            'name' => 'required|min:3|max:20',
            'email' => 'email|unique:admins',
            'password' => [
                'required',
                'regex:/^\w{6,16}$/',
                'confirmed'
            ],
            'password_confirmation' => 'required|same:password',
            'captcha' => 'required|captcha'
        ],[
            'name.required' => '用户名不能为空',
            'name.min' => '用户名不能少于三位',
            'name.max' => '用户名不能多于20位',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '此邮箱已存在',
            'password.required' => '请输入密码',
            'password.regex' => '6-16为密码.可以是数字,字母或下划线',
            'password.confirmed' => "密码与确认密码不匹配",
            'captcha.required' => '请输入验证码',
            'captcha.captcha' => '验证码不正确',
            'password_confirmation.required' => "确认密码不能为空",
            'password_confirmation.same' => '',
        ]);
        if($res==false){ return back()->withInput();}
        Admin::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        return redirect()->route('admin.index')->with('success','管理员添加成功!');
    }
    //修改
    public function edit(Admin $admin){
        return view('admin.edit',compact('admin'));
    }
    public function update(Admin $admin,Request $request){
        //验证
        if($this->validate($request,[
            'email' => 'email',],[
            'email.email' => '邮箱格式不正确',
        ])){ return back()->withInput(); };
        $admin->update([
            'email'=>$request->email,
        ]);
        return redirect()->route('admin.index')->with('success','管理员修改成功!');
    }

    //删除
    public function destroy(Admin $admin){
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
