@extends('common.default')
@section('contents')
<div class="modal-header">
    <h2 class="text-center">修改会员</h2>
</div>
<div class="modal-body">
    <form action="{{ route('member.update',[$member]) }}" method="post" enctype="multipart/form-data">
        <div class="form-group row ">
            <label class="col-sm-2 text-right">用户名：</label>
            <div class="col-sm-8"><input type="text" name="username" class="form-control " value="{{$member->username}}"/></div>
            <span class="text-danger">{{$errors->first('username')}}</span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">邮箱：</label>
            <div class="col-sm-8"><input type="text" name="email" class="form-control" value="{{$member->email}}"/></div>
            <span class="text-danger">{{$errors->first('email')}}</span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">电话：</label>
            <div class="col-sm-8"><input type="text" name="tel" class="form-control" value="{{$member->tel}}"/></div>

        </div>
        <div class="clearfix form-group row">
            <label class="col-sm-2 text-right">头像：</label>
            <div class="col-sm-2"><img id="face" src=" @if($member->img){{$member->img}}@else/images/a.png @endif " alt="图片上传" width="80" style="cursor: pointer" onclick="test()"/></div>
            <div class="col-sm-8">
                <input type="file" name="img" id="file" onchange="preview(this)"/>
                <h6>图片格式:jpg、jpeg、png、gif，图片大小不能超过2M</h6>
                <h5 id="err" class="text-danger"></h5>
            </div>
        </div>

        {{ csrf_field() }}
        {{method_field('PUT')}}
        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-8"><input type="submit" value="提交修改" class="btn btn-success btn-lg btn-block"/></div>
        </div>
    </form>
</div>
@endsection
@include('common._img_js')