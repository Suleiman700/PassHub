<?php

require_once '../../../classes/authentication/Session.php';
require_once '../../../classes/categories/Categories.php';
require_once '../../../classes/passwords/Passwords.php';
require_once '../../../settings/ERROR_CODES.php';
$Session = new Session();
$Categories = new Categories();
$Passwords = new Passwords();

// check if logged
$session_isLogged = $Session->isLogged();

if (isset($_POST['model']) && $_POST['model'] === 'checkTwoFactorCode') {
    require_once '../../../classes/mail/Mail.php';
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/users/Users.php';
    require_once '../../../classes/users/UsersSettings.php';
    require_once '../../../classes/authentication/SuccessfulLogin.php';
    $Mail = new Mail();
    $Session = new Session();
    $Users = new Users();
    $UsersSettings = new UsersSettings();
    $SuccessfulLogin = new SuccessfulLogin();

    $res = array(
        'isValid' => false,
        'errors' => array()
    );

    // check pin code
    if (isset($_POST['twoFactorCode'])) {
        // check if numeric
        if (is_numeric($_POST['twoFactorCode'])) {
            // get user data by session id
            $session_userId = $Session->getSessionUserId();
            $session_userEmail = $Session->getSessionUserEmail();
            $userSettings = $UsersSettings->get_user_settings($session_userId);

            // check if user found by that id
            if ($userSettings['dataFound']) {
                // check if Pin Code is correct
                if ($userSettings['data']['twofactor_code'] == $_POST['twoFactorCode']) {
                    // unlock lock mode session
                    $Session->set2FAMode(false);

                    // update flag
                    $res['isValid'] = true;

                    // check is user enabled sending login alerts email
                    if ($UsersSettings->is_login_alerts_enabled($session_userId)) {
                        // send login alert to user email
                        $Mail->send_with_2fa_completed_login_alert($session_userEmail);
                    }

                    // store successful login
                    $SuccessfulLogin->setUserId($session_userId);
                    $SuccessfulLogin->setIpAddress($_SERVER['REMOTE_ADDR']);
                    $SuccessfulLogin->setUserAgent($_SERVER['HTTP_USER_AGENT']);
                    $SuccessfulLogin->save();

                    echo json_encode($res);
                    exit;
                }
                // incorrect two factor code
                else {
                    $res['errors'][] = array(
                        'error' => $ERROR_CODES['TWOFACTOR']['VALIDATION']['IDENTIFIERS']['TWOFACTOR_IDENTIFIER']['IDENTIFIER_INCORRECT']['NAME'],
                        'errorCode' => $ERROR_CODES['TWOFACTOR']['VALIDATION']['IDENTIFIERS']['TWOFACTOR_IDENTIFIER']['IDENTIFIER_INCORRECT']['CODE'],
                    );
                    echo json_encode($res);
                    exit;
                }
            }
            // no user was found with this id
            else {
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['TWOFACTOR']['VALIDATION']['IDENTIFIERS']['TWOFACTOR_IDENTIFIER']['IDENTIFIER_OWNER_NOT_FOUND']['NAME'],
                    'errorCode' => $ERROR_CODES['TWOFACTOR']['VALIDATION']['IDENTIFIERS']['TWOFACTOR_IDENTIFIER']['IDENTIFIER_OWNER_NOT_FOUND']['CODE'],
                );
                echo json_encode($res);
                exit;
            }
        }
        // is not numeric
        else {
            $res['errors'][] = array(
                'error' => $ERROR_CODES['TWOFACTOR']['VALIDATION']['IDENTIFIERS']['TWOFACTOR_IDENTIFIER']['IDENTIFIER_MUST_CONTAIN_NUMBERS_ONLY']['NAME'],
                'errorCode' => $ERROR_CODES['TWOFACTOR']['VALIDATION']['IDENTIFIERS']['TWOFACTOR_IDENTIFIER']['IDENTIFIER_MUST_CONTAIN_NUMBERS_ONLY']['CODE'],
            );
            echo json_encode($res);
            exit;
        }
    }
    // was not found in request data
    else {
        $res['errors'][] = array(
            'error' => $ERROR_CODES['TWOFACTOR']['VALIDATION']['IDENTIFIERS']['TWOFACTOR_IDENTIFIER']['IDENTIFIER_NOT_FOUND_IN_REQUEST']['NAME'],
            'errorCode' => $ERROR_CODES['TWOFACTOR']['VALIDATION']['IDENTIFIERS']['TWOFACTOR_IDENTIFIER']['IDENTIFIER_NOT_FOUND_IN_REQUEST']['CODE'],
        );
        echo json_encode($res);
        exit;
    }
}