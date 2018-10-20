
<!--登录-->

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="text-center" >用户登录</h2>

            </div>
            <div class="modal-body">
                <form action="{{ route('login.store') }}" method="post" >
                    <div class="form-group">
                        <label>用户名：</label>
                        <input type="text" name="name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>密码：</label>
                        <input type="password" name="password" class="form-control" />
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" > 记住我
                        </label>
                    </div>

                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="submit" value="提交" class="btn btn-success btn-block"/>
                    </div>


                </form>

            </div>

