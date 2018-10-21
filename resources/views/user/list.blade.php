@extends('common.default')
@section('contents')
<table class="table table-bordered ">
    <tr>
        <td>ID</td>
        <td>头像</td>
        <td>姓名</td>
        <td>邮箱</td>
        <td>手机</td>
        <td>操作</td>
    </tr>

    @foreach ($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>@if($user->img)<img src="{{\Illuminate\Support\Facades\Storage::url($user->img)}}" height="40"/>@endif</td>
        <td><a href="{{route('user.show',[$user])}}">{{ $user->name }}</a></td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->tel }}</td>
        <td><a href="{{ route('user.edit',[$user]) }}" class="btn btn-success btn-sm">编辑</a>
            <form method="post" action="{{route('user.destroy',[$user])}}" style="display: inline-block">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger btn-sm ">删除</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<!-- 分页 -->
{{ $users->links() }}

@endsection