<?php
require_once '../../settings/config.php';
$pageTitle = "Failed Logins | $appName";
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
                    <div class="row" id="header">
                        <div class="col-sm-6">
                            <h3>Failed Logins</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Failed Logins</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <!-- Bookmark Start-->
                            <div class="bookmark">
                                <ul>
                                    <li>
                                        <button class="btn btn-success" id="delete-all-history"><i class="fa fa-trash"></i> Delete All History</button>
                                    </li>
                                </ul>
                            </div>
                            <!-- Bookmark Ends-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid list-products">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-border-vertical table-hover text-center" id="failed-logins-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Used Password</th>
                                            <th scope="col">Used PinCode</th>
                                            <th scope="col">Fail Reason</th>
                                            <th scope="col">Ip Address</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">User Agent</th>
                                            <th scope="col">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="current-user-ip-address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" readonly hidden disabled>
                    <!-- Individual column searching (text inputs) Ends-->
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
    </div>
</div>

<div class="modal fade" id="modal_delete_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title">Delete History</h5>
            </div>
            <div class="modal-body">
                <p id="title">Do you really want to delete this history ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirm-delete"><i class="fa fa-check"></i> Yes, Delete!</button>
                <button type="button" class="btn btn-secondary" id="cancel-delete" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../include/page-footer.php'; ?>
<script src="./js/init.js" type="module"></script>
</body>
</html>