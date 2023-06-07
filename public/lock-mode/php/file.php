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

if (isset($_POST['model']) && $_POST['model'] === 'checkPinCode') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/users/Users.php';
    $Session = new Session();
    $Users = new Users();

    $res = array(
        'isValid' => false,
        'errors' => array()
    );

    // check pin code
    if (isset($_POST['pinCode'])) {
        // check if numeric
        if (is_numeric($_POST['pinCode'])) {
            // get user data by session id
            $session_userId = $Session->getSessionUserId();
            $userData = $Users->get_data_by_id($session_userId);

            // check if user found by that id
            if ($userData['state']) {
                // check if Pin Code is correct
                if ($userData['data']['pin_code'] == $_POST['pinCode']) {
                    // unlock lock mode session
                    $Session->setLockMode(false);

                    // update flag
                    $res['isValid'] = true;

                    echo json_encode($res);
                    exit;
                }
                // incorrect pin code
                else {
                    $res['errors'][] = array(
                        'error' => $ERROR_CODES['PINCODE']['VALIDATION']['IDENTIFIERS']['PINCODE_IDENTIFIER']['IDENTIFIER_INCORRECT']['NAME'],
                        'errorCode' => $ERROR_CODES['PINCODE']['VALIDATION']['IDENTIFIERS']['PINCODE_IDENTIFIER']['IDENTIFIER_INCORRECT']['CODE'],
                    );
                    echo json_encode($res);
                    exit;
                }
            }
            // no user was found with this id
            else {
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['PINCODE']['VALIDATION']['IDENTIFIERS']['PINCODE_IDENTIFIER']['IDENTIFIER_OWNER_NOT_FOUND']['NAME'],
                    'errorCode' => $ERROR_CODES['PINCODE']['VALIDATION']['IDENTIFIERS']['PINCODE_IDENTIFIER']['IDENTIFIER_OWNER_NOT_FOUND']['CODE'],
                );
                echo json_encode($res);
                exit;
            }
        }
        // pin code is not numeric
        else {
            $res['errors'][] = array(
                'error' => $ERROR_CODES['PINCODE']['VALIDATION']['IDENTIFIERS']['PINCODE_IDENTIFIER']['IDENTIFIER_MUST_CONTAIN_NUMBERS_ONLY']['NAME'],
                'errorCode' => $ERROR_CODES['PINCODE']['VALIDATION']['IDENTIFIERS']['PINCODE_IDENTIFIER']['IDENTIFIER_MUST_CONTAIN_NUMBERS_ONLY']['CODE'],
            );
            echo json_encode($res);
            exit;
        }
    }
    // pin code not found in request data
    else {
        $res['errors'][] = array(
            'error' => $ERROR_CODES['PINCODE']['VALIDATION']['IDENTIFIERS']['PINCODE_IDENTIFIER']['IDENTIFIER_NOT_FOUND_IN_REQUEST']['NAME'],
            'errorCode' => $ERROR_CODES['PINCODE']['VALIDATION']['IDENTIFIERS']['PINCODE_IDENTIFIER']['IDENTIFIER_NOT_FOUND_IN_REQUEST']['CODE'],
        );
        echo json_encode($res);
        exit;
    }
}