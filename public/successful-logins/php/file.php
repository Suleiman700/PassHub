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
else if (isset($_POST['model']) && $_POST['model'] === 'performHistoryDelete') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/authentication/SuccessfulLogin.php';
    $Session = new Session();
    $SuccessfulLogin = new SuccessfulLogin();

    $session_userId = $Session->getSessionUserId();

    $validHistoryId = false;

    $res = array(
        'dataDeleted' => false,
        'errors' => array()
    );

    // check history id
    if (isset($_POST['historyId']) && strlen($_POST['historyId'])) {
        $historyId = $_POST['historyId'];

        // check if history id exist
        $historyData = $SuccessfulLogin->get_history_by_id($historyId);
        if ($historyData['dataFound']) {
            // check if category belongs to user
            if ($historyData['data']['user_id'] == $session_userId) {
                $validHistoryId = true;
            }
            // history does not belong to user
            else {
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['VALIDATION']['DOESNT_BELONG_TO_USER']['NAME'],
                    'errorCode' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['VALIDATION']['DOESNT_BELONG_TO_USER']['CODE'],
                );
            }
        }
        // History was not found
        else {
            $res['errors'][] = array(
                'error' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['VALIDATION']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['VALIDATION']['NOT_FOUND']['CODE'],
            );
        }
    }
    // History identifier was not found
    else {
        $res['errors'][] = array(
            'error' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['VALIDATION']['IDENTIFIER_NOT_FOUND']['NAME'],
            'errorCode' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['VALIDATION']['IDENTIFIER_NOT_FOUND']['CODE'],
        );
    }


    // check if all parameters are valid
    if ($validHistoryId) {
        // delete category
        $result = $SuccessfulLogin->delete_history_by_id(trim($_POST['historyId']));

        if ($result['dataDeleted']) {
            $res['dataDeleted'] = true;
            $res['errors'] = $result['errors'];
        }
    }


    echo json_encode($res);
}
else if (isset($_POST['model']) && $_POST['model'] === 'performAllHistoryDelete') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/authentication/SuccessfulLogin.php';
    $Session = new Session();
    $SuccessfulLogin = new SuccessfulLogin();

    $session_userId = $Session->getSessionUserId();

    $validHistoryId = false;

    $res = array(
        'dataDeleted' => false,
        'errors' => array()
    );

    // delete user history
    $SuccessfulLogin->setUserId($session_userId);
    $userHistory = $SuccessfulLogin->get_history_of_user_id();
    if ($userHistory['dataFound']) {
        $data = $SuccessfulLogin->delete_all_user_history();

        if ($data['dataDeleted']) {
            $res['dataDeleted'] = true;
        }
        else {
            $res['errors'] = $data['errors'];
        }
    }
    // user does not have history
    else {
        $res['errors'][] = array(
            'error' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['VALIDATION']['USER_DOES_NOT_HAVE_HISTORY']['NAME'],
            'errorCode' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['VALIDATION']['USER_DOES_NOT_HAVE_HISTORY']['CODE'],
        );
    }


    echo json_encode($res);
}