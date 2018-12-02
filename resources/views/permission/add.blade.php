@extends('common.default')
@section('contents')
<div class="col-md-10">
<div class="modal-header">
    <h2 class="text-center">添加权限</h2>
</div>
<div class="modal-body">
    <form action="{{ route('permission.store') }}" method="post">
        <div class="form-group ">
            <label>权限名称：</label>
            <input type="text" name="name" class="form-control " value="{{old('name')}}"/>
            <span class="text-danger">{{$errors->first('name')}}</span>
        </div>
        <div class="form-group ">
            <label>权限备注：</label>
            <input type="text" name="explain" class="form-control " value="{{old('name')}}"/>
        </div>
        <div class="form-group ">
            <label>权限分组：</label>
            <select name="pid" class="form-control">
                <option value="0">选择分组</option>
                @foreach($permissions as $permission)
                    <option value="{{$permission['id']}}" >
                        @if($permission['pid'] > 0)
                            ---
                        @endif
                        {{$permission['explain']}}
                    </option>
                @endforeach
            </select>
        </div>

        {{ csrf_field() }}
        <div class="form-group">
            <input type="submit" value="立即添加" class="btn btn-success btn-lg btn-block"/>
        </div>
    </form>
</div>
</div>
@endsection