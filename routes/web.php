<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('index');
//})->name('index');

//商家分类
Route::resource('shopCategory','ShopCategoryController')->middleware('auth');

//店铺未审核
Route::get('shop/unaudited','ShopController@unaudited')->name('shop.unaudited')->middleware('auth');
//通过审核
Route::get('shop/{shop}/audited','ShopController@audited')->name('shop.audited')->middleware('auth');
//关闭店铺
Route::get('shop/{shop}/close','ShopController@close')->name('shop.close')->middleware('auth');
//查看店铺账号
Route::get('shop/{shop}/users','ShopController@shopUsers')->name('shop.users')->middleware('auth');
//店铺
Route::resource('shop','ShopController')->middleware('auth');



//添加店铺时添加账号
Route::get('user/add/{shop}','ShopController@add')->name('user.add')->middleware('auth');


//商家账号
Route::resource('user','UserController')->middleware('auth');
//商家账号重置密码
Route::get('user/resetPassword/{user}','UserController@resetPassword')->name('user.resetPassword')->middleware('auth');;

//管理员
Route::resource('admin','AdminController')->middleware('auth')->middleware('auth');;
Route::post('admin/{admin}','AdminController@setPassword')->name('setPassword')->middleware('auth');;


//管理员登录
Route::get('login','LoginController@login')->name('login');
Route::post('login/store','LoginController@store')->name('login.store');
//退出登陆
Route::get('logout','LoginController@destroy')->name('logout')->middleware('auth');


//活动管理
//未开始
Route::get('activity/unstart','ActivityController@unstart')->name('activity.unstart')->middleware('auth');
//进行中
Route::get('activity/ongoing','ActivityController@ongoing')->name('activity.ongoing')->middleware('auth');
//已结束
Route::get('activity/complete','ActivityController@complete')->name('activity.complete')->middleware('auth');
Route::resource('activity','ActivityController')->middleware('auth');

//用户会员管理
Route::resource('member','MemberController')->middleware('auth');
//会员账号重置密码
Route::get('Member/resetPassword/{member}','MemberController@resetPassword')->name('member.resetPassword')->middleware('auth');

//首页
Route::get('/','CountController@index')->name('index')->middleware('auth');
//权限管理RBAC
Route::resource('permission','PermissionController')->middleware('auth');
//角色管理
Route::resource('role','RoleController')->middleware('auth');
//导航菜单管理
Route::resource('nav','NavController')->middleware('auth');

//试用抽奖活动
//未开始
Route::get('prize/unstart','PrizeController@unstart')->name('prize.unstart')->middleware('auth');
//进行中
Route::get('prize/ongoing','PrizeController@ongoing')->name('prize.ongoing')->middleware('auth');
//已结束
Route::get('prize/complete','PrizeController@complete')->name('prize.complete')->middleware('auth');
//开奖
Route::get('prize/{prize}/openPrize','PrizeController@openPrize')->name('prize.openPrize')->middleware('auth');
Route::resource('prize','PrizeController')->middleware('auth');

