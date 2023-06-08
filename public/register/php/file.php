<?php

require_once '../../../settings/config.php';

if (isset($_POST['model']) && $_POST['model'] === 'performRegister') {
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

    // check username
    if (isset($_POST['fullname']) && !empty($_POST['fullname'])) {
        $Login->setUsername(trim($_POST['fullname']));
    }
    else {
        $errors[] = 'Invalid fullname';
    }

    // check email address
    if (isset($_POST['emailAddress']) && validate_email($_POST['emailAddress'])) {
        $Login->setEmailAddress(trim($_POST['emailAddress']));
    }
    else {
        $errors[] = 'Invalid email address';
    }

    // check password
    if (isset($_POST['password']) && !empty($_POST['password'])) {
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
        $errors[] = 'Pin code must be 4 digits long number';
    }

    // check if email address is taken
    $dataFoundByEmail = $Users->get_data_by_email($Login->getEmailAddress());

    // user found by this email address
    if ($dataFoundByEmail['state']) {
        $errors[] = 'This email address is already in use';
    }

    // perform register is no errors found
    if (empty($errors)) {
        $state = '';

        // hash user password
        $hashed_password = password_hash($Login->getPassword(), PASSWORD_DEFAULT);

        $newUserData = array(
            'fullname' => $Login->getUsername(),
            'email' => $Login->getEmailAddress(),
            'hashedPassword' => $hashed_password,
            'pinCode' => $Login->getPinCode()
        );

        $registerResult = $Users->create_new_user($newUserData);

        // user was created successfully
        if ($registerResult['dataInserted']) {
            $state = true;
        }
        else {
            $state = false;
            $errors[] = 'An error occurred while creating your account';
        }

        echo json_encode(array('state' => $state, 'errors' => $errors));
    }
    else {
        echo json_encode(array('state' => false, 'errors' => $errors));
    }
}
else {
    echo json_encode(array('state' => false, 'errors' => array('An error occurred')));
}
