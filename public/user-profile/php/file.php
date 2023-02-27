<?php

require_once '../../../classes/mail/Mail.php';
require_once '../../../classes/authentication/Session.php';
require_once '../../../classes/categories/Categories.php';
require_once '../../../classes/passwords/Passwords.php';
require_once '../../../classes/authentication/Login.php';
require_once '../../../classes/users/Users.php';
require_once '../../../classes/users/UsersSettings.php';
require_once '../../../settings/ERROR_CODES.php';
require_once '../../../functions/validators/validate-pin-code.php';
$Mail = new Mail();
$Session = new Session();
$Categories = new Categories();
$Passwords = new Passwords();
$Login = new Login();
$Users = new Users();
$UsersSettings = new UsersSettings();

// check if logged
$session_isLogged = $Session->isLogged();

if (isset($_POST['model']) && $_POST['model'] === 'performFullNameChange' && $session_isLogged) {
    // this will reject request and return error message to user then do exit;
    require_once '../../../functions/requests/reject-request-in-lock-mode.php';

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    $validFullName = false;
    $validPassword = false;

    $res = array(
        'dataUpdated' => false,
        'errors' => array()
    );

    // check fullname
    if (isset($_POST['fullName']) && !empty($_POST['fullName'])) {
        $validFullName = true;
    }

    // check password
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $validPassword = true;
    }

    if ($validFullName && $validPassword) {
        // get user data
        $userData = $Users->get_data_by_id($session_userId);

        // check if user data found
        if ($userData['state']) {
            $Login->setPassword($_POST['password']);
            $hashedPassword = $userData['data']['password'];

            // matching password
            if ($Login->verify_password_hash($hashedPassword)) {
                // update fullname
                $updateResults = $Users->update_fullname($_POST['fullName'], $session_userId);

                $res['dataUpdated'] = $updateResults['dataUpdated'];
                $res['errors'] = $updateResults['errors'];

                // update session fullname if query success
                if ($res['dataUpdated']) {
                    $Session->setSessionUsername($_POST['fullName']);
                }
            }
            // non-matching password
            else {
                $res['dataUpdated'] = false;
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['USER_PROFILE']['UPDATE']['FULLNAME']['VALIDATION']['INVALID_PASSWORD']['NAME'],
                    'errorCode' => $ERROR_CODES['USER_PROFILE']['UPDATE']['FULLNAME']['VALIDATION']['INVALID_PASSWORD']['CODE'],
                );
            }

//            echo '<pre>';
//            print_r($userData);
//            echo '</pre>';

        }
        // user data not found
        else {
            $res['dataUpdated'] = false;
            $res['errors'][] = array(
                'error' => $ERROR_CODES['USER_PROFILE']['UPDATE']['FULLNAME']['VALIDATION']['USER_DATA']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['USER_PROFILE']['UPDATE']['FULLNAME']['VALIDATION']['USER_DATA']['NOT_FOUND']['CODE'],
            );
        }
    }
    else {
        $res['dataUpdated'] = false;
        // store error
        $res['errors'][] = array(
            'error' => $ERROR_CODES['USER_PROFILE']['UPDATE']['FULLNAME']['VALIDATION']['ONE_OR_MORE_FIELDS_ARE_INVALID']['NAME'],
            'errorCode' => $ERROR_CODES['USER_PROFILE']['UPDATE']['FULLNAME']['VALIDATION']['ONE_OR_MORE_FIELDS_ARE_INVALID']['CODE'],
        );
    }



//    echo '<pre>';
//    print_r($userData);
//    echo '</pre>';

    echo json_encode($res);

    // verify user password



    // check password identifier
//    if (isset($_POST['passwordIdentifier']) && strlen($_POST['passwordIdentifier'])) {
//        // check if password identifier exists
//        $passwordInfo = $Passwords->get_password_info($_POST['passwordIdentifier'], $session_userId);
//        if ($passwordInfo['dataFound']) {
//            // check if password identifier belongs to user
//            if ($passwordInfo['data']['user_id'] == $session_userId) {
//                $validPasswordId = true;
//            }
//            // password identifier doesn't belong to user
//            else {
//                $res['dataUpdated'] = false;
//                $res['errors'][] = array(
//                    'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_DOESNT_BELONG_TO_USER']['NAME'],
//                    'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_DOESNT_BELONG_TO_USER']['CODE'],
//                );
//                echo json_encode($res);
//                exit;
//            }
//        }
//        // password identifier not found in database
//        else {
//            $res['dataUpdated'] = false;
//            $res['errors'][] = array(
//                'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_NOT_FOUND']['NAME'],
//                'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_NOT_FOUND']['CODE'],
//            );
//            echo json_encode($res);
//            exit;
//        }
//    }
//    // password identifier not found in request data
//    else {
//        $res['dataUpdated'] = false;
//        $res['errors'][] = array(
//            'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_NOT_FOUND_IN_REQUEST']['NAME'],
//            'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['IDENTIFIERS']['PASSWORD_IDENTIFIER']['IDENTIFIER_NOT_FOUND_IN_REQUEST']['CODE'],
//        );
//        echo json_encode($res);
//        exit;
//    }
//
//
//    // check category id field
//    if (isset($_POST['categoryId']) && strlen($_POST['categoryId'])) {
//        // check if category exists
//        $categoryData = $Categories->get_category_info($_POST['categoryId']);
//        if ($categoryData['dataFound']) {
//            // check if category belongs to user
//            if ($session_userId == $categoryData['data']['user_id']) {
//                $validCategoryId = true;
//            }
//            // category doesn't belong to user
//            else {
//                $res['dataUpdated'] = false;
//                $res['errors'][] = array(
//                    'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['DOESNT_BELONG_TO_USER']['NAME'],
//                    'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['DOESNT_BELONG_TO_USER']['CODE'],
//                );
//                echo json_encode($res);
//                exit;
//            }
//        }
//        else {
//            $res['dataUpdated'] = false;
//            $res['errors'][] = array(
//                'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['NOT_FOUND']['NAME'],
//                'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['NOT_FOUND']['CODE'],
//            );
//            echo json_encode($res);
//            exit;
//        }
//    }
//    // category id not found in request data
//    else {
//        $res['dataUpdated'] = false;
//        $res['errors'][] = array(
//            'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['NOT_FOUND_IN_REQUEST']['NAME'],
//            'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['CATEGORY']['NOT_FOUND_IN_REQUEST']['CODE'],
//        );
//        echo json_encode($res);
//        exit;
//    }
//
//    // check username
//    if (isset($_POST['username']) && !empty($_POST['username'])) {
//        $validUsername = true;
//    }
//
//    // check password
//    if (isset($_POST['password']) && !empty($_POST['password'])) {
//        $validPassword = true;
//    }
//
//    // check if all parameters are valid
//    if ($validUsername && $validPassword && $validCategoryId) {
//        $data = array(
//            'categoryId' => trim($_POST['categoryId']),
//            'username' => trim($_POST['username']),
//            'password' => trim($_POST['password']),
//            'website' => trim($_POST['website']??''),
//            'description' => trim($_POST['description']??''),
//            'note' => trim($_POST['note']??''),
//        );
//
//        $result = $Passwords->update_password($_POST['passwordIdentifier'], $session_userId,$data);
//        if ($result['dataUpdated']) {
//            $res['dataUpdated'] = true;
//        }
//        else {
//            $res['dataUpdated'] = false;
//            $res['errors'] = $result['errors'];
//        }
//    }
//    // one ore more fields are invalid
//    else {
//        $res['dataUpdated'] = false;
//        $res['errors'][] = array(
//            'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['ONE_OR_MORE_ARE_INVALID']['NAME'],
//            'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['VALIDATION']['FIELDS']['ONE_OR_MORE_ARE_INVALID']['CODE'],
//        );
//    }
//
//    echo json_encode($res);
}
if (isset($_POST['model']) && $_POST['model'] === 'performPasswordChange' && $session_isLogged) {
    // this will reject request and return error message to user then do exit;
    require_once '../../../functions/requests/reject-request-in-lock-mode.php';

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    $validOriginalPassword = false;
    $validNewPassword = false;

    $res = array(
        'dataUpdated' => false,
        'errors' => array()
    );

    // check original password
    if (isset($_POST['originalPassword']) && !empty($_POST['originalPassword'])) {
        $validOriginalPassword = true;
    }

    // check password
    if (isset($_POST['newPassword']) && !empty($_POST['newPassword'])) {
        $validNewPassword = true;
    }

    if ($validOriginalPassword && $validNewPassword) {
        // get user data
        $userData = $Users->get_data_by_id($session_userId);

        // check if user data found
        if ($userData['state']) {
            $Login->setPassword($_POST['originalPassword']);
            $hashedPassword = $userData['data']['password'];

            // matching password
            if ($Login->verify_password_hash($hashedPassword)) {
                // hash new password
                $hashed_password = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

                // update password
                $updateResults = $Users->update_password($hashed_password, $userData['data']['id']);

                // check if user enabled password change email alerts
                if ($UsersSettings->is_password_change_alert_enabled($userData['data']['id'])) {
                    // send alert to user email
                    $Mail->send_password_change_alert($userData['data']['email']);
                }

                $res['dataUpdated'] = $updateResults['dataUpdated'];
                $res['errors'] = $updateResults['errors'];
            }
            // non-matching password
            else {
                $res['dataUpdated'] = false;
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PASSWORD']['VALIDATION']['INVALID_PASSWORD']['NAME'],
                    'errorCode' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PASSWORD']['VALIDATION']['INVALID_PASSWORD']['CODE'],
                );
            }
        }
        // user data not found
        else {
            $res['dataUpdated'] = false;
            $res['errors'][] = array(
                'error' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PASSWORD']['VALIDATION']['USER_DATA']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PASSWORD']['VALIDATION']['USER_DATA']['NOT_FOUND']['CODE'],
            );
        }
    }
    else {
        $res['dataUpdated'] = false;
        // store error
        $res['errors'][] = array(
            'error' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PASSWORD']['VALIDATION']['ONE_OR_MORE_FIELDS_ARE_INVALID']['NAME'],
            'errorCode' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PASSWORD']['VALIDATION']['ONE_OR_MORE_FIELDS_ARE_INVALID']['CODE'],
        );
    }

    echo json_encode($res);
}
if (isset($_POST['model']) && $_POST['model'] === 'performPinCodeChange' && $session_isLogged) {
    // this will reject request and return error message to user then do exit;
    require_once '../../../functions/requests/reject-request-in-lock-mode.php';

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    $validNewPinCode = false;
    $validPassword = false;

    $res = array(
        'dataUpdated' => false,
        'errors' => array()
    );

    // check new Pin Code
    if (isset($_POST['newPinCode']) && !empty($_POST['newPinCode'])) {
        $validNewPinCode = true;
    }
    
    // validate new Pin Code
    if (isset($_POST['newPinCode']) && !validate_pin_code($_POST['newPinCode'])) {
        $validNewPinCode = false;
        // update flag
        $res['dataUpdated'] = false;
        // store error
        $res['errors'][] = array(
            'error' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PINCODE']['VALIDATION']['PIN_CODE_SHOULD_BE_4_DIGITS']['NAME'],
            'errorCode' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PINCODE']['VALIDATION']['PIN_CODE_SHOULD_BE_4_DIGITS']['CODE'],
        );
        echo json_encode($res);
        exit;
    }

    // check password
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $validPassword = true;
    }

    if ($validNewPinCode && $validPassword) {
        // get user data
        $userData = $Users->get_data_by_id($session_userId);

        // check if user data found
        if ($userData['state']) {
            $Login->setPassword($_POST['password']);
            $hashedPassword = $userData['data']['password'];

            // matching password
            if ($Login->verify_password_hash($hashedPassword)) {
                // update Pin Code
                $updateResults = $Users->update_pin_code($_POST['newPinCode'], $userData['data']['id']);

                // check if user enabled Pin Code change email alerts
                if ($UsersSettings->is_pin_code_change_alert_enabled($userData['data']['id'])) {
                    // send alert to user email
                    $Mail->send_pin_code_change_alert($userData['data']['email']);
                }

                $res['dataUpdated'] = $updateResults['dataUpdated'];
                $res['errors'] = $updateResults['errors'];
            }
            // non-matching password
            else {
                $res['dataUpdated'] = false;
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PINCODE']['VALIDATION']['INVALID_PASSWORD']['NAME'],
                    'errorCode' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PINCODE']['VALIDATION']['INVALID_PASSWORD']['CODE'],
                );
            }
        }
        // user data not found
        else {
            $res['dataUpdated'] = false;
            $res['errors'][] = array(
                'error' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PINCODE']['VALIDATION']['USER_DATA']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PINCODE']['VALIDATION']['USER_DATA']['NOT_FOUND']['CODE'],
            );
        }
    }
    else {
        $res['dataUpdated'] = false;
        // store error
        $res['errors'][] = array(
            'error' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PINCODE']['VALIDATION']['ONE_OR_MORE_FIELDS_ARE_INVALID']['NAME'],
            'errorCode' => $ERROR_CODES['USER_PROFILE']['UPDATE']['PINCODE']['VALIDATION']['ONE_OR_MORE_FIELDS_ARE_INVALID']['CODE'],
        );
    }

    echo json_encode($res);
}
