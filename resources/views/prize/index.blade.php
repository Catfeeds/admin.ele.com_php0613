@extends('common.default')
@section('contents')
<div class="clearfix">
	<h4 class="pull-left">活动列表 </h4>
	<div class="pull-right">
		<a href="{{route('prize.unstart')}}" class="btn btn-default">未开始</a>
		<a href="{{route('prize.ongoing')}}" class="btn btn-default">进行中</a>
		<a href="{{route('prize.complete')}}" class="btn btn-default">已结束</a>
		<a href="{{route('prize.create')}}" class="btn btn-success">添加活动</a>
	</div>

</div>
<table class="table table-bordered ">
	<tr>
		<td>ID</td>
		<td>标题</td>
		<td>开始时间</td>
		<td>结束时间</td>
		<td>人数限制</td>
		<td>开奖日期</td>
		<td>是否已开奖</td>
		<td>操作</td>
	</tr>

	@foreach ($prizes as $prize)
		<tr>
			<td>{{ $prize->id }}</td>
			<td><a href="{{route('prize.show',[$prize])}}"> {{ $prize->title }}</a></td>
			<td>{{ date('Y-m-d h:i',$prize->signup_start) }}</td>
			<td>{{ date('Y-m-d h:i',$prize->signup_end) }}</td>
			<td>{{ $prize->signup_num }}</td>
			<td>@if($prize->is_prize==1)
					<a href="{{route('prize.show',[$prize])}}"> 查看中奖名单</a>
				@elseif(strtotime($prize->prize_date) <= time())
					<a href="{{ route('prize.openPrize',[$prize]) }}" class="btn btn-danger btn-sm">立即开奖</a>
				@else  {{ $prize->prize_date }}@endif</td>
			<td>@if($prize->is_prize==1)是 @else 否 @endif</td>
			<td>
				<a href="{{ route('prize.edit',[$prize]) }}" class="btn btn-success btn-sm">编辑</a>
				<a href="javascript:;" data-href="{{route('prize.destroy',[$prize])}}" class="del_btn btn btn-warning btn-sm">删除</a>
			</td>
		</tr>
	@endforeach
</table>
<!-- 分页 -->
{{ $prizes->appends(request()->except('page'))->links() }}
<!--加载删除的js-->
@include('common._del_btn_js')
@endsection