@extends('common.default')
@section('contents')

<div class="modal-header">
    <h2 class="text-center">添加试用产品</h2>
</div>
<div class="modal-body">
    <form action="{{ route('prize.store') }}" method="post" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-sm-2 text-right">试用标题：</label>
            <div class="col-sm-8"><input type="text" name="title" class="form-control" value="{{old('title')}}"/></div>
            <span class="text-danger">{{$errors->first('title')}}</span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">提供数量：</label>
            <div class="col-sm-8 form-inline">
                <div class="input-group">
                    <input type="number" name="amount" class="form-control" value="{{old('amount')}}" aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2">份</span>
                </div>
            </div>
            <span class="text-danger">{{$errors->first('amount')}}</span>
        </div>
        <div class="clearfix form-group row">
            <label class="col-sm-2 text-right">试用主图：</label>
            <div class="col-sm-2 col-md-1"><img id="face" src="/images/a.png" alt="图片上传" width="80" style="cursor: pointer" onclick="test()"/></div>
            <div class="col-sm-6">
                <input type="file" name="img" id="file" onchange="preview(this)"/>
                <h6>图片格式:jpg、jpeg、png、gif，图片大小不能超过2M</h6>
                <h5 id="err" class="text-danger"></h5>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">试用详情：</label>
            <div class="col-sm-8">
                @include('vendor.ueditor.assets')
                <!-- 实例化编辑器 -->
                <script type="text/javascript">
                    var ue = UE.getEditor('container');
                    ue.ready(function () {
                        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                    });
                </script>
                <!-- 编辑器容器 -->
                <script id="container" name="content" type="text/plain" >{!! old('content')!!}

                </script>
                <script>$('#container').height(400);</script>
            </div>
            <span class="text-danger">{{$errors->first('content')}}</span>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 text-right">申请时间：</label>
            <div class="col-sm-8 form-inline">
                <input type="datetime-local" name="signup_start" class="form-control" value="{{old('signup_start')}}"/> -
                <input type="datetime-local" name="signup_end" class="form-control" value="{{old('signup_end')}}"/>
                <span class="text-danger">{{$errors->first('signup_end')}}</span>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 text-right">开奖日期：：</label>
            <div class="col-sm-8 form-inline">
                <input type="date" name="prize_date" class="form-control"  value="{{old('signup_num')}}" >
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 text-right">申请人数限制：</label>
            <div class="col-sm-8 form-inline">
                <div class="input-group">
                    <input type="number" name="signup_num" class="form-control"  value="{{old('signup_num')}}" aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2">人</span>
                </div>
            </div>
        </div>




        {{ csrf_field() }}
        <div class="form-group row">
            <label class="col-sm-2 text-right"></label>
            <div class="col-sm-8"><input type="submit" value="立即提交" class="btn btn-success btn-block btn-lg"/></div>
        </div>
    </form>
</div>

@endsection
@include('common._img_js')