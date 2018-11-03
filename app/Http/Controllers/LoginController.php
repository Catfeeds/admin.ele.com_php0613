<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    //用户登录
    public function login(){
        return view('admin/login');
    }
    public function store(Request $request){
        if(Auth::attempt(['name'=>$request->name,'password'=>$request->password],$request->has('remember'))){
            return redirect()->intended(route('admin.index'))->with('success','登录成功'); //intended 跳转到登陆之前的页面
        }else{
            return back()->with('danger','用户名或密码错误,请重新登陆')->withInput();
        }


    }
    //退出登陆
    public function destroy(){
        Auth::logout();
        return redirect('/')->with('success','您已成功退出登陆');

    }


}
