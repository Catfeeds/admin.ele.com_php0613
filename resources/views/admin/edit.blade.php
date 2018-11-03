@extends('common.default')
@section('contents')
    <div class="col-md-6">
        <div class="modal-header">
            <h2 class="text-center">修改店铺管理员</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.update',[$admin]) }}" method="post" enctype="multipart/form-data">
                <div class="form-group ">
                    <label>用户名：</label>
                    <input type="text" name="name"  class="form-control " value="{{$admin->name}}" disabled/>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>
                <div class="form-group">
                    <label>邮箱：</label>
                    <input type="text" name="email" class="form-control" value="{{$admin->email}}"/>
                    <span class="text-danger">{{$errors->first('email')}}</span>
                </div>
                <div class="form-group">
                    <label>验证码：</label>
                    <input id="captcha" class="form-control" name="captcha">
                    <span class="text-danger">{{$errors->first('captcha')}}</span>
                </div>

                <div class="form-group">
                    <label></label>
                    <img class="captcha" src="{{ captcha_src('flat') }}"
                         onclick="this.src='/captcha/flat?'+Math.random()"
                         title="点击图片重新获取验证码">
                </div>

                {{ csrf_field() }}
                {{method_field('PUT')}}
                <div class="form-group">
                    <input type="submit" value="提交修改" class="btn btn-success btn-lg btn-block"/>
                </div>
            </form>
        </div>
    </div>
@endsection