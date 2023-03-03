<?php
require_once '../../settings/config.php';
require_once '../../classes/authentication/Session.php';
$pageTitle = "Register | $appName";

// redirect logged-in users to dashboard
$Session = new Session();
if ($Session->isLogged()) {
    header('Location: ../dashboard/index.php');
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
                    <div class="theme-form login-form" id="register-form">
                        <div class="text-center">
                            <h4>Register</h4>
                            <h6>You are one step from creating your account!</h6>
                        </div>
                        <div class="alert alert-danger" role="alert" id="alert" style="display: none;"></div>
                        <div class="form-group">
                            <label>Full Name</label>
                            <div class="input-group"><span class="input-group-text">
                                <i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="fullname" required="" placeholder="John Doe">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <div class="input-group"><span class="input-group-text">
                                <i class="fa fa-at"></i></span>
                                <input type="email" class="form-control" id="email" required="" placeholder="Test@gmail.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group"><span class="input-group-text">
                                <i class="fa fa-key"></i></span>
                                <input type="password"class="form-control" id="password" required="" placeholder="*********">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>PIN Code</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-map-pin"></i></span>
                                <input type="text" class="form-control" id="pin-code" required="" placeholder="1234">
                                <span class="input-group-text fa fa-info" data-bs-toggle="tooltip" data-bs-placement="top" title="PIN Code adds another security layer to your account"></span>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <button type="button" class="btn btn-primary btn-block" id="register">Register</button>
                        </div>
                        <div class="login-social-title">
                            <h5>-</h5>
                        </div>
                        <p>Already have account?<a class="ms-2" href="../login/index.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
require_once '../../include/page-footer.php';
?>
<script src="../../assets/js/tooltip.js"></script>
<script src="./js/init.js" type="module"></script>
</body>
</html>