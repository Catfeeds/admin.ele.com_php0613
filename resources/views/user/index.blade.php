@extends('common.default')
@section('contents')
	<div class="modal-header">
		<h4 class="pull-left">商家账号列表 </h4>
		@can('user.create')<a href="{{route('user.create')}}" class="btn btn-success pull-right">添加账号</a>@endcan
	</div>
	<div class="modal-body clearfix" style="padding: 15px 0px;">
		<form action="{{route('user.index')}}" method="get" class="form-inline pull-left">
			<input type="text" name="keywords" placeholder="姓名/店铺名/邮箱/电话" class="form-control"/>
			{{csrf_field()}}
			<input type="submit" value="搜索" class="btn btn-success"/>
		</form>
	</div>
	<table class="table table-bordered text-center">
		<tr>
			<td>ID</td>
			<td>头像</td>
			<td>姓名</td>
			<td>所属店铺</td>
			<td>邮箱</td>
			<td>手机</td>
			<td>状态</td>
			<td>操作</td>
		</tr>

		@foreach ($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>@if($user->img)<img src="{{$user->img}}" height="40"/>@endif</td>
				<td><strong>{{ $user->name }}</strong></td>
				<td>@if($user->shop_id!=0){{ $user->shop->shop_name }}@endif</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->tel }}</td>
				<td>@if($user->status==1) 正常 @else <span class="text-warning">已禁用</span>  @endif</td>
				<td>@can('user.edit')<a href="{{ route('user.edit',[$user]) }}" class="btn btn-success btn-sm">修改</a>@endcan
					@can('user.resetPassword')<a href="{{ route('user.resetPassword',[$user]) }}" class="btn btn-danger btn-sm">重置密码</a>@endcan
					@can('user.destroy')<a href="javascript:;" data-href="{{route('user.destroy',[$user])}}" class="del_btn btn btn-warning btn-sm">删除</a>@endcan
				</td>
			</tr>
		@endforeach
	</table>
	<!-- 分页 -->
	{{ $users->appends(request()->except('page'))->links() }}
	<!--加载删除的js-->
	@include('common._del_btn_js')
@endsection