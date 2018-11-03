@extends('common.default')
@section('contents')
<div class="col-md-10">
<div class="modal-header">
    <h2 class="text-center">添加活动</h2>
</div>
<div class="modal-body">
    <form action="{{ route('activity.store') }}" method="post" enctype="multipart/form-data">
        <div class="form-group ">
            <label>活动名称：</label>
            <input type="text" name="title" class="form-control " value="{{old('title')}}"/>
            <span class="text-danger">{{$errors->first('title')}}</span>
        </div>
        <div class="form-group">
            <label>活动内容：</label>
        @include('vendor.ueditor.assets')
        <!-- 实例化编辑器 -->
            <script type="text/javascript">
                var ue = UE.getEditor('container');
                ue.ready(function () {
                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                });
            </script>

            <!-- 编辑器容器 -->
            <script id="container" name="content" type="text/plain">{!! old('content')!!}

            </script>
            <span class="text-danger">{{$errors->first('content')}}</span>
        </div>
        <div class="form-group form-inline">
            <label>活动时间：</label>
            <input type="date" name="start_time" class="form-control"/> -
            <input type="date" name="end_time" class="form-control"/>
            <span class="text-danger">{{$errors->first('start_time')}}</span>
        </div>

        {{ csrf_field() }}
        <div class="form-group">
            <input type="submit" value="立即添加" class="btn btn-success btn-lg btn-block"/>
        </div>
    </form>
</div>
</div>
@endsection