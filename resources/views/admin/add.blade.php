@extends('common.default')
@section('contents')
    <div class="col-md-6">
        <div class="modal-header">
            <h2 class="text-center">添加管理员</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.store') }}" method="post" enctype="multipart/form-data">
                <div class="form-group ">
                    <label>用户名：</label>
                    <input type="text" name="name" class="form-control " value="{{old('name')}}"/>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>
                <div class="form-group">
                    <label>密码：</label>
                    <input type="password" name="password" class="form-control"/>
                    <span class="text-danger">{{$errors->first('password')}}</span>
                </div>
                <div class="form-group">
                    <label>确认密码：</label>
                    <input type="password" name="password_confirmation" class="form-control"/>
                    <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                </div>
                <div class="form-group">
                    <label>邮箱：</label>
                    <input type="text" name="email" class="form-control" value="{{old('email')}}"/>
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
                <div class="form-group">
                    <input type="submit" value="立即添加" class="btn btn-success btn-lg btn-block"/>
                </div>
            </form>
        </div>
    </div>
@endsection