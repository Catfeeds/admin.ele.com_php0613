<?php

namespace App\Http\Controllers;
use App\Handlers\ImageUploadHandler;
use App\Model\Advantage;
use App\Model\Shop;
use App\Model\ShopCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    //列表
    public function index(Request $request){
        $shopCategory=ShopCategory::where('status',1)->get();
        $wheres=[];
        if($request->shop_category_id){
            $wheres[]=['shop_category_id',$request->shop_category_id];
        }
        if($request->keywords){
            $wheres[]=['shop_name','like',"%{$request->keywords}%"];
      }

        $shops=Shop::where($wheres)->paginate(10);
        if(count($shops)==0){
            return redirect()->route('shop.index')->with('danger','没有符合条件的商品');
        }
        //未审核
        $unaudited=count(Shop::where('status',0)->get());
        return view('shop.index',['shops'=>$shops,'shopCategory'=>$shopCategory,'unaudited'=>$unaudited]);
    }

    //未审核
    public function unaudited(){
        $shopCategory=ShopCategory::where('status',1)->get();
        $shops=Shop::where('status',0)
            ->paginate(10);
        //未审核
        $unaudited=count($shops);
        return view('shop.index',['shops'=>$shops,'shopCategory'=>$shopCategory,'unaudited'=>$unaudited]);
    }

    //店铺通过审核,同时所属账号也通过审核
    public function audited(Shop $shop){
        DB::transaction(function() use($shop) {
            $shop->update([
                'status' => 1,
            ]);
            User::where('shop_id', $shop->id)->update([
                'status' => 1,
            ]);
        });
        return back()->with('success', '审核通过!');
    }
    //关闭店铺同时禁用所有账号
    public function close(Shop $shop){
        DB::transaction(function() use($shop) {
            $shop->update([
                'status' => -1,
            ]);
            User::where('shop_id', $shop->id)->update([
                'status' => -1,
            ]);
        });
        return back()->with('success','店铺已关闭!');
    }
    //查询店铺管理员账号
    public function shopUsers(Shop $shop){
        $users=User::where('shop_id',$shop->id)->paginate(10);
        return view('user.index',['users'=>$users]);
    }


    //查看
    public function show(Shop $shop){
        return view('shop.show',compact('shop'));
    }
    //新增
    public function create(){
        //获取店铺分类
        $cates=ShopCategory::all()->where('status',1);
        return view('shop.add',['cates'=>$cates]);
    }
    public function store(Request $request,ImageUploadHandler $uploader){
        //验证数据
        if($this->validate($request,[
                'shop_name'=>'required|unique:shops',
                'shop_category_id'=>'required',
            ],[
                'shop_name.required'=>'店铺名不能为空',
                'shop_name.unique'=>'店铺名已存在',
                'shop_category_id.required'=>'请选择店铺分类'
            ])==false){
            return back()->withInput();
        }

        //接收图片 保存图片 shopCategory文件夹名 shopcate图片文件名
        if ($request->img) {
            $result = $uploader->save($request->img, 'shop','shoplogo');
            if ($result) {
                $path = $result['path'];
            }
        }else{$path='';}
        $shop=Shop::create([
            'shop_category_id'=>$request->shop_category_id,
            'shop_name'=>$request->shop_name,
            'start_send'=>$request->start_send ?? '0',
            'send_cost'=>$request->send_cost ?? '0',
            'status'=>$request->status,
            'notice'=>$request->notice,
            'discount'=>$request->discount,
            'shop_img'=>$path,
            'brand'=>$request->brand ?? 0,
            'on_time'=>$request->on_time ?? 0,
            'fengniao'=>$request->fengniao ?? 0,
            'bao'=>$request->bao ?? 0,
            'piao'=>$request->piao ?? 0,
            'zhun'=>$request->zhun ?? 0,
        ]);
        return redirect()->route('user.add',['shop'=>$shop])->with('success','店铺'.$request->name.'添加成功');
    }
    //注册店铺时添加
    public function add(shop $shop){
        return view('user.add',compact('shop'));
    }
    //修改
    public function edit(Shop $shop){
        //获取店铺分类
        $cates=ShopCategory::all()->where('status',1);
        return view('shop.edit',compact('shop'),['cates'=>$cates]);
    }
    public function update(Shop $shop,Request $request,ImageUploadHandler $uploader){
        //验证数据
        if($this->validate($request,[
                'shop_name'=>'required',
                'shop_category_id'=>'required',
            ],[
                'shop_name.required'=>'店铺名不能为空',
                'shop_category_id.required'=>'请选择店铺分类'
            ])==false){
            return back()->withInput();
        }
        //如果有图片修改
        if ($request->img) {
            $result = $uploader->save($request->img, 'shop','shoplog');
            if ($result) {
                $path = $result['path'];
            }
            //删除原图
            if(is_file($shop->shop_img)){unlink('.'.$shop->shop_img);}
            //更新数据
            $shop->update([
                'shop_category_id'=>$request->shop_category_id,
                'shop_name'=>$request->shop_name,
                'start_send'=>$request->start_send,
                'send_cost'=>$request->send_cost,
                'status'=>$request->status,
                'notice'=>$request->notice,
                'discount'=>$request->discount,
                'brand'=>$request->brand ?? 0,
                'on_time'=>$request->on_time ?? 0,
                'fengniao'=>$request->fengniao ?? 0,
                'bao'=>$request->bao ?? 0,
                'piao'=>$request->piao ?? 0,
                'zhun'=>$request->zhun ?? 0,
                'shop_img'=>$path,
            ]);

        }else{
            $shop->update([
                'shop_category_id'=>$request->shop_category_id,
                'shop_name'=>$request->shop_name,
                'start_send'=>$request->start_send,
                'send_cost'=>$request->send_cost,
                'status'=>$request->status,
                'notice'=>$request->notice,
                'discount'=>$request->discount,
                'brand'=>$request->brand ?? 0,
                'on_time'=>$request->on_time ?? 0,
                'fengniao'=>$request->fengniao ?? 0,
                'bao'=>$request->bao ?? 0,
                'piao'=>$request->piao ?? 0,
                'zhun'=>$request->zhun ?? 0,
            ]);
        }
        return redirect()->route('shop.index')->with('success','店铺'.$request->name.'修改成功');

    }

    //删除
    public function destroy(Shop $shop)
    {
        $shop->delete();
        return 'success';
    }
}
