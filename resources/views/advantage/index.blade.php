@extends('common.default')
@section('contents')
    <div class="clearfix">
        <h4 class="pull-left">店铺优势列表 </h4>
        <a href="{{route('advantage.create')}}" class="btn btn-success pull-right">添加优势</a>
    </div>
    <table class="table table-hover table-bordered text-center" >
        <thead>
        <tr class="active">
            <th class="text-center">ID</th>
            <th class="text-center">优势名</th>
            <th class="text-center">值</th>
            <th class="text-center">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($advantages as $advantage)
            <tr>
                <td>{{$advantage->id}}</td>
                <td>{{$advantage->name}}</td>
                <td>{{$advantage->value}}</td>
                <td>
                    <a href="{{ route('advantage.edit',[$advantage]) }}" class="btn btn-success btn-sm">修改</a>
                    <a href="{{ route('advantage.destroy',[$advantage]) }}" class="btn btn-warning btn-sm">删除</a>


                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="clearfix">
        <div class="pull-left">{{ $advantages->links() }} </div>
        <a href="{{route('advantage.recycle')}}" class="btn btn-default pull-right">回收站</a>
    </div>



@endsection