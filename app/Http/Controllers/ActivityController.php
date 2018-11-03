<?php

namespace App\Http\Controllers;

use App\Model\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //创建
    public function create(){
        return view('activity.add');
    }
    public function store(Request $request){
        //验证数据
        $this->validate($request,[
            'title'=>'required',
            'content'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
        ],[
            'required'=>'必填',
        ]);
        Activity::create([
            'title'=>$request->title,
            'content'=>$request->content,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time
        ]);
        return redirect()->route('activity.index')->with('success','活动发布成功 !');

    }

    //列表
    public function index(){
        $activities=Activity::paginate(10);
        return view('activity.index',['activities'=>$activities]);
    }
    //未开始
    public function unstart(){
        $activities=Activity::where('start_time','>',date('y-m-d h:i:s',time()))->paginate(10);
        return view('activity.index',['activities'=>$activities]);
    }
    //进行中
    public function ongoing(){
        $activities=Activity::where('end_time','>',date('y-m-d h:i:s',time()))->paginate(10);
        return view('activity.index',['activities'=>$activities]);
    }
    //已完成
    public function complete(){
        $activities=Activity::where('end_time','<',date('y-m-d h:i:s',time()))->paginate(10);
        return view('activity.index',['activities'=>$activities]);
    }

    //修改
    public function edit(Activity $activity){
        return view('Activity.edit',compact('activity'));
    }
    public function update(Activity $activity,Request $request){
    //验证数据
    $this->validate($request,[
        'title'=>'required',
        'content'=>'required',
        'start_time'=>'required',
    ],[
        'required'=>'必填',
    ]);
    $activity->update([
        'title'=>$request->title,
        'content'=>$request->content,
        'start_time'=>$request->start_time,
    ]);
    return redirect()->route('activity.index')->with('success','修改成功! ');
    }
    //删除
    public function destroy(Activity $activity){
        $activity->delete();
        return 'success';
    }

}
