<?php

namespace App\Http\Controllers;

use App\Model\Advantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvantageController extends Controller
{
    //列表
    public function index(){
        $advantages=Advantage::where('isshow','1')->orderBy('id','desc')->paginate(10);
        return view('advantage.index',['advantages'=>$advantages]);
    }
    //查看
    public function show(){}
    //新增
    public function create(){
        return view('advantage.add');
    }
    public function store(Request $request){

        //验证数据
        if($this->validate($request,[
                'name'=>'required|unique:advantages',
            ],['name.required'=>'优势名不能为空',
                'name.unique'=>'优势名已存在',
            ])==false){
            return back()->withInput();
        }
        //获取总条数
        $count=DB::table( 'advantages' )->count();
        $value=2**$count;
        Advantage::create([
            'name'=>$request->name,
            'value'=>$value,
        ]);
        return redirect()->route('advantage.index')->with('success','店铺优势 '.$request->name.' 添加成功');
    }
    //修改
    public function edit(Advantage $advantage){
        return view('advantage.edit',compact('advantage'));
    }
    public function update(Advantage $advantage,Request $request){
        //验证数据
        if($this->validate($request,[
                'name'=>'required|unique:advantages',
            ],['name.required'=>'优势名不能为空',
                'name.unique'=>'未做任何修改',
            ])==false){
            return back()->withInput();
        }
        //更新数据
        $advantage->update([
            'name'=>$request->name,
        ]);
        return redirect()->route('advantage.index')->with('success','分类'.$request->name.'修改成功');

    }

    //删除
    public function destroy(Advantage $advantage)
    {
        $advantage->update(['isshow'=>'0']);
        return redirect()->route('advantage.index')->with('success','删除成功');
    }
    //回收站
    public function recycle(){
        dd('123');
        $advantages=Advantage::where('isshow','0')->paginate(10);
        return view('advantage.recycle',['advantages'=>$advantages]);
    }
}
