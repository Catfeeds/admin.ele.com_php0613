@extends('common.default')
@section('contents')
	<div class="modal-header">
		<h4 class="pull-left">会员列表 </h4>
		<a href="{{route('member.create')}}" class="btn btn-success pull-right">添加会员</a>
	</div>
	<div class="modal-body clearfix" style="padding: 15px 0px;">
		<form action="{{route('member.index')}}" method="get" class="form-inline pull-left">
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
			<td>手机</td>
			<td>邮箱</td>
			<td>注册时间</td>
			<td>操作</td>
		</tr>

		@foreach ($members as $member)
			<tr>
				<td>{{ $member->id }}</td>
				<td>@if($member->img)<img src="{{$member->img}}" height="40"/>@endif</td>
				<td><strong>{{ $member->username }}</strong></td>
				<td>{{ $member->tel }}</td>
				<td>{{ $member->email }}</td>
				<td>{{ $member->created_at}}</td>
				<td><a href="{{ route('member.edit',[$member]) }}" class="btn btn-success btn-sm">修改</a>
					<a href="{{ route('resetPassword',[$member]) }}" class="btn btn-danger btn-sm">重置密码</a>
					<a href="javascript:;" data-href="{{route('member.destroy',[$member])}}" class="del_btn btn btn-warning btn-sm">删除</a>
				</td>
			</tr>
		@endforeach
	</table>
	<!-- 分页 -->
	{{ $members->links() }}
	<!--加载删除的js-->
	@include('common._del_btn_js')

@endsection