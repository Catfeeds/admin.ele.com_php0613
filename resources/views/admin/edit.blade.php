@extends('common.default')
@section('contents')
    <div class="col-md-6">
        <div class="modal-header">
            <h2 class="text-center">修改后台管理员</h2>
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
                    <label>选择角色：</label>
                    @foreach($roles as $role)
                        <label style="margin-right: 20px"><input type="checkbox" @if(!auth()->user()->can('admin.index'))disabled="disabled" @endif name="role[]" @if($admin->hasRole($role))checked @endif value="{{$role->id}}"/>{{$role->name}}</label>
                    @endforeach
                    <span class="text-danger">{{$errors->first('role')}}</span>
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