<?php

namespace App\Http\Controllers;
use App\Handlers\ImageUploadHandler;
use App\Model\Advantage;
use App\Model\Shop;
use App\Model\ShopCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        //用户权限验证
        if(!Auth::user()->can('shop.audited')){
            return view('error.noPermission');
        }
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
        //用户权限验证
        if(!Auth::user()->can('shop.close')){
            return view('error.noPermission');
        }
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
    //新增 添加店铺的同时添加店铺账号
    public function create(){
        //用户权限验证
        if(!Auth::user()->can('shop.create')){
            return view('error.noPermission');
        }
        //获取店铺分类
        $cates=ShopCategory::all()->where('status',1);
        return view('shop.add',['cates'=>$cates]);
    }
    public function store(Request $request,ImageUploadHandler $uploader){
        //用户权限验证
        if(!Auth::user()->can('shop.create')){
            return view('error.noPermission');
        }
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
        //保存店铺图片
        $path1='';
        $path2='';
        if ($request->img1) {
            $result = $uploader->save($request->img1, 'shop','shoplogo');
            if ($result) { $path1 = $result['path']; }
        }
        //保存账号图片
        if ($request->img2) {
            $result = $uploader->save($request->img2, 'shop','shoplogo');
            if ($result) { $path2 = $result['path']; }
        }
        //开启事务
        DB::beginTransaction();
        $sql1=DB::table('shops')->insertGetId([
            'shop_category_id'=>$request->shop_category_id,
            'shop_name'=>$request->shop_name,
            'start_send'=>$request->start_send ?? '0',
            'send_cost'=>$request->send_cost ?? '0',
            'status'=>$request->status,
            'notice'=>$request->notice,
            'discount'=>$request->discount,
            'shop_img'=>$path1,
            'brand'=>$request->brand ?? 0,
            'on_time'=>$request->on_time ?? 0,
            'fengniao'=>$request->fengniao ?? 0,
            'bao'=>$request->bao ?? 0,
            'piao'=>$request->piao ?? 0,
            'zhun'=>$request->zhun ?? 0,
        ]);
        $sql2=DB::table('users')->insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'tel'=>$request->tel,
            'password'=>bcrypt($request->password),
            'shop_id'=>$sql1,
            'status'=>1, //平台添加的商户默认启用
            'img'=>$path2,
        ]);
        if($sql1 && $sql2){
            DB::commit();
            return redirect()->route('shop.index')->with('success','店铺'.$request->name.'添加成功');
        }else{
            DB::rollBack();
            return back()->with('danger','店铺添加失败!')->withInput();
        }

    }

    //修改
    public function edit(Shop $shop){
        //用户权限验证
        if(!Auth::user()->can('shop.edit')){
            return view('error.noPermission');
        }
        //获取店铺分类
        $cates=ShopCategory::all()->where('status',1);
        return view('shop.edit',compact('shop'),['cates'=>$cates]);
    }
    public function update(Shop $shop,Request $request,ImageUploadHandler $uploader){
        //用户权限验证
        if(!Auth::user()->can('shop.edit')){
            return view('error.noPermission');
        }
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
        //用户权限验证
        if(!Auth::user()->can('shop.destroy')){
            return view('error.noPermission');
        }
        $shop->delete();
        return 'success';
    }
}
