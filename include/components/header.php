<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../classes/authentication/Session.php';
require_once '../../classes/categories/Categories.php';
require_once '../../classes/passwords/Passwords.php';

$Session = new Session();

// redirect non logged-in users to login page
if (!$Session->isLogged()) {
    header('Location: ../login/index.php');
    exit;
}

// redirect user if in lock mode
if ($Session->inLockMode()) {
    header('Location: ../lock-mode/index.php');
    exit;
}

// get user data from session
$session_userId = $Session->getSessionUserId();
$session_username = $Session->getSessionUsername();
$session_userEmail = $Session->getSessionUserEmail();
$session = $Session->getSessionUserEmail();

// get some statistics
$Categories = new Categories();
$Passwords = new Passwords();
$count_categories = $Categories->count_user_categories($session_userId);
$count_passwords = $Passwords->count_user_passwords($session_userId);
?>

<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left">
            <div class="logo-wrapper"><a href="index.html"><img class="img-fluid" src="../../assets/images/logo/logo.png" alt=""></a></div>
            <div class="dark-logo-wrapper"><a href="index.html"><img class="img-fluid" src="../../assets/images/logo/dark-logo.png" alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i></div>
        </div>
        <div class="left-menu-header col">
            <ul>
                <li>
                    <form class="form-inline search-form">
                        <div class="search-bg"><i class="fa fa-search"></i>
                            <input class="form-control-plaintext" placeholder="Search here.....">
                        </div>
                    </form><span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
                </li>
            </ul>
        </div>
        <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
                <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                <li><a class="text-dark" href="#!" onclick="javascript:enterLockMode()"><i data-feather="lock"></i></a></li>
                <li>
                    <div class="light-mode" style="cursor: pointer;"><i class="fa fa-circle-half-stroke"></i></div>
                </li>
                <li class="onhover-dropdown p-0">
                    <button class="btn btn-primary-light" type="button"><a href="../logout.php"><i data-feather="log-out"></i>Log out</a></button>
                </li>
            </ul>
        </div>
        <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
    </div>
</div>

<script>
    function enterLockMode() {
<!--        --><?php //$Session->setLockMode(true);?>

        window.location.href= '../lock-mode/index.php'
    }
</script>

<script type="module">
    import EncryptionService from '../../javascript/security/EncryptionService.js';
    const encryptionService = new EncryptionService()
    const encryptedMessage = await encryptionService.encryptMessage(`For your security, we've activated a lock mode due to inactivity. Please re-enter your credentials to resume using the site. This helps to prevent unauthorized access and ensure that your personal information remains protected.`);

    // inactivity lock
    import InactivityLock from '../../javascript/security/InactivityLock.js';
    InactivityLock.setMessage(encryptedMessage)
</script>