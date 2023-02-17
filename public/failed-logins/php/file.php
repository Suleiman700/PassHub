<?php

// this will reject request and return error message to user then do exit;
require_once '../../../functions/requests/reject-request-in-lock-mode.php';

if (isset($_GET['model']) && $_GET['model'] === 'fetchFailedLogins') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/authentication/FailedLogins.php';
    $Session = new Session();
    $FailedLogins = new FailedLogins();

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    // get login history
    $FailedLogins->setUserId($session_userId);
    $response = $FailedLogins->get_history_of_user_id();

    echo json_encode($response);
}