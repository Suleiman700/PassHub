<?php

require_once '../../../settings/ERROR_CODES.php';
require_once '../../../classes/authentication/Session.php';
$Session = new Session();

// reject request if user is in lock mode
if ($Session->inLockMode()) {
    $res = array(
        'dataFound' => false,
        'data' => array(),
        'errors' => array(),
        'showErrors' => true, // true/false if you want to display errors to the user
    );

    $res['errors'][] = array(
        'error' => $ERROR_CODES['REQUESTS']['REJECTED']['IN_LOCK_MODE']['NAME'],
        'errorCode' => $ERROR_CODES['REQUESTS']['REJECTED']['IN_LOCK_MODE']['CODE'],
    );

    echo json_encode($res);
    exit;
}
