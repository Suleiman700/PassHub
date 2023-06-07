<?php
require_once '../../settings/config.php';
require_once '../../classes/authentication/Session.php';
$pageTitle = "Lock Mode | $appName";


// redirect user if not in lock mode
$Session = new Session();
$Session->setLockMode(true);
if (!$Session->inLockMode()) {
    header('Location: ../dashboard/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="../../assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../../assets/images/favicon.png" type="image/x-icon">
    <title><?php echo $pageTitle; ?></title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
    <link id="color" rel="stylesheet" href="../../assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/responsive.css">
</head>
<body class="dark-only">
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader">
        <div class="loader-p"></div>
    </div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper" id="pageWrapper">
    <!-- Page Body Start-->
    <div class="container-fluid p-0">
        <div class="comingsoon">
            <div class="comingsoon-inner text-center">
                <a href="javascript:void(0)"><img src="../../assets/images/logo/logo.png" alt="" width="20%"></a>
                <h2 class="pt-3">Lock Mode</h2>
                <div class="row d-flex justify-content-center">
                    <h5 class="col-sm-12 col-md-6 text-warning" id="message"></h5>
                </div>
                <style>
                    .input-square {
                        /*width: 50px;*/
                        /*height: 50px;*/
                        text-align: center;
                        /*border: 1px solid black;*/
                        margin: 0 5px;
                        /*background: #005e4d;*/
                        /*color: white;*/
                        /*font-size: 34px;*/


                        display: -webkit-box;
                        display: -ms-flexbox;
                        display: flex;
                        -webkit-box-pack: center;
                        -ms-flex-pack: center;
                        justify-content: center;
                        -webkit-box-align: center;
                        -ms-flex-align: center;
                        align-items: center;
                        border-radius: 20px;
                        color: #fff;
                        font-weight: 500;
                        width: 80px;
                        height: 80px;
                        font-size: 36px;
                        background: #24695c;
                    }
                    .input-square:focus {
                        background: #24695c !important;
                    }
                    .input-square:disabled {
                        background: #1541396e !important;
                    }

                </style>
                <div class="form-inline pt-3">
                    <input type="text" class="form-control input-square" id="input1" maxlength="1" oninput="validateAndMove(this)">
                    <input type="text" class="form-control input-square" id="input2" maxlength="1" oninput="validateAndMove(this)">
                    <input type="text" class="form-control input-square" id="input3" maxlength="1" oninput="validateAndMove(this)">
                    <input type="text" class="form-control input-square" id="input4" maxlength="1" oninput="validateAndMove(this)">
                </div>
                <h6 class="pt-3" id="info-label" style="display: block;">Enter PIN Code To Unlock</h6>
            </div>
        </div>
    </div>
</div>

<!-- page-wrapper end-->
<!-- latest jquery-->
<script src="../../assets/libs/jquery/jquery-3.5.1.min.js"></script>
<!-- Bootstrap js-->
<script src="../../assets/js/bootstrap/popper.min.js"></script>
<script src="../../assets/js/bootstrap/bootstrap.min.js"></script>
<!-- Plugins JS start-->
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="../../assets/js/script.js" type="module"></script>
<!-- Plugin used-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../assets/libs/sweetalert/sweetalert2_11.7.1.js"></script>

<script src="./js/init.js" type="module"></script>

<script>
    $('.loader-wrapper').fadeOut('fast', function() {
        $(this).remove();
    });
</script>
</body>
</html>