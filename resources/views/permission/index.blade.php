@extends('common.default')
@section('contents')
<div class="clearfix">
	<h4 class="pull-left">权限列表 </h4>
	<a href="{{route('permission.create')}}" class="btn btn-success pull-right">添加权限</a>
</div>
<table class="table table-bordered ">
	<tr>
		<td>ID</td>
		<td>权限名称</td>
		<td>备注</td>
		<td>操作</td>
	</tr>

	@foreach ($permissions as $permission)
		<tr>
			<td>{{ $permission->id }}</td>
			<td><strong>{{ $permission->name}}</strong></td>
			<td>{{ $permission->explain}}</td>
			<td>
				<a href="{{ route('permission.edit',[$permission]) }}" class="btn btn-success btn-sm">编辑</a>
				<a href="javascript:;" data-href="{{route('permission.destroy',[$permission])}}" class="del_btn btn btn-warning btn-sm">删除</a>
			</td>
		</tr>
	@endforeach
</table>
<!-- 分页 -->
{{ $permissions->links() }}
<!--加载删除的js-->
@include('common._del_btn_js')
@endsection