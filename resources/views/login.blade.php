<style>
	body {
		background: url("{{'/images/timg'.mt_rand(1,5).'.jpg'}}") no-repeat top center;
		background-size: auto 1000px;
	}

	.row {
		padding: 10px;
	}

	.col-sm-4 {
		background: #fff;
		margin: 15% auto 0 auto;
	}
</style>
@extends('common.default')
@section('contents')
	<div class="row">
		<div class="col-sm-8">
		</div>
		<div class="col-sm-4 pane-body">
			@guest
				@include('common._login')
			@endguest
			@auth
				@include('common._login')
			@endauth
		</div>
	</div>


@endsection