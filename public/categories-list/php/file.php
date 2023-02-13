<?php

// this will reject request and return error message to user then do exit;
require_once '../../../functions/requests/reject-request-in-lock-mode.php';

if (isset($_GET['model']) && $_GET['model'] === 'fetchCategories') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/categories/Categories.php';
    $Session = new Session();
    $Categories = new Categories();

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    // get user categories by id
    $categories = $Categories->get_user_categories($session_userId);

    echo json_encode($categories);
}