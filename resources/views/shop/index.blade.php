@extends('common.default')
@section('contents')
    <div class="clearfix">
        <h4 class="pull-left">商家店铺列表 </h4>
        <a href="{{route('shop.create')}}" class="btn btn-success pull-right">添加店铺</a>
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
                <td>{{$shop->shop_name}}</td>
                <td>@if($shop->shop_img)<img src="{{$shop->shop_img}}" height="50"/>@endif</td>
                <td>{{$shop->shopCategory->name}}</td>
                <td>{{$shop->shop_rating}}</td>
                <td>
                    @if($shop->status==1)<span class="text-success">正常</span>
                    @elseif($shop->status==0)<span class="text-danger">待审核</span>
                    @else禁用@endif
                </td>
                <td>
                    <a href="{{ route('shop.show',[$shop]) }}" class="btn btn-default btn-sm">查看</a>
                    <a href="{{ route('shop.edit',[$shop]) }}" class="btn btn-success btn-sm">修改</a>

                    <form method="post" action="{{route('shop.destroy',[$shop])}}" style="display: inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-warning btn-sm" onclick="return confirm('你确定要删除吗')">删除</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- 分页 -->
    {{ $shops->links() }}

@endsection