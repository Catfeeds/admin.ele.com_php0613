@extends('common.default')
@section('contents')
	<div class="modal-header">
		<h4 class="pull-left">商家账号列表 </h4>
		<a href="{{route('user.create')}}" class="btn btn-success pull-right">添加账号</a>
	</div>
	<div class="modal-body clearfix" style="padding: 15px 0px;">
		<form action="{{route('user.index')}}" method="get" class="form-inline pull-left">
			<input type="text" name="keywords" placeholder="姓名/店铺名/邮箱/电话" class="form-control"/>
			{{csrf_field()}}
			<input type="submit" value="搜索" class="btn btn-success"/>
		</form>
	</div>
	<table class="table table-bordered ">
		<tr>
			<td>ID</td>
			<td>头像</td>
			<td>姓名</td>
			<td>所属店铺</td>
			<td>邮箱</td>
			<td>手机</td>
			<td>操作</td>
		</tr>

		@foreach ($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>@if($user->img)<img src="{{$user->img}}" height="40"/>@endif</td>
				<td><strong>{{ $user->name }}</strong></td>
				<td>{{ $user->shop->shop_name }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->tel }}</td>
				<td><a href="{{ route('user.edit',[$user]) }}" class="btn btn-success btn-sm">修改</a>
					<a href="{{ route('resetPassword',[$user]) }}" class="btn btn-danger btn-sm">重置密码</a>
					<form method="post" action="{{route('user.destroy',[$user])}}" style="display: inline-block">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<button class="btn btn-warning btn-sm ">删除</button>
					</form>
				</td>
			</tr>
		@endforeach
	</table>
	<!-- 分页 -->
	{{ $users->links() }}

@endsection