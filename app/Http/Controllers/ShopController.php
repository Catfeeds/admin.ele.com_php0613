<?php

namespace App\Http\Controllers;
use App\Handlers\ImageUploadHandler;
use App\Model\Advantage;
use App\Model\Shop;
use App\Model\ShopCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //列表
    public function index(){
        $shops=Shop::orderBy('id','desc')->paginate(8);
        return view('shop.index',['shops'=>$shops]);
    }
    //查看
    public function show(){}
    //新增
    public function create(){
        //获取店铺分类
        $cates=ShopCategory::all()->where('status',1);
        //获取服务优势
        $advantages=Advantage::where('isshow','1')->get();
        return view('shop.add',['cates'=>$cates,'advantages'=>$advantages]);
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
        dd(array_sum($request->advantage));
        Shop::create([
            'shop_category_id'=>$request->shop_category_id,
            'shop_name'=>$request->shop_name,
            'advantage'=>array_sum($request->advantage),
            'start_send'=>$request->start_send ?? '0',
            'send_cost'=>$request->send_cost ?? '0',
            'status'=>$request->status,
            'notice'=>$request->notice,
            'discount'=>$request->discount,
            'shop_img'=>$path,
        ]);
        return redirect()->route('shop.index')->with('success','店铺'.$request->name.'添加成功');
    }
    //修改
    public function edit(Shop $shop){
        //获取店铺分类
        $cates=ShopCategory::all()->where('status',1);
        //获取服务优势
        $advantages=Advantage::where('isshow','1')->get();
        return view('shop.edit',compact('shop'),['cates'=>$cates,'advantages'=>$advantages]);
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
        if($request->advantage){$advantage=array_sum($request->advantage);}
        else{$advantage=0;}
        //如果有图片修改
        if ($request->img) {
            $result = $uploader->save($request->img, 'shop','shoplog');
            if ($result) {
                $path = $result['path'];
            }
            //删除原图
            if($shop->img){unlink('.'.$shop->img);}
            //更新数据
            $shop->update([
                'shop_category_id'=>$request->shop_category_id,
                'shop_name'=>$request->shop_name,
                'advantage'=>$advantage,
                'start_send'=>$request->start_send,
                'send_cost'=>$request->send_cost,
                'status'=>$request->status,
                'notice'=>$request->notice,
                'discount'=>$request->discount,
                'shop_img'=>$path,
            ]);

        }else{
            $shop->update([
                'shop_category_id'=>$request->shop_category_id,
                'shop_name'=>$request->shop_name,
                'advantage'=>$advantage,
                'start_send'=>$request->start_send,
                'send_cost'=>$request->send_cost,
                'status'=>$request->status,
                'notice'=>$request->notice,
                'discount'=>$request->discount,
            ]);
        }
        return redirect()->route('shop.index')->with('success','店铺'.$request->name.'修改成功');

    }

    //删除
    public function destroy(Shop $shop)
    {
        $shop->delete();
        return redirect()->route('shop.index')->with('success','删除成功');
    }
}
