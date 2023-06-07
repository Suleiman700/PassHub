<?php

// this will reject request and return error message to user then do exit;
require_once '../../../functions/requests/reject-request-in-lock-mode.php';

require_once '../../../settings/config.php';
require_once '../../../classes/authentication/Session.php';
require_once '../../../classes/categories/Categories.php';
require_once '../../../settings/ERROR_CODES.php';
$Session = new Session();
$Categories = new Categories();

if (isset($_POST['model']) && $_POST['model'] === 'saveEditedCategory') {
    $session_userId = $Session->getSessionUserId();

    $validId = false;
    $validName = false;
    $validDescription = false;
    $validColor = false;

    $res = array(
        'dateUpdated' => true,
        'errors' => array()
    );

    // check category id
    if (isset($_POST['categoryId']) && is_numeric($_POST['categoryId'])) {
        $categoryId = $_POST['categoryId'];

        // check if category exist
        $categoryData = $Categories->get_category_info($categoryId);
        if ($categoryData['dataFound']) {
            // check if category belongs to user
            if ($categoryData['data']['user_id'] == $session_userId) {
                $validId = true;
            }
        }
    }

    // check category name
    if (isset($_POST['categoryName']) && !empty($_POST['categoryName'])) {
        $validName = true;
    }

    // check category color
    if (isset($_POST['categoryColor']) && !empty($_POST['categoryColor'])) {
        $validColor = true;
    }

    // check if all parameters are valid
    if ($validId && $validName && $validColor) {
        $data = array(
            'name' => trim($_POST['categoryName']),
            'description' => trim($_POST['categoryDescription']??''),
            'color' => trim($_POST['categoryColor']),
        );

        $result = $Categories->update_category(trim($_POST['categoryId']), $session_userId, $data);

        if ($result['dataUpdated']) {
            $res['dateUpdated'] = true;
        }
    }
    else {
        $res['dateUpdated'] = false;
        $res['errors'] = array('One or more fields are invalid');
    }


    echo json_encode($res);
}
else if (isset($_POST['model']) && $_POST['model'] === 'performCategoryDelete') {

    $session_userId = $Session->getSessionUserId();

    $validCategoryId = false;

    $res = array(
        'dataDeleted' => false,
        'errors' => array()
    );

    // check category id
    if (isset($_POST['categoryId']) && strlen($_POST['categoryId'])) {
        $categoryId = $_POST['categoryId'];

        // check if category exist
        $categoryData = $Categories->get_category_info($categoryId);
        if ($categoryData['dataFound']) {
            // check if category belongs to user
            if ($categoryData['data']['user_id'] == $session_userId) {
                $validCategoryId = true;
            }
            else {
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['CATEGORIES']['DELETE']['VALIDATION']['DOESNT_BELONG_TO_USER']['NAME'],
                    'errorCode' => $ERROR_CODES['CATEGORIES']['DELETE']['VALIDATION']['DOESNT_BELONG_TO_USER']['CODE'],
                );
            }
        }
        else {
            $res['errors'][] = array(
                'error' => $ERROR_CODES['CATEGORIES']['DELETE']['VALIDATION']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['CATEGORIES']['DELETE']['VALIDATION']['NOT_FOUND']['CODE'],
            );
        }
    }
    else {
        $res['errors'][] = array(
            'error' => $ERROR_CODES['CATEGORIES']['DELETE']['VALIDATION']['IDENTIFIER_NOT_FOUND']['NAME'],
            'errorCode' => $ERROR_CODES['CATEGORIES']['DELETE']['VALIDATION']['IDENTIFIER_NOT_FOUND']['CODE'],
        );
    }


    // check if all parameters are valid
    if ($validCategoryId) {
        // delete category
        $result = $Categories->delete_category(trim($_POST['categoryId']));

        if ($result['dataDeleted']) {
            $res['dataDeleted'] = true;
            $res['errors'] = $result['errors'];
        }
    }


    echo json_encode($res);
}