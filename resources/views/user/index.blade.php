@extends('common.default')
@section('contents')
	@include('common._errors')
	<h1>
		@auth{{$user->name}}@endauth欢迎回来
	</h1>

	@endsection