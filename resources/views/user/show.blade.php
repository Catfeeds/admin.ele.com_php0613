@extends('common.default')
@section('contents')
    <div class="row">
        <div class="col-md-3"><img id="face" src="@if($user->img){{ \Illuminate\Support\Facades\Storage::url($user->img) }}@else /images/a.png @endif" alt="图片上传" width="90%"  /></div>
        <div class="col-md-9">
            <h1>{{$user->name}}</h1>
            <p>{{$user->email}}</p>
            <p>{{$user->tel}}</p>
        </div>
    </div>
@endsection
