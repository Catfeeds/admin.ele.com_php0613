@extends('common.default')
@section('contents')
    <div class="col-md-6">
        <div class="modal-header">
            <h2 class="text-center">修改<span class="text-success">{{$admin->name}}</span> 密码</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.update',[$admin]) }}" method="post" enctype="multipart/form-data">
                <div class="form-group ">
                    <label>旧密码：</label>
                    <input type="password" name="oldpassword"  class="form-control" />
                    <span class="text-danger">{{$errors->first('oldpassword')}}</span>
                </div>
                <div class="form-group">
                    <label>新密码：</label>
                    <input type="password" name="password" class="form-control" />
                    <span class="text-danger">{{$errors->first('password')}}</span>
                </div>
                <div class="form-group">
                    <label>确认密码：</label>
                    <input type="password" class="form-control" name="password_confirmation">
                    <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                </div>
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="submit" value="提交" class="btn btn-success btn-lg btn-block"/>
                </div>
            </form>
        </div>
    </div>
@endsection