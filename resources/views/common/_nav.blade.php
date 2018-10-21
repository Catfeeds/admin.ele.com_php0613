<nav class="navbar navbar-inverse navbar-static-top" style="border-radius:0;">
    <div class="container">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">ele购物网</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="#">首页<span class="sr-only">(current)</span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">分类管理 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/shopCategory">分类列表</a></li>
                        <li><a href="/shopCategory/create ">新增分类</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">商家店铺管理<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/shop">店铺列表</a></li>
                        <li><a href="/shop/create">新增店铺</a></li>
                        <li><a href="/advantage">店铺优势</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">商家账号管理<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/user">账号列表</a></li>
                        <li><a href="/user/create">新增账号</a></li>
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


            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
    </div>
</nav>
@include('common._modal_login')