<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">myblog</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="#">分类管理<span class="sr-only">(current)</span></a></li>
                <li><a href="/admin">用户管理</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">文章管理 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/article">文章列表</a></li>
                        <li><a href="/article/create">新增文章</a></li>
                    </ul>
                </li>

            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                @guest
                <li><a href="#" data-toggle="modal" data-target="#login">登陆</a></li>
                <li><a href="{{route('user.create')}}" >注册</a></li>
                @endguest
                @auth
                <li class="dropdown">
                    <a href="{{route('user.index')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{auth()->user()->name}}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('user.index',[auth()->user()])}}">用户中心</a></li>
                        <li><a href="#">修改密码</a></li>
                        <li><a href="{{route('logout')}}">退出登陆</a></li>
                    </ul>
                </li>
               @endauth
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">管理员<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('admin.login')}}">管理员登录</a></li>
                        <li><a href="{{route('admin.index')}}">管理员列表</a></li>
                        <li><a href="{{route('user.list')}}">会员列表</a></li>
                        <li><a href="{{route('admin.create')}}">新增管理员</a></li>
                        <li><a href="{{route('admin.logout')}}">退出登陆</a></li>
                    </ul>
                </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
@include('common._modal_login')