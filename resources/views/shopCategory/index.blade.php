@extends('common.default')
@section('contents')
    <div class="clearfix">
        <h4 class="pull-left">商家分类列表 </h4>
        @can('shopCategory.create')<a href="{{route('shopCategory.create')}}" class="btn btn-success pull-right">添加分类</a>@endcan
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
                    @can('shopCategory.edit')<a href="{{ route('shopCategory.edit',[$shopCategory]) }}" class="btn btn-success btn-sm">修改</a>@endcan
                    @can('shopCategory.destroy')<a href="javascript:;" data-href="{{route('shopCategory.destroy',[$shopCategory])}}" class="del_btn btn btn-warning btn-sm">删除</a>@endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- 分页 -->
    {{ $shopCategorys->links() }}
    <!--加载删除的js-->
    @include('common._del_btn_js')

@endsection