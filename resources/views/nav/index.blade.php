@extends('common.default')
@section('contents')
<div class="clearfix">
	<h4 class="pull-left">菜单列表 </h4>
	<a href="{{route('nav.create')}}" class="btn btn-success pull-right">添加导航</a>
</div>
<table class="table table-bordered ">
	<tr>
		<td>ID</td>
		<td>菜单名称</td>
		<td>网址</td>
		<td>PID</td>
		<td>排序</td>
		<td>操作</td>
	</tr>

	@foreach ($navs as $nav)
		<tr>
			<td>{{ $nav->id }}</td>
			<td><strong>{{ $nav->name}}</strong></td>
			<td>{{ $nav->url}}</td>
			<td>{{ $nav->pid}}</td>
			<td>{{ $nav->sort}}</td>
			<td>
				<a href="{{ route('nav.edit',[$nav]) }}" class="btn btn-success btn-sm">编辑</a>
				<a href="javascript:;" data-href="{{route('nav.destroy',[$nav])}}" class="del_btn btn btn-warning btn-sm">删除</a>
			</td>
		</tr>
	@endforeach
</table>
<!--加载删除的js-->
@include('common._del_btn_js')
@endsection