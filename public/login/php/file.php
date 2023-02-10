<?php

if (isset($_POST['model']) && $_POST['model'] === 'performLogin') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/authentication/Login.php';
    require_once '../../../classes/users/Users.php';
    require_once '../../../functions/validators/validation-email.php';
    require_once '../../../functions/validators/validate-pin-code.php';

    $Login = new Login();
    $Users = new Users();
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

        // check if user found by email address
        $userData = $Users->get_data_by_email($Login->getEmailAddress());

        // user found
        if ($userData['state']) {
            // verify password hash
            $hashedPassword = $userData['data']['password'];
            if (!$Login->verify_password_hash($hashedPassword)) {
                $state = false;
                $errors[] = 'Invalid email address or password';
            }
            // verify pin code
            else if ($Login->getPinCode() != $userData['data']['pin_code']) {
                $state = false;
                $errors[] = 'Invalid pin code';
            }
            else {
                // set logged in session
                $Session->set_logged_session($userData['data']['id'], $userData['data']['email'], $userData['data']['fullname']);

                $state = true;
            }
        }
        // user not found
        else {
            $state = false;
            $errors[] = 'Invalid email address or password';
        }

        echo json_encode(array('state' => $state, 'errors' => $errors));
    }
    else {
        echo json_encode(array('state' => false, 'errors' => $errors));
    }
}
else {
    echo json_encode(array('state' => false, 'errors' => array('Invalid email address or password')));
}
