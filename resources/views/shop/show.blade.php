@extends('common.default')
@section('contents')
<div class="modal-header">
    <h1 class="text-center">{{$shop->shop_name}}</h1>
</div>
<div class="modal-body">
    <ul class="list-group">
        <li class="list-group-item">店铺分类：{{$shop->shopCategory->name}}</li>
        <li class="list-group-item">店铺优势：
            <span style="margin-right: 20px">@if($shop->brand==1) 品牌@endif</span>
            <span style="margin-right: 20px">@if($shop->on_time==1) 准时送达@endif</span>
            <span style="margin-right: 20px"> @if($shop->fengniao==1) 蜂鸟配送@endif</span>
            <span style="margin-right: 20px">@if($shop->bao==1) 保标记@endif</span>
            <span style="margin-right: 20px">@if($shop->piao==1) 票标记@endif</span>
            <span style="margin-right: 20px">@if($shop->zhun==1) 准标记@endif</span>

        </li>
        <li class="list-group-item">起送金额：{{$shop->start_send}}</li>
        <li class="list-group-item">配 送 费：{{$shop->send_cost}}</li>
        <li class="list-group-item">店铺状态：@if($shop->status==1)
                <span class="text-success">正常</span>
            @elseif($shop->status==0)
                <span class="text-danger">待审核</span>
            @else
                <strong class="text-danger">禁用</strong>
            @endif</li>
        <li class="list-group-item">店铺公告：{{$shop->notice}}</li>
        <li class="list-group-item">优惠信息：{{$shop->discount}}</li>
        <li class="list-group-item">店铺图片：@if($shop->shop_img)
                <img src="{{$shop->shop_img}} " width="200"/>@endif</li>
    </ul>

    <div class="row">
        <label class="col-sm-3"></label>
        @if($shop->status==0)
        <div class="col-sm-2">
            <a href="{{ route('shop.audited',[$shop]) }}" class="btn btn-primary btn-block">通过审核</a>
        </div>
        @elseif($shop->status==-1)
        <div class="col-sm-2">
            <a href="{{ route('shop.audited',[$shop]) }}" class="btn btn-danger btn-block">店铺已禁用，重新开启</a>
        </div>
        @else
        <div class="col-sm-2">
            <a href="{{ route('shop.close',[$shop]) }}" class="btn btn-warning btn-block">关闭店铺</a>
        </div>
        @endif
        <div class="col-sm-2">
            <a href="{{ route('shop.edit',[$shop]) }}" class="btn btn-success btn-block">编辑店铺资料</a>
        </div>
        <div class="col-sm-2">
            <a href="{{ route('shop.users',[$shop]) }}" class="btn btn-default btn-block">查看店铺账号</a>
        </div>
    </div>
</div>


@endsection