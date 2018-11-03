@extends('common.default')
@section('contents')
<div class="modal-header">
    <h2 class="text-center">修改店铺管理员</h2>
</div>
<div class="modal-body">
    <form action="{{ route('user.update',[$user]) }}" method="post" enctype="multipart/form-data">
        <div class="form-group row ">
            <label class="col-sm-2 text-right">用户名：</label>
            <div class="col-sm-8"><input type="text" name="name" class="form-control " value="{{$user->name}}"/></div>
            <span class="text-danger">{{$errors->first('name')}}</span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">邮箱：</label>
            <div class="col-sm-8"><input type="text" name="email" class="form-control" value="{{$user->email}}"/></div>
            <span class="text-danger">{{$errors->first('email')}}</span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">电话：</label>
            <div class="col-sm-8"><input type="text" name="tel" class="form-control" value="{{$user->tel}}"/></div>

        </div>

        <div class="clearfix form-group row">
            <label class="col-sm-2 text-right">头像：</label>
            <div class="col-sm-2"><img id="face" src=" @if($user->img){{$user->img}}@else/images/a.png @endif " alt="图片上传" width="80" style="cursor: pointer" onclick="test()"/></div>
            <div class="col-sm-8">
                <input type="file" name="img" id="file" onchange="preview(this)"/>
                <h6>图片格式:jpg、jpeg、png、gif，图片大小不能超过2M</h6>
                <h5 id="err" class="text-danger"></h5>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 text-right">状态：</label>
            <div class="col-sm-8"><label class="col-sm-2"><input type="radio" name="status" value="1" checked/>启用</label>
                <label class="col-sm-2"><input type="radio" name="status" value="0"/>禁用</label></div>
        </div>
        <div class="form-group row ">
            <label class="col-sm-2 text-right">所属店铺：</label>
            <div class="col-sm-8"> <select name="shop_id" class="form-control">
                @if(isset($shop))
                    <option value="{{$shop->id}}">{{$shop->shop_name}}</option>
                @else
                    <option value="0">请选择</option>
                    @foreach($shops as $a)
                        <option value="{{$a->id}}"
                        @if($user->shop_id==$a->id) selected @endif>{{$a->shop_name}}</option>
                    @endforeach
                @endif
                </select></div>
            <span class="text-danger"></span>
        </div>

        <div class="form-group row">

            <label class="col-sm-2 text-right">验证码：</label>
            <div class="col-sm-8"><input id="captcha" class="form-control" name="captcha"></div>

            <span class="text-danger">{{$errors->first('captcha')}}</span>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 text-right"></label>
            <div class="col-sm-8"><img class="captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码"></div>
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