@extends('common.default')
@section('contents')
<div class="col-md-10">
<div class="modal-header">
    <h2 class="text-center">修改权限</h2>

</div>
<div class="modal-body">
    <form action="{{ route('permission.update',[$permission]) }}" method="post" >
        <div class="form-group ">
            <label>权限名称：</label>
            <input type="text" name="name" class="form-control " value="{{$permission->name}}"/>
            <span class="text-danger">{{$errors->first('name')}}</span>
        </div>
        <div class="form-group ">
            <label>权限备注：</label>
            <input type="text" name="explain" class="form-control " value="{{$permission->explain}}"/>
        </div>
        <div class="form-group ">
            <label>权限分组：</label>
            <select name="pid" class="form-control">
                <option value="0">选择分组</option>
                @foreach($datas as $dat)
                    <option value="{{$dat['id']}}" >
                        @if($dat['pid'] > 0)
                            ---
                        @endif
                        {{$dat['explain']}}
                    </option>
                @endforeach
            </select>
        </div>


        {{ csrf_field() }}
        {{method_field('PUT')}}
        <div class="form-group">
            <input type="submit" value="立即修改" class="btn btn-success btn-lg btn-block"/>
        </div>
    </form>
</div>
</div>
@endsection