<?php
require_once '../../settings/config.php';
require_once '../../classes/authentication/Session.php';
require_once '../../classes/users/UsersSettings.php';
$pageTitle = "Security Settings | $appName";

$Session = new Session();
$UsersSettings = new UsersSettings();

// get user id from session
$session_userId = $Session->getSessionUserId();

// get user settings
$data = $UsersSettings->get_user_settings($session_userId);
$userSettings = $data['data'];
?>

<!DOCTYPE html>
<html lang="en">

<?php
require_once '../../include/page-head.php';
?>

<body id="body">
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader">
        <div class="loader-p"></div>
    </div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start       -->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <?php require_once '../../include/components/header.php'; ?>
    <!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        <?php require_once '../../include/components/sidebar.php'; ?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3>Security Settings</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Security Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="edit-profile">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h4 class="card-title mb-0">Edit Your Security Settings</h4>
                                    <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="staticEmail" class="col-form-label">Enable two-factor authentication</label><br>
                                            <small>Enable two-factor authentication when logging into your account.</small>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-solid-primary">
                                                <input type="checkbox" id="checkbox-enable-2fa" <?php echo ($userSettings['enable_2fa'])?'checked':''; ?>>
                                                <label for="checkbox-enable-2fa">Enabled</label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="staticEmail" class="col-form-label">Enable login alerts</label><br>
                                            <small>Receive an email alert when logging into your account.</small>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-solid-primary">
                                                <input type="checkbox" id="checkbox-enable-login-alerts" <?php echo ($userSettings['enable_login_alerts'])?'checked':''; ?>>
                                                <label for="checkbox-enable-login-alerts">Enabled</label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="staticEmail" class="col-form-label">Enable password change alert</label><br>
                                            <small>Receive an email alert when changing your account's password.</small>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-solid-primary">
                                                <input type="checkbox" id="checkbox-enable-password-change-alerts" <?php echo ($userSettings['enable_password_change_alert'])?'checked':''; ?>>
                                                <label for="checkbox-enable-password-change-alerts">Enabled</label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="staticEmail" class="col-form-label">Enable Pin Code change alert</label><br>
                                            <small>Receive an email alert when changing your account's Pin Code.</small>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-solid-primary">
                                                <input type="checkbox" id="checkbox-enable-pin-code-change-alerts" <?php echo ($userSettings['enabled_pin_code_change_alert'])?'checked':''; ?>>
                                                <label for="checkbox-enable-pin-code-change-alerts">Enabled</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" id="save"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 footer-copyright">
                        <p class="mb-0">Copyright 2021-22 © viho All rights reserved.</p>
                    </div>
                    <div class="col-md-6">
                        <p class="pull-right mb-0">Hand crafted & made with <i class="fa fa-heart font-secondary"></i></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<?php require_once '../../include/page-footer.php'; ?>
<script src="./js/init.js" type="module"></script>
</body>
</html>
