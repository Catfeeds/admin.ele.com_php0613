@extends('common.default')
@section('contents')
    <div class="col-md-8">
        <div class="modal-header">
            <h2 class="text-center">修改个人资料</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('user.update',[$user]) }}" method="post" enctype="multipart/form-data">
                <div class="form-group form-group-lg form-inline ">
                    <label class="col-sm-3 text-right">用户名：</label>
                    <input type="text" name="name" class="form-control " value="{{$user->name}}"/>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>
                <div class="form-group form-group-lg form-inline">
                    <label class="col-sm-3 text-right">邮箱：</label>
                    <input type="text" name="email" class="form-control" value="{{$user->email}}"/>
                    <span class="text-danger">{{$errors->first('email')}}</span>
                </div>
                <div class="form-group form-group-lg form-inline">
                    <label class="col-sm-3 text-right">电话：</label>
                    <input type="text" name="tel" disabled="disabled" class="form-control" value="{{$user->tel}}"/>
                    <span class="text-danger">{{$errors->first('tel')}}</span>
                </div>

                <div class="form-group form-group-lg form-inline" id="aa" onclick="test()">
                    <label class="col-sm-3 text-right">上传头像：</label>
                    <img id="face" src="@if($user->img){{ \Illuminate\Support\Facades\Storage::url($user->img) }}@else /images/a.png @endif" alt="图片上传" height="40" class="form-inline" style="cursor: pointer"/>
                    <input type="file" name="img" id="file" onchange="preview(this)" style="display: inline-block"/>

                </div>


                {{ csrf_field() }}
                {{method_field('PUT')}}
                <div class="form-group form-inline">
                    <label class="col-sm-3"></label>
                    <input type="submit" value="提交修改" class="btn btn-success btn-lg"/>
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