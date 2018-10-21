@extends('common.default')
@section('contents')
    <div class="col-md-8 ">
        <div class="modal-header">
            <h2 class="text-center">新增分类</h2>
        </div>
        <div class="modal-body">
            <form action="{{route('shopCategory.store')}}" method="post" enctype="multipart/form-data">
                <div class="form-group form-group-lg">
                    <label>分 类 名：</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')}}"/>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>
                <div class="form-group form-group-lg">
                    <label> 分类状态：</label>
                    <label><input type="radio" name="status" value="1" checked/> 显示 </label>
                    <label><input type="radio" name="status" value="0"/> 隐藏 </label>
</div>
                <div class="clearfix form-group" >
                    <div class="pull-left" style="padding-right: 15px">
                        <label>分类图片：</label>
                        <img id="face" src="/images/a.png" alt="图片上传" width="100" style="cursor: pointer" onclick="test()"/>
                    </div>
                    <div class="pull-left">
                        <input type="file" name="img" id="file" onchange="preview(this)" />
                        <h6>图片格式:jpg、jpeg、png、gif，图片大小不能超过2M</h6>
                    <h5 id="err" class="text-danger"></h5>
                    </div>
                </div>

                {{ csrf_field() }}
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg btn-block"> 提交分类</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@include('common._img_js')