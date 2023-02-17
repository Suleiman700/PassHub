<?php

// this will reject request and return error message to user then do exit;
require_once '../../../functions/requests/reject-request-in-lock-mode.php';

if (isset($_GET['model']) && $_GET['model'] === 'fetchSuccessfulLogins') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/authentication/SuccessfulLogin.php';
    $Session = new Session();
    $SuccessfulLogin = new SuccessfulLogin();

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    // get login history
    $SuccessfulLogin->setUserId($session_userId);
    $response = $SuccessfulLogin->get_history_of_user_id();

    echo json_encode($response);
}