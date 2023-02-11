<?php

require_once '../../../classes/authentication/Session.php';
require_once '../../../classes/categories/Categories.php';
require_once '../../../classes/passwords/Passwords.php';
$Session = new Session();
$Categories = new Categories();
$Passwords = new Passwords();

// check if logged
$session_isLogged = $Session->isLogged();

if (isset($_POST['model']) && $_POST['model'] === 'addNewPassword' && $session_isLogged) {
    // get user id from session
    $session_userId = $Session->getSessionUserId();

    $validUsername = false;
    $validPassword = false;

    $res = array(
        'dataInserted' => true,
        'errors' => array()
    );

    // check username
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $validUsername = true;
    }

    // check password
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $validPassword = true;
    }

    // check if all parameters are valid
    if ($validUsername && $validPassword) {
        $data = array(
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
        $res['errors'] = array('One or more fields are invalid');
    }

    echo json_encode($res);
}