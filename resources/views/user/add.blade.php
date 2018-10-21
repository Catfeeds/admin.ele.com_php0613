@extends('common.default')
@section('contents')
    <div class="col-md-8">
        <div class="modal-header">
            <h2 class="text-center">添加商户</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                <div class="form-group form-group-lg form-inline ">
                    <label class="col-sm-3 text-right">用户名：</label>
                    <input type="text" name="name" class="form-control " value="{{old('name')}}"/>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>
                <div class="form-group form-group-lg form-inline">
                    <label class="col-sm-3 text-right">密码：</label>
                    <input type="password" name="password" class="form-control"/>
                    <span class="text-danger">{{$errors->first('password')}}</span>
                </div>
                <div class="form-group form-group-lg form-inline">
                    <label class="col-sm-3 text-right">确认密码：</label>
                    <input type="password" name="password_confirmation" class="form-control"/>
                    <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                </div>
                <div class="form-group form-group-lg form-inline">
                    <label class="col-sm-3 text-right">邮箱：</label>
                    <input type="text" name="email" class="form-control" value="{{old('email')}}"/>
                    <span class="text-danger">{{$errors->first('email')}}</span>
                </div>
                <div class="form-group form-group-lg form-inline">
                    <label class="col-sm-3 text-right">电话：</label>
                    <input type="text" name="tel" class="form-control" value="{{old('tel')}}"/>
                    <span class="text-danger">{{$errors->first('tel')}}</span>
                </div>

                <div class="form-group form-group-lg form-inline" id="aa" onclick="test()">
                    <label class="col-sm-3 text-right">上传头像：</label>
                    <img id="face" src="/images/a.png " alt="图片上传" height="40" class="form-inline" style="cursor: pointer"/>
                    <input type="file" name="img" id="file" onchange="preview(this)" style="display: inline-block"/>

                </div>

                <div class="form-group form-inline form-group-lg">

                    <label class="col-sm-3 text-right">验证码：</label>
                    <input id="captcha" class="form-control" name="captcha">

                    <span class="text-danger">{{$errors->first('captcha')}}</span>
                </div>

                <div class="form-group form-inline form-group-lg">
                    <label class="col-sm-3 text-right"></label>
                    <img class="captcha" src="{{ captcha_src('cccap') }}"
                         onclick="this.src='/captcha/flat?'+Math.random()"
                         title="点击图片重新获取验证码">
                </div>

                {{ csrf_field() }}
                <div class="form-group form-inline">
                    <label class="col-sm-3"></label>
                    <input type="submit" value="提交注册" class="btn btn-success btn-lg"/>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    function test(){
        var $file = document.getElementById('file');
        $file.click();
    }
    function preview(obj) {
        //获取input上传的图片数据
        var file = obj.files[0];
        //得到bolb对象路径,可当成普通的文件路径一样使用,复制给src;
        url = window.URL.createObjectURL(file);
        //预览
        var face = document.getElementById('face');
        face.src = url;
    }
</script>