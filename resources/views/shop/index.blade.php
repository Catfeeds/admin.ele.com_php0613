@extends('common.default')
@section('contents')
    <div class="modal-header">
        <h4 class="pull-left">商家店铺列表 </h4>
        @can('shop.create')<a href="{{route('shop.create')}}" class="btn btn-success pull-right">添加店铺</a>@endcan
    </div>
    <div class="modal-body clearfix" style="padding: 15px 0px;">
        <form action="{{route('shop.index')}}" method="get" class="form-inline pull-left">
            <select name="shop_category_id" class="form-control">
                <option value=" ">请选择店铺分类</option>
                @foreach($shopCategory as $cate)
                    <option value="{{$cate->id}}" @if(request()->shop_category_id) selected @endif>{{$cate->name}}</option>
                @endforeach
            </select>
            <input type="text" name="keywords" placeholder="关键字" class="form-control" value="{{old('keywords')}}"/>

            {{csrf_field()}}
            <input type="submit" value="搜索" class="btn btn-success"/>
        </form>
        <a href="{{route('shop.unaudited')}}" class="btn btn-default pull-right">未审核 <span class="badge">{{ $unaudited }}</span></a>

    </div>

    <table class="table table-hover table-bordered text-center" >
        <thead>
        <tr class="active">
            <th class="text-center">ID</th>
            <th class="text-center">店铺名称</th>
            <th class="text-center">店铺图片</th>
            <th class="text-center">分类名</th>
            <th class="text-center">评分</th>
            <th class="text-center">状态</th>
            <th class="text-center">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($shops as $shop)
            <tr>
                <td>{{$shop->id}}</td>
                <td><h4><a href="{{ route('shop.show',[$shop]) }}">{{$shop->shop_name}}</a></h4></td>
                <td>@if($shop->shop_img)<img src="{{$shop->shop_img}}" height="50"/>@endif</td>
                <td>{{$shop->shopCategory->name}}</td>
                <td>{{$shop->shop_rating}}</td>
                <td>
                    @if($shop->status==1)<span class="text-success">正常</span>
                    @elseif($shop->status==0)<span class="text-danger">待审核</span>
                    @else禁用@endif
                </td>
                <td>

                    @if($shop->status==0)
                        <a href="{{ route('shop.show',[$shop]) }}" class="btn btn-primary btn-sm">审核</a>
                    @else
                        <a href="{{ route('shop.show',[$shop]) }}" class="btn btn-default btn-sm">查看</a>

                    @endif
                    @can('shop.edit')<a href="{{ route('shop.edit',[$shop]) }}" class="btn btn-success btn-sm">修改</a>@endcan
                    @can('shop.destroy')<a href="javascript:;" data-href="{{route('shop.destroy',[$shop])}}" class="del_btn btn btn-warning btn-sm">删除</a>@endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- 分页 -->
    {{ $shops->appends(request()->except('page'))->links() }}
    <!--加载删除的js-->
    @include('common._del_btn_js')
@endsection