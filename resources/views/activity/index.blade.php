@extends('common.default')
@section('contents')
<div class="clearfix">
	<h4 class="pull-left">活动列表 </h4>
	<div class="pull-right">
		<a href="{{route('activity.unstart')}}" class="btn btn-default">未开始</a>
		<a href="{{route('activity.ongoing')}}" class="btn btn-default">进行中</a>
		<a href="{{route('activity.complete')}}" class="btn btn-default">已结束</a>
		<a href="{{route('activity.create')}}" class="btn btn-success">添加活动</a>
	</div>

</div>
<table class="table table-bordered ">
	<tr>
		<td>ID</td>
		<td>标题</td>
		<td>活动简介</td>
		<td>开始时间</td>
		<td>结束时间</td>
		<td>操作</td>
	</tr>

	@foreach ($activities as $activity)
		<tr>
			<td>{{ $activity->id }}</td>
			<td><strong>{{ $activity->title }}</strong></td>
			<td>
				{{ mb_substr(strip_tags($activity->content),0,50) }}
			</td>
			<td>{{ $activity->start_time }}</td>
			<td>{{ $activity->end_time }}</td>
			<td>
				<a href="{{ route('activity.edit',[$activity]) }}" class="btn btn-success btn-sm">编辑</a>
				<a href="javascript:;" data-href="{{route('activity.destroy',[$activity])}}" class="del_btn btn btn-warning btn-sm">删除</a>
			</td>
		</tr>
	@endforeach
</table>
<!-- 分页 -->
{{ $activities->links() }}
<!--加载删除的js-->
@include('common._del_btn_js')
@endsection