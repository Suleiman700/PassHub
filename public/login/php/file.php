<?php

if (isset($_POST['model']) && $_POST['model'] === 'performLogin') {
    require_once '../../../settings/config.php';
    require_once '../../../classes/mail/Mail.php';
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/authentication/Login.php';
    require_once '../../../classes/authentication/SuccessfulLogin.php';
    require_once '../../../classes/authentication/FailedLogins.php';
    require_once '../../../classes/users/Users.php';
    require_once '../../../classes/users/UsersSettings.php';
    require_once '../../../classes/helpers/Generators.php';
    require_once '../../../functions/validators/validation-email.php';
    require_once '../../../functions/validators/validate-pin-code.php';

    $Mail = new Mail();
    $Login = new Login();
    $SuccessfulLogin = new SuccessfulLogin();
    $FailedLogins = new FailedLogins();
    $Users = new Users();
    $UsersSettings = new UsersSettings();
    $Generators = new Generators();
    $Session = new Session();

    // store errors
    $errors = array();

    // check email address
    if (isset($_POST['emailAddress']) && validate_email($_POST['emailAddress'])) {
        $Login->setEmailAddress(trim($_POST['emailAddress']));
    }
    else {
        $errors[] = 'Invalid email address';
    }

    // check password
    if (isset($_POST['password'])) {
        $Login->setPassword(trim($_POST['password']));
    }
    else {
        $errors[] = 'Invalid password';
    }

    // check pin code
    if (isset($_POST['pinCode']) && validate_pin_code($_POST['pinCode'])) {
        $Login->setPinCode(trim($_POST['pinCode']));
    }
    else {
        $errors[] = 'Invalid pin code';
    }

    // perform login is no errors found
    if (empty($errors)) {
        $state = '';
        $in2FA = false;

        // check if user found by email address
        $userData = $Users->get_data_by_email($Login->getEmailAddress());

        // user found
        if ($userData['state']) {
            // verify password hash
            $hashedPassword = $userData['data']['password'];
            if (!$Login->verify_password_hash($hashedPassword)) {
                $state = false;
                $errors[] = 'Invalid email address or password';

                // store password failed login
                $FailedLogins->setUserId($userData['data']['id']);
                $FailedLogins->setUsedPinCode($_POST['pinCode']);
                $FailedLogins->setUsedPassword($_POST['password']);
                $FailedLogins->setIpAddress($_SERVER['REMOTE_ADDR']);
                $FailedLogins->setUserAgent($_SERVER['HTTP_USER_AGENT']);
                $FailedLogins->setFailReason('Invalid password');
                $FailedLogins->save();
            }
            // verify pin code
            else if ($Login->getPinCode() != $userData['data']['pin_code']) {
                $state = false;
                $errors[] = 'Invalid pin code';

                // store pin code failed login
                $FailedLogins->setUserId($userData['data']['id']);
                $FailedLogins->setUsedPinCode($_POST['pinCode']);
                $FailedLogins->setUsedPassword($_POST['password']);
                $FailedLogins->setIpAddress($_SERVER['REMOTE_ADDR']);
                $FailedLogins->setUserAgent($_SERVER['HTTP_USER_AGENT']);
                $FailedLogins->setFailReason('Invalid pin code');
                $FailedLogins->save();
            }
            else {
                // set logged in session
                $Session->set_logged_session($userData['data']['id'], $userData['data']['email'], $userData['data']['fullname']);

                // check if user enabled 2FA
                if ($UsersSettings->is_2fa_enabled($userData['data']['id'])) {
                    // check is user enabled sending login alerts email
                    if ($UsersSettings->is_login_alerts_enabled($userData['data']['id'])) {
                        // send login alert to user email
                        $Mail->send_with_2fa_incomplete_login_alert($userData['data']['email']);
                    }

                    $in2FA = true;
                    $Session->set2FAMode(true);

                    // generate two factor code
                    $twoFactorCode = $Generators->gen_random_twofactor_code();
                    // save two factor code
                    $UsersSettings->save_twofactor_code($userData['data']['id'], $twoFactorCode);

                    $Mail->send_2fa_code($userData['data']['email'], $twoFactorCode);
                }
                // 2FA not enabled
                else {
                    // store successful login
                    $SuccessfulLogin->setUserId($userData['data']['id']);
                    $SuccessfulLogin->setIpAddress($_SERVER['REMOTE_ADDR']);
                    $SuccessfulLogin->setUserAgent($_SERVER['HTTP_USER_AGENT']);
                    $SuccessfulLogin->save();

                    // check is user enabled sending login alerts email
                    if ($UsersSettings->is_login_alerts_enabled($userData['data']['id'])) {
                        // send login alert to user email
                        $Mail->send_no_2fa_login_alert($userData['data']['email']);
                    }
                }

                $state = true;
            }
        }
        // user not found
        else {
            $state = false;
            $errors[] = 'Invalid email address or password';
        }

        echo json_encode(array('state' => $state, 'in2FA' => $in2FA, 'errors' => $errors));
    }
    else {
        echo json_encode(array('state' => false, 'errors' => $errors));
    }
}
else {
    echo json_encode(array('state' => false, 'errors' => array('Invalid email address or password')));
}
