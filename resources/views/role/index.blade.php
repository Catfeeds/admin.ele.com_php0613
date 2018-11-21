@extends('common.default')
@section('contents')
<div class="clearfix">
	<h4 class="pull-left">角色列表 </h4>
	<a href="{{route('role.create')}}" class="btn btn-success pull-right">添加角色</a>
</div>
<table class="table table-bordered ">
	<tr>
		<td>ID</td>
		<td>角色名称</td>
		<td>操作</td>
	</tr>

	@foreach ($roles as $role)
		<tr>
			<td>{{ $role->id }}</td>
			<td><strong>{{ $role->name}}</strong></td>
			<td>
				<a href="{{ route('role.edit',[$role]) }}" class="btn btn-success btn-sm">编辑</a>
				<a href="javascript:;" data-href="{{route('role.destroy',[$role])}}" class="del_btn btn btn-warning btn-sm">删除</a>
			</td>
		</tr>
	@endforeach
</table>
<!-- 分页 -->
{{ $roles->links() }}
<!--加载删除的js-->
@include('common._del_btn_js')
@endsection