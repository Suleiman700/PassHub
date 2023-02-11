<?php

require_once '../../../classes/authentication/Session.php';
require_once '../../../classes/categories/Categories.php';
$Session = new Session();
$Categories = new Categories();

// check if logged
$session_isLogged = $Session->isLogged();

if (isset($_POST['model']) && $_POST['model'] === 'addNewPassword' && $session_isLogged) {
    // get user id from session
    $session_userId = $Session->getSessionUserId();

    $validId = false;
    $validName = false;
    $validDescription = false;
    $validColor = false;

    $res = array(
        'dataInserted' => true,
        'errors' => array()
    );

    // check category name
    if (isset($_POST['categoryName']) && !empty($_POST['categoryName'])) {
        $validName = true;
    }

    // check category color
    if (isset($_POST['categoryColor']) && !empty($_POST['categoryColor'])) {
        $validColor = true;
    }

    // check if all parameters are valid
    if ($validName && $validColor) {
        $data = array(
            'name' => trim($_POST['categoryName']),
            'description' => trim($_POST['categoryDescription']??''),
            'color' => trim($_POST['categoryColor']),
        );

        $result = $Categories->create_category($session_userId, $data);
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