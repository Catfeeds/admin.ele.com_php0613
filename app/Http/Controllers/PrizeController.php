<?php

namespace App\Http\Controllers;


use App\Handlers\ImageUploadHandler;
use App\Model\Prize;
use App\Model\PrizeMember;
use App\User;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    //抽奖活动
    //新增
    public function create(){
        return view('prize.add');
    }
    //保存新增
    public function store(Request $request,ImageUploadHandler $uploader){
        //验证
        $this->validate($request,[
            'title'=>'required',
            'content'=>'required',
            'amount'=>'required',
            'signup_end'=>'required',
            'prize_date'=>'required',
            'signup_num'=>'required',
        ],[
            'required'=>'必填'
        ]);
        if($request->img){
            $result = $uploader->save($request->img, 'prize','tryprize');
            if ($result) {
                $path = $result['path'];
            }
        }else{$path='';}
        Prize::create([
            'title'=>$request->title,
            'content'=>$request->content,
            'signup_start'=>strtotime($request->signup_start),
            'signup_end'=>strtotime($request->signup_end),
            'prize_date'=>$request->prize_date,
            'signup_num'=>$request->signup_num,
            'amount'=>$request->amount,
            'is_prize'=>0,
            'img'=>$path,
        ]);
        return redirect()->route('prize.index')->with('success','发布成功!');
    }
    //修改
    public function edit(Prize $prize){
        if($prize->signup_end <= time()){
            return back()->with('danger'.'报名已截止,不能修改!');
        }
        return view('prize.edit',compact('prize'));
    }
    //保存修改
    public function update(Prize $prize,Request $request){
        //验证
        $this->validate($request,[
            'title'=>'required',
            'content'=>'required',
            'amount'=>'required',
            'signup_end'=>'required',
            'prize_date'=>'required',
            'signup_num'=>'required',
        ],[
            'required'=>'必填'
        ]);
        if($request->img){
            $result = $uploader->save($request->img, 'prize','tryprize');
            if ($result) {
                $path = $result['path'];
            }
            $prize->update([
                'title'=>$request->title,
                'content'=>$request->content,
                'signup_start'=>strtotime($request->signup_start),
                'signup_end'=>strtotime($request->signup_end),
                'prize_date'=>$request->prize_date,
                'signup_num'=>$request->signup_num,
                'amount'=>$request->amount,
                'is_prize'=>0,
                'img'=>$path,
            ]);
        }else{
            $prize->update([
                'title'=>$request->title,
                'content'=>$request->content,
                'signup_start'=>strtotime($request->signup_start),
                'signup_end'=>strtotime($request->signup_end),
                'prize_date'=>$request->prize_date,
                'signup_num'=>$request->signup_num,
                'amount'=>$request->amount,
                'is_prize'=>0,
                ]);
        }

        return redirect()->route('prize.index')->with('success','修改成功!');
    }
    //删除
    public function destroy(Prize $prize){
        $prize->delete();
        return 'success';
    }
    //查看
    public function show(Prize $prize){
        if($prize->is_prize==1){
            //查出中奖名单
            $prizeMembers=PrizeMember::where('prize_id',$prize->id)->where('is_won',1)->get();
            $woner=[];
            foreach ($prizeMembers as $prizeMember){
                $woner[]=User::find($prizeMember->member_id);
            }
            return view('prize.show',compact('prize','woner'));
        }else{
            //查找出报名人数
            $prize['member']=PrizeMember::where('prize_id',$prize->id)->get();
            return view('prize.show',compact('prize'));
        }

    }
    //列表
    public function index(){
        $prizes=Prize::orderBy('id','desc')->paginate(10);
        return view('prize.index',compact('prizes'));
    }
    //未开始
    public function unstart(){
        $prizes=Prize::where('signup_start','>',time())->paginate(10);
        return view('prize.index',compact('prizes'));
    }
    //进行中
    public function ongoing(){
        $prizes=Prize::where('signup_end','>',time())->paginate(10);
        return view('prize.index',compact('prizes'));
    }
    //已完成
    public function complete(){
        $prizes=Prize::where('prize_date','<',date('y-m-d h:i:s',time()))->paginate(10);
        return view('prize.index',compact('prizes'));
    }

    //开奖
    public function openPrize(Prize $prize){
        //查询出当前试用的报名人数
        $prizemembers=PrizeMember::where('prize_id',$prize->id)->get();
        $count=count($prizemembers);
        //查询出试用品的个数
        $prize_num=$prize->amount;
        //报名人数 > 奖品个数时
        if($count>$prize_num){
            //从总人数中取出随机数的个数等于试用品的数量
            //将报名人数从0,到count列成一个数组
            $numbers=range(0,$count);
            //随机打乱数组
            shuffle($numbers);
            //取出中奖者的报名次序
            $result = array_slice($numbers,1,$prize_num);
            $woner=[];
            foreach($result as $v){
                //按照中奖的顺序找出中奖对象,并标记is_won=1
                $prizeMember=PrizeMember::where('prize_id',$prize->id)->orderBy('id','asc')
                    ->offset($v)->limit(1)->first();
                $prizeMember->update([
                    'is_won'=>1,
                ]);
                //同时奖品表显示已开奖
                $prize->update([
                    'is_prize'=>1,
                ]);
                //通过user表查出中奖用户
                $woner[]=User::find($prizeMember->id);
            }
            return view('prize.show',compact('woner','prize'));
        }else{
            //报名人数 < 试用品个数
            return back()->with('danger','报名人数没有达到开奖标准!');
        }


    }
}
