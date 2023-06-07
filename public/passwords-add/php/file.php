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

if (isset($_POST['model']) && $_POST['model'] === 'addNewPassword' && $session_isLogged) {
    // this will reject request and return error message to user then do exit;
    require_once '../../../functions/requests/reject-request-in-lock-mode.php';

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    $validCategoryId = false;
    $validUsername = false;
    $validPassword = false;

    $res = array(
        'dataInserted' => true,
        'errors' => array()
    );

    // check category id
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
                $res['dataInserted'] = false;
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['PASSWORDS']['INSERT']['VALIDATION']['CATEGORY']['DOESNT_BELONG_TO_USER']['NAME'],
                    'errorCode' => $ERROR_CODES['PASSWORDS']['INSERT']['VALIDATION']['CATEGORY']['DOESNT_BELONG_TO_USER']['CODE'],
                );
                echo json_encode($res);
                exit;
            }
        }
        else {
            $res['dataInserted'] = false;
            $res['errors'][] = array(
                'error' => $ERROR_CODES['PASSWORDS']['INSERT']['VALIDATION']['CATEGORY']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['PASSWORDS']['INSERT']['VALIDATION']['CATEGORY']['NOT_FOUND']['CODE'],
            );
            echo json_encode($res);
            exit;
        }
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

        $result = $Passwords->create_password($session_userId, $data);
        if ($result['dataInserted']) {
            $res['dataInserted'] = true;
        }
        else {
            $res['dataInserted'] = false;
            $res['errors'] = $result['errors'];
        }
    }
    else {
        $res['dataInserted'] = false;
        $res['errors'][] = array(
            'error' => $ERROR_CODES['PASSWORDS']['INSERT']['VALIDATION']['FIELDS']['ONE_OR_MORE_ARE_INVALID']['NAME'],
            'errorCode' => $ERROR_CODES['PASSWORDS']['INSERT']['VALIDATION']['FIELDS']['ONE_OR_MORE_ARE_INVALID']['CODE'],
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