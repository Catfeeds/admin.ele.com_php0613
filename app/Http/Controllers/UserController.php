<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //注册
    public function create(){
        return view('user.add');
    }
    //保存注册数据
    public function store(Request $request){
        //验证数据
        $validator = Validator::make($request->input(), [
            'name' => 'required|min:3|max:20',
            'email' => 'email|unique:users',
            'tel' => [
                'required',
                'regex:/^1[3-9]\d{9}$/',
                'unique:users'
            ],
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
            'tel.required' => '手机号不能为空',
            'tel.regex' => '手机号格式不正确',
            'tel.unique' => '电话号码已存在',
            'password.required' => '请输入密码',
            'password.regex' => '6-16为密码.可以是数字,字母或下划线',
            'password.confirmed' => "密码与确认密码不匹配",
            'captcha.required' => '请输入验证码',
            'captcha.captcha' => '验证码不正确',
            'password_confirmation.required' => "确认密码不能为空",
            'password_confirmation.same' => '',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->file('img')){
            $path=$request->file('img')->store('public/user');
            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'tel'=>$request->tel,
                'password'=>bcrypt($request->password),
                'img'=>$path
            ]);
        }else {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'tel' => $request->tel,
                'password' => bcrypt($request->password),
            ]);
        }
        $this->sendEmail($request->name,$request->email);
        return redirect()->route('login')->with('success',$request->name.'恭喜你,注册成功！');
    }

    //用户首页
    public function index()
    {
        $user = Auth::user();
        return view('user.index',['user'=>$user]);
    }

    //列表
    public function list(){
        $users=User::orderBy('id','desc')->paginate(5);
        return view('user.list',['users'=>$users]);
    }

    //查看
    public function show(User $user){
        return view('user/show',compact('user'));
    }

    //修改
    public function edit(User $user){
        return view('user/edit',compact('user'));

    }
    public function update(User $user,Request $request){
        //验证数据
        $validator = Validator::make($request->input(), [
            'name' => 'required|min:3|max:20',
            'email' => 'email',
        ],[
            'name.required' => '用户名不能为空',
            'name.min' => '用户名不能少于三位',
            'name.max' => '用户名不能多于20位',
            'email.email' => '邮箱格式不正确',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->file('img')){
            $path=$request->file('img')->store('public/user');
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'tel'=>$request->tel,
                'img'=>$path
            ]);
        }else{
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'tel'=>$request->tel,
            ]);
        }

        return redirect()->route('login')->with('success',$request->name.'修改成功,你现在可以登录了！');

    }


    //删除
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.list')->with('success','删除成功');
    }

}
