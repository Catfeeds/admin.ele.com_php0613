<?php

namespace App\Http\Controllers;

use App\Model\ShopCategory;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;

class ShopCategoryController extends Controller
{
    
    //列表
    public function index(){
        $shopCategorys=ShopCategory::paginate(10);
        return view('shopCategory.index',['shopCategorys'=>$shopCategorys]);
    }
    //查看
    public function show(){}
    //新增
    public function create(){
        return view('shopCategory.add');
    }
    public function store(Request $request,ImageUploadHandler $uploader){

       //验证数据
       if($this->validate($request,[
           'name'=>'required|min:2|unique:shop_categories',
       ],['name.required'=>'分类名不能为空',
           'name.min'=>'分类名不能少于2个字',
            'name.unique'=>'分类名已存在',
           ])==false){
           return back()->withInput();
       }
        //接收图片 保存图片 shopCategory文件夹名 shopcate图片文件名
        if ($request->img) {
            $result = $uploader->save($request->img, 'shopCategory','shopcate');
            if ($result) {
                $path = $result['path'];
            }
        }else{$path='';}
        ShopCategory::create([
            'name'=>$request->name,
            'status'=>$request->status,
            'img'=>$path,
        ]);
        return redirect()->route('shopCategory.index')->with('success','分类 '.$request->name.' 添加成功');
    }
    //修改
    public function edit(ShopCategory $shopCategory){
        return view('shopCategory.edit',compact('shopCategory'));
    }
    public function update(ShopCategory $shopCategory,Request $request,ImageUploadHandler $uploader){
        //验证数据
        if($this->validate($request,[
                'name'=>'required|min:2',
            ],['name.required'=>'分类名不能为空',
                'name.min'=>'分类名不能少于2个字',
            ])==false){
            return back()->withInput();
        }
        //如果有图片修改
        if ($request->img) {
            $result = $uploader->save($request->img, 'shopCategory','shopcate');
            if ($result) {
                $path = $result['path'];
            }
            //删除原图
            if($shopCategory->img){unlink('.'.$shopCategory->img);}
            //更新数据
            $shopCategory->update([
                'name'=>$request->name,
                'status'=>$request->status,
                'img'=>$path,
            ]);

        }else{
            $shopCategory->update([
                'name'=>$request->name,
                'status'=>$request->status,
            ]);
        }


        return redirect()->route('shopCategory.index')->with('success','分类'.$request->name.'修改成功');

    }

    //删除
    public function destroy(ShopCategory $shopCategory)
    {
        $shopCategory->delete();
        return redirect()->route('shopCategory.index')->with('success','删除成功');
    }
}
