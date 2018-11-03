@extends('common.default')
@section('contents')
<div class="modal-header">
    <h2 class="text-center">添加会员</h2>
</div>
<div class="modal-body">
    <form action="{{ route('member.store') }}" method="post" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-sm-2 text-right">用户名：</label>
            <div class="col-sm-8"><input type="text" name="username" class="form-control " value="{{old('username')}}"/></div>
            <span class="text-danger">{{$errors->first('username')}}</span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">密码：</label>
            <div class="col-sm-8"><input type="password" name="password" class="form-control"/></div>
            <span class="text-danger">{{$errors->first('password')}}</span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">确认密码：</label>
            <div class="col-sm-8"><input type="password" name="password_confirmation" class="form-control"/></div>
            <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">邮箱：</label>
            <div class="col-sm-8"><input type="text" name="email" class="form-control" value="{{old('email')}}"/>
            </div>
            <span class="text-danger">{{$errors->first('email')}}</span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">电话：</label>
            <div class="col-sm-8"><input type="text" name="tel" class="form-control" value="{{old('tel')}}"/></div>
            <span class="text-danger">{{$errors->first('tel')}}</span>
        </div>

        <div class="clearfix form-group row">
            <label class="col-sm-2 text-right">头像：</label>
            <div class="col-sm-2"><img id="face" src="/images/a.png" alt="图片上传" width="80" style="cursor: pointer" onclick="test()"/></div>
            <div class="col-sm-8">
                <input type="file" name="img" id="file" onchange="preview(this)"/>
                <h6>图片格式:jpg、jpeg、png、gif，图片大小不能超过2M</h6>
                <h5 id="err" class="text-danger"></h5>
            </div>
        </div>

        {{ csrf_field() }}
        <div class="form-group row">
            <label class="col-sm-2 text-right"></label>
            <div class="col-sm-8"><input type="submit" value="提交" class="btn btn-success btn-block btn-lg"/></div>
        </div>
    </form>
</div>
@endsection
@include('common._img_js')