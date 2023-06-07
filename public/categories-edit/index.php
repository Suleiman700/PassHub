<?php
require_once '../../settings/config.php';
require_once '../../classes/categories/Categories.php';
require_once '../../classes/authentication/Session.php';
$pageTitle = "Edit Category | $appName";


// check url parameter
$canEdit = false;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $Session = new Session();
    $Categories = new Categories();

    // get category data by id
    $categoryData = $Categories->get_category_info($_GET['id']);

    // check if category is found
    if ($categoryData['dataFound']) {
        // check if category belongs to user
        $session_userId = $Session->getSessionUserId();
        if ($categoryData['data']['user_id'] == $session_userId) {
            $canEdit = true;
        }
    }
}
if (!$canEdit) {
    header('Location: ../categories-list/index.php');
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
                            <h3>Edit Category</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="../categories-list/index.php">Categories List</a></li>
                                <li class="breadcrumb-item active">Edit Category</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <div class="bookmark">
                                <a class="btn btn-success" href="../categories-list/index.php"><i class="fa fa-list"></i> Categories List</a>
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
                                        <label class="col-sm-4 col-form-label" for="category-name">Name <code>*</code></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="category-name" value="<?php echo $categoryData['data']['name']; ?>" placeholder="Category name">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-4 col-form-label" for="category-description">Description</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="category-description" value="<?php echo $categoryData['data']['description']; ?>" placeholder="Category description">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-4 col-form-label" for="category-color">Color <code>*</code></label>
                                        <div class="col-sm-8">
                                            <input type="color" class="form-control form-control-color" id="category-color" value="<?php echo $categoryData['data']['color']; ?>" value="#24695c">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-4 col-form-label" for="category-color">Passwords In Category</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="category-passwords-count" value="<?php echo $categoryData['data']['password_count']; ?>" placeholder="<?php echo $categoryData['data']['password_count']; ?>" disabled readonly>
                                        </div>
                                        <small>Number of passwords in this category</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" id="submit">Submit</button>
                                <button class="btn btn-secondary" id="cancel"><i class="fa fa-times"></i> Cancel</button>
                                <button class="btn btn-danger" id="delete"><i class="fa fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_category_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title">Delete Category</h5>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete this category ?</p>
                <p>Currently you have <span class="font-weight-bold" id="passwords-count">0</span> passwords in this category</p>
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