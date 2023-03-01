<?php

require_once '../../../classes/authentication/Session.php';
require_once '../../../classes/users/Users.php';
require_once '../../../classes/users/UsersSettings.php';
require_once '../../../settings/ERROR_CODES.php';
require_once '../../../functions/validators/validate-pin-code.php';
$Session = new Session();
$Users = new Users();
$UsersSettings = new UsersSettings();

// check if logged
$session_isLogged = $Session->isLogged();

if (isset($_POST['model']) && $_POST['model'] === 'performSecuritySettingsSave' && $session_isLogged) {
    // this will reject request and return error message to user then do exit;
    require_once '../../../functions/requests/reject-request-in-lock-mode.php';

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    $res = array(
        'dataUpdated' => false,
        'errors' => array()
    );

    $newUserSettings = array(
        'enable2FA' => $_POST['enable2FA'],
        'enableLoginAlerts' => $_POST['enableLoginAlerts'],
        'enablePasswordChangeAlerts' => $_POST['enablePasswordChangeAlerts'],
        'enablePinCodeChangeAlerts' => $_POST['enablePinCodeChangeAlerts'],
    );

    // update user settings
    $result = $UsersSettings->update_user_settings($newUserSettings, $session_userId);

    $res['dataUpdated'] = $result['dataUpdated'];
    $res['errors'] = $result['errors'];

    echo json_encode($res);
}
