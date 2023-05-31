<?php
$user = new User();
if($user->isLoggedIn()){
    Redirect::to(home);
}
?>
<div class="row mt-5">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="login-form">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Enter Admin Credentials</h4>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="username-field mb-2">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" maxlength="20" class="form-control" id="username" name="username" value="<?= Input::get('username')?>">
                            <small class="text-danger" id="username-error"></small>
                        </div>
                        <div class="username-field mb-4">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" maxlength="20" class="form-control" id="password" name="password">
                            <small class="text-danger" id="password-error"></small>
                        </div>
                        <div class="links">
                            <a href="#" class="float-right">Forgot password?</a>
                        </div>
                        <div class="remember">
                            <label for="remember"><input type="checkbox" class="" name="remember"> Remember me!</label>
                        </div>
                        <input type="hidden" value="<?= Token::generate(); ?>" name="token">
                        <input type="submit" class="btn btn-cyan justify-content-center align-items-center" name="login" value="login">
                        <div class="links mt-3">
                            Not having an account yet? <a href="<?= URL.register ?>">sign up here!</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>

