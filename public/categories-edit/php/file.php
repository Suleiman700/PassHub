<?php

if (isset($_POST['model']) && $_POST['model'] === 'saveEditedCategory') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/categories/Categories.php';
    $Session = new Session();
    $Categories = new Categories();

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