@extends('common.default')
@section('contents')
    <div class="clearfix">
        <h4 class="pull-left">商家分类列表 </h4>
        <a href="{{route('shopCategory.create')}}" class="btn btn-success pull-right">添加分类</a>
    </div>


    <table class="table table-hover table-bordered text-center" >
        <thead>
        <tr class="active">
            <th class="text-center">ID</th>
            <th class="text-center">图片</th>
            <th class="text-center">分类名</th>
            <th class="text-center">状态</th>
            <th class="text-center">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($shopCategorys as $shopCategory)
            <tr>
                <td>{{$shopCategory->id}}</td>
                <td>@if($shopCategory->img)<img src="{{$shopCategory->img}}" height="50"/>@endif</td>
                <td>{{$shopCategory->name}}</td>
                <td>
                    @if($shopCategory->status==1)<span class="text-success">显示</span>@endif
                    @if($shopCategory->status==0)隐藏 @endif
                </td>
                <td>
                    <a href="{{ route('shopCategory.edit',[$shopCategory]) }}" class="btn btn-success btn-sm">修改</a>

                    <form method="post" action="{{route('shopCategory.destroy',[$shopCategory])}}" style="display: inline">
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
    {{ $shopCategorys->links() }}

@endsection