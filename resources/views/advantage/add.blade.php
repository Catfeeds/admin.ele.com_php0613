@extends('common.default')
@section('contents')
    <div class="col-md-8 ">
        <div class="modal-header">
            <h2 class="text-center">新增服务优势</h2>
        </div>
        <div class="modal-body">
            <form action="{{route('advantage.store')}}" method="post" enctype="multipart/form-data">
                <div class="form-group form-group-lg">
                    <label>优势名：</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')}}"/>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>

                {{ csrf_field() }}
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg btn-block"> 提交</button>
                </div>
            </form>
        </div>
    </div>
@endsection