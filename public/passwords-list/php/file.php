<?php

if (isset($_GET['model']) && $_GET['model'] === 'fetchPasswords') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/categories/Categories.php';
    require_once '../../../classes/passwords/Passwords.php';
    $Session = new Session();
    $Categories = new Categories();
    $Passwords = new Passwords();

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    // check if user is logged
    if ($Session->isLogged()) {
        // get user passwords
        $userPasswords = $Passwords->get_user_passwords($session_userId);

        echo json_encode($userPasswords);
    }
    else {
        echo json_encode(array('error' => 'Unauthorized access'));
        return;
    }

}