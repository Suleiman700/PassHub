<?php
require_once '../../settings/config.php';
$pageTitle = "Edit Profile | $appName";
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
                            <h3>Edit Profile</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Profile</li>
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
                                    <h4 class="card-title mb-0">My Profile</h4>
                                    <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mb-2">
                                            <div class="profile-title">
                                                <div class="media">
                                                    <img class="img-70 rounded-circle" alt="" src="../../assets/images/dashboard/1.png">
                                                    <div class="media-body">
                                                        <h3 class="mb-1 f-20 txt-primary" id="label_fullname"><?php echo $session_username; ?></h3>
                                                        <p class="f-12">MEMBER</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email-Address</label>
                                            <input class="form-control" placeholder="<?php echo $session_userEmail; ?>" disabled readonly>
                                        </div>
                                    </form>

                                    <hr class="my-5" />

                                    <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" id="tab-fullname" data-bs-toggle="tab" href="#section-fullname" role="tab" aria-controls="section-fullname" aria-selected="true"><i class="icofont icofont-user"></i>Full Name</a></li>
                                        <li class="nav-item"><a class="nav-link" id="top-password-tab" data-bs-toggle="tab" href="#section-change-password" role="tab" aria-controls="#section-change-password" aria-selected="true"><i class="icofont icofont-key"></i>Password</a></li>
                                        <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#section-change-pin-code" role="tab" aria-controls="section-change-pin-code" aria-selected="false"><i class="icofont icofont-pin"></i>Pin-Code</a></li>
                                    </ul>
                                    <div class="tab-content" id="top-tabContent">
                                        <div class="tab-pane fade active show" id="section-fullname" role="tabpanel" aria-labelledby="top-fullname-tab">
                                            <div class="row">
                                                <div class="card-header pb-0">
                                                    <h5>Change Your Name</h5>
                                                    <span>Change your account name.</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="theme-form">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="fullname">Full Name <code class="text-danger">*</code></label>
                                                            <input type="text" class="form-control" id="fullname" value="<?php echo $session_username; ?>" placeholder="John Doe">
                                                            <small class="form-text text-muted" id="emailHelp">We'll never share your data with anyone else.</small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="password">Password <code class="text-danger">*</code></label>
                                                            <input type="password" class="form-control" id="password" placeholder="Enter your account password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button class="btn btn-primary" id="save"><i class="fa fa-save"></i> Save</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="section-change-password" role="tabpanel" aria-labelledby="top-password-tab">
                                            <div class="row">
                                                <div class="card-header pb-0">
                                                    <h5>Change Your Password</h5>
                                                    <span>Change your account password.</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="theme-form">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="original-password">Original Password <code class="text-danger">*</code></label>
                                                            <input type="password" class="form-control" id="original-password" value="" placeholder="Enter your account password">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="new-password">New Password <code class="text-danger">*</code></label>
                                                            <input type="password" class="form-control" id="new-password" value="" placeholder="Enter your new password">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="confirm-new-password">Confirm New Password <code class="text-danger">*</code></label>
                                                            <input type="password" class="form-control" id="confirm-new-password" value="" placeholder="Confirm your new password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button class="btn btn-primary" id="save"><i class="fa fa-save"></i> Save</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="section-change-pin-code" role="tabpanel" aria-labelledby="profile-top-tab">
                                            <div class="row">
                                                <div class="card-header pb-0">
                                                    <h5>Change Your Pin Code</h5>
                                                    <span>Change your account Pin Code.</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="theme-form">
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="new-pin-code">New Pin Code <code class="text-danger">*</code></label>
                                                            <input type="text" class="form-control" id="new-pin-code" value="" placeholder="Enter your new Pin Code">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="col-form-label pt-0" for="password">Password <code class="text-danger">*</code></label>
                                                            <input type="password" class="form-control" id="password" value="" placeholder="Enter your account password">
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
                        </div>
                        <div class="col-xl-8" hidden>
                            <form class="card">
                                <div class="card-header pb-0">
                                    <h4 class="card-title mb-0">Edit Profile</h4>
                                    <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                                </div>
                                <div class="card-body" hidden>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label class="form-label">Company</label>
                                                <input class="form-control" type="text" placeholder="Company" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Username</label>
                                                <input class="form-control" type="text" placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Email address</label>
                                                <input class="form-control" type="email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">First Name</label>
                                                <input class="form-control" type="text" placeholder="Company">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Last Name</label>
                                                <input class="form-control" type="text" placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input class="form-control" type="text" placeholder="Home Address">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">City</label>
                                                <input class="form-control" type="text" placeholder="City">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Postal Code</label>
                                                <input class="form-control" type="number" placeholder="ZIP Code">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <label class="form-label">Country</label>
                                                <select class="form-control btn-square">
                                                    <option value="0">--Select--</option>
                                                    <option value="1">Germany</option>
                                                    <option value="2">Canada</option>
                                                    <option value="3">Usa</option>
                                                    <option value="4">Aus</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div>
                                                <label class="form-label">About Me</label>
                                                <textarea class="form-control" rows="5" placeholder="Enter About your description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn btn-primary" type="submit">Update Profile</button>
                                </div>
                            </form>
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
