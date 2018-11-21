@extends('common.default')
@section('contents')
<div class="col-md-10">
<div class="modal-header">
    <h2 class="text-center">修改角色</h2>

</div>
<div class="modal-body">
    <form action="{{ route('role.update',[$role]) }}" method="post" enctype="multipart/form-data">
        <div class="form-group ">
            <label>角色名称：</label>
            <input type="text" name="name" class="form-control " value="{{$role->name}}"/>
            <span class="text-danger">{{$errors->first('name')}}</span>
        </div>
        <div class="form-group ">
            <label>权限选择：</label>
            <label><input type="checkbox" id="all" /> 全选/全不选</label>
            <div class="row">
            @foreach($permissions as $permission)
                @if($permission['pid']==0)
            </div><div class="row">
                <label class="col-sm-3 col-lg-2  text-primary">
                    <input type="checkbox" name="permission[]" value="{{$permission['id']}}"
                           @if($role->hasPermissionTo($permission['name'])) checked @endif />
                    {{$permission['explain']}}</label>
                @else
                <label class="col-sm-3 col-lg-2">
                    <input type="checkbox" name="permission[]" value="{{$permission['id']}}"
                           @if($role->hasPermissionTo($permission['name'])) checked @endif />
                    {{$permission['explain']}}</label>
                @endif
            @endforeach
            </div>
        </div>

        {{ csrf_field() }}
        {{method_field('PUT')}}
        <div class="form-group">
            <input type="submit" value="立即修改" class="btn btn-success btn-lg btn-block"/>
        </div>
    </form>
</div>
</div>
<script>
    //全选/全不选
    $('#all').on('click',function () {
        $(':checkbox').prop('checked',$(this).prop('checked'));
    });
</script>
@endsection