@extends('common.default')
@section('contents')
	<div class="col-md-8 ">
		<div class="modal-header">
			<h2 class="text-center">修改店铺优势</h2>
		</div>
		<div class="modal-body">
			<form action="{{route('advantage.update',[$advantage])}}" method="post" enctype="multipart/form-data">
				<div class="form-group form-group-lg">
					<label>优势名：</label>
					<input type="text" name="name" class="form-control" value="{{ $advantage->name }}"/>
					<span class="text-danger">{{$errors->first('name')}}</span>
				</div>


				{{ csrf_field() }}
				{{method_field('PUT')}}
				<div class="text-center">
					<button type="submit" class="btn btn-success btn-lg btn-block"> 提交</button>
				</div>
			</form>
		</div>
	</div>
@endsection