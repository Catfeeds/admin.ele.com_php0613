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

Route::get('/', function () {
    return view('welcome');
})->name('index');

//商家分类
Route::resource('shopCategory','ShopCategoryController')->middleware('auth');

//店铺未审核
Route::get('shop/unaudited','ShopController@unaudited')->name('shop.unaudited');
//通过审核
Route::get('shop/{shop}/audited','ShopController@audited')->name('shop.audited');
//关闭店铺
Route::get('shop/{shop}/close','ShopController@close')->name('shop.close');
//查看店铺账号
Route::get('shop/{shop}/users','ShopController@shopUsers')->name('shop.users');
//店铺
Route::resource('shop','ShopController')->middleware('auth');



//添加店铺时添加账号
Route::get('user/add/{shop}','ShopController@add')->name('user.add')->middleware('auth');
//店铺优势
Route::resource('advantage','AdvantageController')->middleware('auth');
Route::get('advantage/recycle','AdvantageController@recycle')->name('advantage.recycle')->middleware('auth');


//账号
Route::resource('user','UserController')->middleware('auth');
//重置密码
Route::get('resetPassword/{user}','UserController@resetPassword')->name('resetPassword');

//管理员
Route::resource('admin','AdminController')->middleware('auth');
Route::post('admin/{admin}','AdminController@setPassword')->name('setPassword');


//管理员登录
Route::get('login','LoginController@login')->name('login');
Route::post('login/store','LoginController@store')->name('login.store');
//退出登陆
Route::get('logout','LoginController@destroy')->name('logout')->middleware('auth');


//活动管理
//未开始
Route::get('activity/unstart','ActivityController@unstart')->name('activity.unstart');
//进行中
Route::get('activity/ongoing','ActivityController@ongoing')->name('activity.ongoing');
//已结束
Route::get('activity/complete','ActivityController@complete')->name('activity.complete');
Route::resource('activity','ActivityController');

//用户会员管理
Route::resource('member','MemberController');