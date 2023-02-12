<?php
require_once '../../settings/config.php';
require_once '../../classes/passwords/Passwords.php';
require_once '../../classes/authentication/Session.php';
$pageTitle = "Edit Password | $appName";

// check url parameter
$canEdit = false;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $Session = new Session();
    $Passwords = new Passwords();

    $session_userId = $Session->getSessionUserId();

    // get category data by id
    $passwordData = $Passwords->get_password_info($_GET['id'], $session_userId);

    // check if category is found
    if ($passwordData['dataFound']) {
        // check if category belongs to user
        if ($passwordData['data']['user_id'] == $session_userId) {
            $canEdit = true;
        }
    }
}
if (!$canEdit) {
    header('Location: ../passwords-list/index.php');
    exit;
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
                            <h3>Edit Password</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="../passwords-list/index.php">Passwords List</a></li>
                                <li class="breadcrumb-item active">Edit Password</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <div class="bookmark pull-right">
                                <a class="btn btn-success" href="../passwords-list/index.php"><i class="fa fa-list"></i> Passwords List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid list-products">
                <div class="row">
                    <div class="col-sm-12" id="form">
                        <div class="card">
                            <div class="card-body">
                                <div class="theme-form">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="password-username">Category <code class="text-danger">*</code></label>
                                        <div class="col-sm-9">
                                            <select class="form-select" id="password-category"></select>
                                            <input class="form-select" id="password-selected-category-id" value="<?php echo $passwordData['data']['category_id']; ?>" readonly disabled hidden></input>
                                        </div>
                                        <small class="text-muted">Categories organizes your passwords.</small>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="password-username">Username <code class="text-danger">*</code></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="password-username" value="<?php echo $passwordData['data']['username']; ?>" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="password-password">Password <code class="text-danger">*</code></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="password-password" value="<?php echo $passwordData['data']['password']; ?>" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="password-website">Website</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="password-website" value="<?php echo $passwordData['data']['website']; ?>" placeholder="e.g: www.website.com">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="password-description">Description</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="password-description" value="<?php echo $passwordData['data']['description']; ?>" placeholder="A short description about this password">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label" for="password-note">Note</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="password-note" rows="10" placeholder="A detailed note about this password" style="min-width: 100%"><?php echo str_replace('\n',"&#13;&#10;", $passwordData['data']['note']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" id="submit"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-secondary" id="cancel"><i class="fa fa-times"></i> Cancel</button>
                                <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i> Delete</button>
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
                        <p class="pull-right mb-0">Hand crafted & made with <i class="fa fa-heart font-secondary"></i>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_password_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title">Delete Password</h5>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete this password ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirm-delete">Yes, Delete!</button>
                <button type="button" class="btn btn-secondary" id="cancel-delete" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../include/page-footer.php'; ?>
<script src="./js/init.js" type="module"></script>
</body>
</html>