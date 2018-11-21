@extends('common.default')
@section('contents')
<div class="col-md-10">
<div class="modal-header">
    <h2 class="text-center">添加导航菜单</h2>
</div>
<div class="modal-body">
    <form action="{{ route('nav.store') }}" method="post">
        <div class="form-group ">
            <label>导航名称：</label>
            <input type="text" name="name" class="form-control" value="{{old('name')}}"/>
            <span class="text-danger">{{$errors->first('name')}}</span>
        </div>
        <div class="form-group ">
            <label>链接地址：</label>
            <input type="text" name="url" class="form-control" value="{{old('url')}}"/>
            <span class="text-danger">{{$errors->first('url')}}</span>
        </div>
        <div class="form-group ">
            <label>上级菜单：</label>
            <select name="pid" class="form-control">
                <option value="0">请选择上级菜单</option>
                @foreach($navs as $nav)
                    <option value="{{$nav->id}}" >
                        @if($nav->pid > 0)
                            --
                        @endif
                        {{$nav->name}}
                    </option>

                @endforeach
            </select>
        </div>
        <div class="form-group ">
            <label>权限路由：</label>
            <select name="permission" class="form-control">
                <option value="">选择权限</option>
                @foreach($permissions as $permission)
                    <option value="{{$permission->id}}">
                        {{$permission->name}}
                    </option>
                @endforeach
            </select>
            <span class="text-danger">{{$errors->first('permission')}}</span>
        </div>
        <div class="form-group ">
            <label>排序：</label>
            <input type="text" name="sort" class="form-control " value="{{old('sort')}}"/>
            <span class="text-danger">{{$errors->first('sort')}}</span>
        </div>


        {{ csrf_field() }}
        <div class="form-group">
            <input type="submit" value="立即添加" class="btn btn-success btn-lg btn-block"/>
        </div>
    </form>
</div>
</div>
@endsection