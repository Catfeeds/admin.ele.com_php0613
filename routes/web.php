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
});

//商家分类
Route::resource('shopCategory','ShopCategoryController');


//店铺
Route::resource('shop','ShopController');
//店铺优势
Route::resource('advantage','AdvantageController');
Route::get('advantage/recycle','AdvantageController@recycle')->name('advantage.recycle');

//账号
Route::resource('user','UserController');

//管理员登录
Route::get('login/form','LoginController@login')->name('login');
Route::post('login/store','LoginController@store')->name('login.store');
//退出登陆
Route::get('logout','LoginController@destroy')->name('logout');
