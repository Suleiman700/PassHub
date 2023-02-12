<?php
require_once '../../settings/config.php';
$pageTitle = "Passwords | $appName";
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
                            <h3>Passwords List</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Passwords List</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <!-- Bookmark Start-->
                            <div class="bookmark pull-right">
                                <ul>
                                    <li>
                                        <a class="btn btn-success text-white" href="../passwords-add/index.php"><i class="fa fa-plus"></i> New Password</a>
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
                            <div class="card-header pb-0">
                                <h5>Search Passwords</h5>
                                <span>Use filters below to search passwords</span>
                            </div>
                            <div class="card-body">
                                <div id="search-form">
                                    <div class="row g-3">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="filter-username">Username</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-link"></i></span>
                                                <input type="text" class="form-control" id="filter-username">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="filter-category">Category</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                                <select class="form-select" id="filter-category"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="filter-website">Website</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-link"></i></span>
                                                <input type="text" class="form-control" id="filter-website">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="filter-description">Description</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-font"></i></span>
                                                <input type="text" class="form-control" id="filter-description">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="filter-note">Note</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-sticky-note"></i></span>
                                                <input type="text" class="form-control" id="filter-note">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" id="button-search-filters">Search</button>
                                    <button class="btn btn-secondary" id="button-clear-filters">Clear Filters</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Individual column searching (text inputs) Ends-->
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-border-vertical table-hover text-center" id="passwords-table" style="white-space: nowrap;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Password</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Website</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Individual column searching (text inputs) Ends-->
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
<?php require_once '../../include/page-footer.php'; ?>
<script src="../../assets/js/notify/bootstrap-notify.min.js"></script>
<script src="../../assets/js/notify/notify-script.js"></script>
<script src="../../assets/js/tooltip-init.js"></script>
<script src="./js/init.js" type="module"></script>
</body>
</html>