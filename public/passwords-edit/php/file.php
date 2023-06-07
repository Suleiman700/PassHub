<?php

require_once '../../../settings/config.php';
require_once '../../../classes/authentication/Session.php';
require_once '../../../classes/categories/Categories.php';
require_once '../../../classes/passwords/Passwords.php';
require_once '../../../settings/ERROR_CODES.php';
$Session = new Session();
$Categories = new Categories();
$Passwords = new Passwords();

// check if logged
$session_isLogged = $Session->isLogged();

if (isset($_POST['model']) && $_POST['model'] === 'updatePassword' && $session_isLogged) {
    // this will reject request and return error message to user then do exit;
    require_once '../../../functions/requests/reject-request-in-lock-mode.php';

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    $validPasswordId = false;
    $validCategoryId = false;
    $validUsername = false;
    $validPassword = false;

    $res = array(
        'dataUpdated' => true,
        'errors' => array()
    );

    // check password identifier
    if (isset($_POST['passwordIdentifier']) && strlen($_POST['passwordIdentifier'])) {
        // check if password identifier exists
        $passwordInfo = $Passwords->get_password_info($_POST['passwordIdentifier'], $session_userId);
        if ($passwordInfo['dataFound']) {
            // check if password identifier belongs to user
            if ($passwordInfo['data']['user_id'] == $session_userId) {
                $validPasswordId = true;
            }
            // password identifier doesn't belong to user
            else {
                $res['dataUpdated'] = false;
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_DOESNT_BELONG_TO_USER']['NAME'],
                    'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_DOESNT_BELONG_TO_USER']['CODE'],
                );
                echo json_encode($res);
                exit;
            }
        }
        // password identifier not found in database
        else {
            $res['dataUpdated'] = false;
            $res['errors'][] = array(
                'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_NOT_FOUND']['CODE'],
            );
            echo json_encode($res);
            exit;
        }
    }
    // password identifier not found in request data
    else {
        $res['dataUpdated'] = false;
        $res['errors'][] = array(
            'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_NOT_FOUND_IN_REQUEST']['NAME'],
            'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_NOT_FOUND_IN_REQUEST']['CODE'],
        );
        echo json_encode($res);
        exit;
    }


    // check category id field
    if (isset($_POST['categoryId']) && strlen($_POST['categoryId'])) {
        // check if category exists
        $categoryData = $Categories->get_category_info($_POST['categoryId']);
        if ($categoryData['dataFound']) {
            // check if category belongs to user
            if ($session_userId == $categoryData['data']['user_id']) {
                $validCategoryId = true;
            }
            // category doesn't belong to user
            else {
                $res['dataUpdated'] = false;
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['DOESNT_BELONG_TO_USER']['NAME'],
                    'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['DOESNT_BELONG_TO_USER']['CODE'],
                );
                echo json_encode($res);
                exit;
            }
        }
        else {
            $res['dataUpdated'] = false;
            $res['errors'][] = array(
                'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['NOT_FOUND']['CODE'],
            );
            echo json_encode($res);
            exit;
        }
    }
    // category id not found in request data
    else {
        $res['dataUpdated'] = false;
        $res['errors'][] = array(
            'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['NOT_FOUND_IN_REQUEST']['NAME'],
            'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['NOT_FOUND_IN_REQUEST']['CODE'],
        );
        echo json_encode($res);
        exit;
    }

    // check username
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $validUsername = true;
    }

    // check password
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $validPassword = true;
    }

    // check if all parameters are valid
    if ($validUsername && $validPassword && $validCategoryId) {
        $data = array(
            'categoryId' => trim($_POST['categoryId']),
            'username' => trim($_POST['username']),
            'password' => trim($_POST['password']),
            'website' => trim($_POST['website']??''),
            'description' => trim($_POST['description']??''),
            'note' => trim($_POST['note']??''),
        );

        $result = $Passwords->update_password($_POST['passwordIdentifier'], $session_userId,$data);
        if ($result['dataUpdated']) {
            $res['dataUpdated'] = true;
        }
        else {
            $res['dataUpdated'] = false;
            $res['errors'] = $result['errors'];
        }
    }
    // one ore more fields are invalid
    else {
        $res['dataUpdated'] = false;
        $res['errors'][] = array(
            'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['ONE_OR_MORE_ARE_INVALID']['NAME'],
            'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['ONE_OR_MORE_ARE_INVALID']['CODE'],
        );
    }

    echo json_encode($res);
}
else if (isset($_GET['model']) && $_GET['model'] === 'fetchCategories') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/categories/Categories.php';
    $Session = new Session();
    $Categories = new Categories();

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    // get user categories by id
    $categories = $Categories->get_user_categories($session_userId);

    echo json_encode($categories);
}
else if (isset($_POST['model']) && $_POST['model'] === 'performPasswordDelete') {
    // this will reject request and return error message to user then do exit;
    require_once '../../../functions/requests/reject-request-in-lock-mode.php';

    $session_userId = $Session->getSessionUserId();

    $validPasswordId = false;

    $res = array(
        'dataDeleted' => false,
        'errors' => array()
    );

    // check password id
    if (isset($_POST['passwordId']) && strlen($_POST['passwordId'])) {
        $passwordId = $_POST['passwordId'];

        // check if category exist
        $passwordData = $Passwords->get_password_info($passwordId, $session_userId);
        if ($passwordData['dataFound']) {
            // check if password belongs to user
            if ($passwordData['data']['user_id'] == $session_userId) {
                $validPasswordId = true;
            }
            // password does not belong to user
            else {
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['PASSWORDS']['DELETE']['VALIDATION']['DOESNT_BELONG_TO_USER']['NAME'],
                    'errorCode' => $ERROR_CODES['PASSWORDS']['DELETE']['VALIDATION']['DOESNT_BELONG_TO_USER']['CODE'],
                );
            }
        }
        // password id was not found in database
        else {
            $res['errors'][] = array(
                'error' => $ERROR_CODES['PASSWORDS']['DELETE']['VALIDATION']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['PASSWORDS']['DELETE']['VALIDATION']['NOT_FOUND']['CODE'],
            );
        }
    }
    // password identifier was not found in request data
    else {
        $res['errors'][] = array(
            'error' => $ERROR_CODES['PASSWORDS']['DELETE']['VALIDATION']['IDENTIFIER_NOT_FOUND']['NAME'],
            'errorCode' => $ERROR_CODES['PASSWORDS']['DELETE']['VALIDATION']['IDENTIFIER_NOT_FOUND']['CODE'],
        );
    }



    // check if all parameters are valid
    if ($validPasswordId) {
        // delete password
        $result = $Passwords->delete_password(trim($_POST['passwordId']));

        $res['dataDeleted'] = $result['dataDeleted'];
        $res['errors'] = $result['errors'];
    }


    echo json_encode($res);
}