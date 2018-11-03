<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Model\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller{

    public function __construct(){
        //权限验证
        $this->middleware('auth', [
            'except' => ['index']
        ]);
    }

    //注册
    public function create(){
        $shops=Shop::all();
        return view('user.add',['shops'=>$shops]);
    }

    //保存注册数据
    public function store(Request $request,ImageUploadHandler $uploader){
        //验证数据
        $val=$this->validate($request, [
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
            'captcha' => 'required|captcha',
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
        if($val==false){ return back()->withInput();}
        //接收图片 保存图片 shopCategory文件夹名 shopcate图片文件名
        if ($request->img) {
            $result = $uploader->save($request->img, 'shopusre','user');
            if ($result) {
                $path = $result['path'];
            }
        }else{$path='';}
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'tel'=>$request->tel,
            'password'=>bcrypt($request->password),
            'shop_id'=>$request->shop_id,
            'status'=>$request->status,
            'img'=>$path,
        ]);
        return redirect()->route('user.index')->with('success','店铺管理 '.$request->name.' 账号添加成功！');
    }

    //用户首页
    public function index(){

        $keywords=$_GET['keywords'] ?? '';
        if($keywords!=''){
            $users=User::where('name','like','%'.$keywords.'%')
                //->orWhere('shop_name','like','%'.$keywords.'%')
                ->orWhere('tel','like','%'.$keywords.'%')
                ->orWhere('email','like','%'.$keywords.'%')
                ->paginate(10);
        }else{
            $users=User::paginate(10);
        }
        if(count($users)==0){
            return redirect()->route('user.index')->with('danger','没有符合条件的商品');
        }
        return view('user.index',compact('users'));
    }

    //修改
    public function edit(User $user){
        $shops=Shop::all();
        return view('user/edit',compact('user'),['shops'=>$shops]);
    }
    public function update(User $user,Request $request,ImageUploadHandler $uploader){
        $val=$this->validate($request, [
            'name' => 'required|min:3|max:20',
            'email' => 'email',
            'tel' => [
                'required',
                'regex:/^1[3-9]\d{9}$/',
            ],
            'captcha' => 'required|captcha'
        ],[
            'name.required' => '用户名不能为空',
            'name.min' => '用户名不能少于三位',
            'name.max' => '用户名不能多于20位',
            'email.email' => '邮箱格式不正确',
            'tel.required' => '手机号不能为空',
            'tel.regex' => '手机号格式不正确',
            'captcha.required' => '请输入验证码',
            'captcha.captcha' => '验证码不正确',
        ]);
        if($val==false){ return back()->withInput();}
        //接收图片 保存图片 shopCategory文件夹名 shopcate图片文件名
        if ($request->img) {
            $result = $uploader->save($request->img, 'shopusre','user');
            if ($result) {
                $path = $result['path'];
            }
            //删除原图
            if($user->img){unlink('.'.$user->img);}
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'tel'=>$request->tel,
                'password'=>bcrypt($request->password),
                'shop_id'=>$request->shop_id,
                'status'=>$request->status,
                'img'=>$path,
            ]);
        }else{
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'tel'=>$request->tel,
                'password'=>bcrypt($request->password),
                'shop_id'=>$request->shop_id,
                'status'=>$request->status,
            ]);
        }
        return redirect()->route('user.index')->with('success',$request->name.'修改成功！');

    }

    //重置密码
    public function resetPassword(User $user){
        $string = str_random(6);
        $user->update([
            'password'=>bcrypt($string),
        ]);
        //重置密码后发送邮件
        $name = $user->name;
        Mail::send('email/email',['name'=>$name,'str'=>$string],function($message) use ($user){
            $to = $user->email;
            $message->to($to)->subject('ele购物网密码充值成功!');
        });
         return redirect()->route('user.index')->with('success','密码重置成功!');


    }

    //删除
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success','删除成功');
    }

}
