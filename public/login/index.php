<?php
require_once '../../settings/config.php';
require_once '../../classes/authentication/Session.php';
$pageTitle = "Login | $appName";

// redirect logged-in users to dashboard
$Session = new Session();
if ($Session->isLogged()) {
    header('Location: ../dashboard/index.php');
    exit;
}
else {
    $Session->destory_logged_session();
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
require_once '../../include/page-head.php';
?>

<body>
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader">
        <div class="loader-p"></div>
    </div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<section>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="login-card">
                    <div class="theme-form login-form" id="login-form">
                        <div class="text-center">
                            <h4>Login</h4>
                            <h6>Welcome back! Log in to your account.</h6>
                        </div>
                        <div class="alert alert-danger" role="alert" id="alert" style="display: none;"></div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <div class="input-group"><span class="input-group-text">
                                <i class="icon-email"></i></span>
                                <input type="email" class="form-control" id="email" required="" placeholder="Test@gmail.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group"><span class="input-group-text">
                                <i class="icon-lock"></i></span>
                                <input type="password"class="form-control" id="password" required="" placeholder="*********">
                                <div class="show-hide">
                                    <span class="show"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>PIN Code</label>
                            <div class="input-group"><span class="input-group-text">
                                <i class="icon-key"></i></span>
                                <input type="text" class="form-control" id="pin-code" required="" placeholder="*********">
                                <div class="show-hide">
                                    <span class="show"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input id="checkbox1" type="checkbox">
                                <label for="checkbox1">Remember password</label>
                            </div><a class="link" href="forget-password.html">Forgot password?</a>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-block" id="login">Sign in</button>
                        </div>
                        <div class="login-social-title">
                            <h5>-</h5>
                        </div>
<!--                        <div class="login-social-title">-->
<!--                            <h5>Sign in with</h5>-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <ul class="login-social">-->
<!--                                <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="linkedin"></i></a></li>-->
<!--                                <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="twitter"></i></a></li>-->
<!--                                <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="facebook"></i></a></li>-->
<!--                                <li><a href="https://www.instagram.com/login" target="_blank"><i data-feather="instagram">                  </i></a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
                        <p>Don't have account?<a class="ms-2" href="../register/index.php">Create Account</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
require_once '../../include/page-footer.php';
?>
<script src="./js/init.js" type="module"></script>
</body>
</html>