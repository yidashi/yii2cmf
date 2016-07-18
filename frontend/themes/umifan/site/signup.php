<div class="container user-module">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 ">
            <div class="panel panel-default panel-page">
                <div class="panel-heading">
                    <h2 class="panel-title">注册</h2>
                </div>
                <div class="panel-body">
                    <form id="registration-form" action="/index.php?r=user%2Fregistration%2Fregister" method="post">
                        <input type="hidden" name="_csrf" value="MEJHb1dzNnhmBnQqBENOAkFvFhoSQWBKYhckOyRLXkxJcQ0qBEt3Kw==">
                        <div class="form-group mb40 field-register-form-email required">
                            <label class="control-label" for="register-form-email">邮箱</label>
                            <input type="text" id="register-form-email" class="form-control" name="register-form[email]">

                            <div class="help-block"></div>
                        </div>
                        <div class="form-group mb40 field-register-form-username required">
                            <label class="control-label" for="register-form-username">用户名</label>
                            <input type="text" id="register-form-username" class="form-control" name="register-form[username]">

                            <div class="help-block"></div>
                        </div>
                        <div class="form-group mb40 field-register-form-password required">
                            <label class="control-label" for="register-form-password">密码</label>
                            <input type="password" id="register-form-password" class="form-control" name="register-form[password]">

                            <div class="help-block"></div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block mb40">注册</button>
                    </form>
                    <p class="text-center">
                        <a href="/index.php?r=user%2Fsecurity%2Flogin">已有账户? 现在登录!</a>        </p>
                </div>
            </div>

        </div>
    </div>
</div>