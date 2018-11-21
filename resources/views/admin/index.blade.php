@extends('common.default')
@section('contents')
	<div class="clearfix">
		<h4 class="pull-left">管理员列表 </h4>
		<a href="{{route('admin.create')}}" class="btn btn-success pull-right">添加管理员</a>
	</div>
	<table class="table table-bordered ">
		<tr>
			<td>ID</td>
			<td>姓名</td>
			<td>邮箱</td>
			<td>角色</td>
			<td>操作</td>
		</tr>

		@foreach ($admins as $admin)
			<tr>
				<td>{{ $admin->id }}</td>
				<td><strong>{{ $admin->name }}</strong></td>
				<td>{{ $admin->email }}</td>
				<td>@foreach($admin->getRoleNames() as $role){{$role}} @endforeach</td>
				<td><a href="{{ route('admin.edit',[$admin]) }}" class="btn btn-success btn-sm">编辑</a>
					@can('admin.destroy')<a href="javascript:;" data-href="{{route('admin.destroy',[$admin])}}" class="del_btn btn btn-warning btn-sm">删除</a>@endcan
				</td>
			</tr>
		@endforeach
	</table>
	<!-- 分页 -->
	{{ $admins->links() }}
	<!--加载删除的js-->
	@include('common._del_btn_js')
@endsection