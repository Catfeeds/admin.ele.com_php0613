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
			<td>操作</td>
		</tr>

		@foreach ($admins as $admin)
			<tr>
				<td>{{ $admin->id }}</td>
				<td><strong>{{ $admin->name }}</strong></td>
				<td>{{ $admin->email }}</td>
				<td><a href="{{ route('admin.edit',[$admin]) }}" class="btn btn-success btn-sm">编辑</a>
					<form method="post" action="{{route('admin.destroy',[$admin])}}" style="display: inline-block">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<button class="btn btn-danger btn-sm ">删除</button>
					</form>
				</td>
			</tr>
		@endforeach
	</table>
	<!-- 分页 -->
	{{ $admins->links() }}

@endsection