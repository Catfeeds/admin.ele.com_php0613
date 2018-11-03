<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Model\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    //新增
    public function create(){
      return view('member.add');
    }
    public function store(Request $request,ImageUploadHandler $uploader){
        //验证数据
        $this->validate($request,[
            'username' => 'required|min:3|max:20',
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
        ],[
            'username.required' => '用户名不能为空',
            'username.min' => '用户名不能少于三位',
            'username.max' => '用户名不能多于20位',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '此邮箱已存在',
            'tel.required' => '手机号不能为空',
            'tel.regex' => '手机号格式不正确',
            'tel.unique' => '电话号码已存在',
            'password.required' => '请输入密码',
            'password.regex' => '6-16为密码.可以是数字,字母或下划线',
            'password.confirmed' => "密码与确认密码不匹配",
            'password_confirmation.required' => "确认密码不能为空",
            'password_confirmation.same' => '',
        ]);
        if($request->img){
            $result = $uploader->save($request->img, 'member','member');
            if ($result) {
                $path = $result['path'];
            }
        }else{$path='';}
        Member::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'tel'=>$request->tel,
            'img'=>$path,
        ]);
        return redirect()->route('member.index')->with('success','添加成功 !');
    }
    //修改
    public function edit(Member $member){
        return view('member.edit',compact('member'));
    }
    public function update(Member $member,Request $request,ImageUploadHandler $uploader){

        //验证数据
        $this->validate($request, [
            'username' => 'required|min:3|max:20',
            'email' => 'email',
            'tel' => [
                'required',
                'regex:/^1[3-9]\d{9}$/',
            ],
        ],[
            'username.required' => '用户名不能为空',
            'username.min' => '用户名不能少于三位',
            'username.max' => '用户名不能多于20位',
            'email.email' => '邮箱格式不正确',
            'tel.required' => '手机号不能为空',
            'tel.regex' => '手机号格式不正确',
        ]);
        //接收图片 保存图片 shopCategory文件夹名 shopcate图片文件名

        if ($request->img) {
            $result = $uploader->save($request->img, 'member','member');
            if ($result) {
                $path = $result['path'];
            }

            //删除原图
            if(is_file($member->img)){unlink('.'.$member->img);}
            $member->update([
                'username'=>$request->username,
                'email'=>$request->email,
                'tel'=>$request->tel,
                'img'=>$path,
            ]);
        }else{
            $member->update([
                'username'=>$request->username,
                'email'=>$request->email,
                'tel'=>$request->tel,
            ]);
        }
        return redirect()->route('member.index')->with('success',$request->name.'修改成功！');

    }

    //列表
    public function index(Request $request){
        if($request->keywords) {
            $members=Member::where('username','like',"%{$request->keywords}%")
                ->orWhere('tel','like',"%{$request->keywords}%")
                ->orWhere('email','like',"%{$request->keywords}%")
                ->paginate(10);
        }else{
            $members=Member::orderBy('created_at','desc')->paginate(10);
        }

        return view('member.index',['members'=>$members]);
    }
    //重置密码
    public function resetPassword(Member $member){
        $string = str_random(6);
        $member->update([
            'password'=>bcrypt($string),
        ]);
        //重置密码后发送邮件
        $username = $member->username;
        Mail::send('email/email',['username'=>$username,'str'=>$string],function($message) use ($member){
            $to = $member->email;
            $message->to($to)->subject('ele购物网会员密码重置成功!');
        });
        return redirect()->route('user.index')->with('success','密码重置成功!');
    }
}
