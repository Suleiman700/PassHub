<?php

if (isset($_GET['model']) && $_GET['model'] === 'fetchPasswords') {
    require_once '../../../classes/authentication/Session.php';
    require_once '../../../classes/categories/Categories.php';
    require_once '../../../classes/passwords/Passwords.php';
    require_once '../../../classes/helpers/Encryption.php';
    require_once '../../../settings/ERROR_CODES.php';
    $Session = new Session();
    $Categories = new Categories();
    $Passwords = new Passwords();
    $Encryption = new Encryption();

    $res = array(
        'dataFound' => false,
        'data' => array(),
        'errors' => array()
    );

    // get user id from session
    $session_userId = $Session->getSessionUserId();

    // check if user is logged
    if ($Session->isLogged()) {
        // get user passwords
        $userData = $Passwords->get_user_passwords($session_userId);

        if ($userData['dataFound']) {
            // get user keys
            $userKeys = $Encryption->get_user_secrets($session_userId);
            if ($userKeys['dataFound']) {
                $secretKey = $userKeys['data']['secret_key'];
                $secretIv = $userKeys['data']['secret_iv'];

                // decrypt passwords
                foreach ($userData['data'] as $index => $data) {
                    // decrypt password
                    $decryptedPassword = $Encryption->decrypt_string($data['password'], $secretKey, $secretIv);

                    // store decrypted password instead of encrypted password
                    $userData['data'][$index]['password'] = $decryptedPassword;
                }

                $res['dataFound'] = true;
                $res['data'] = $userData['data'];
            }
            else {
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['DECRYPTION']['USER_SECRETS']['NOT_FOUND']['NAME'],
                    'errorCode' => $ERROR_CODES['DECRYPTION']['USER_SECRETS']['NOT_FOUND']['CODE'],
                );
            }
        }
        // no passwords found
        else {
            $res['errors'][] = array(
                'error' => $ERROR_CODES['PASSWORDS']['GET']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['PASSWORDS']['GET']['NOT_FOUND']['CODE'],
            );
        }


        echo json_encode($res);
    }
    else {
        echo json_encode(array('error' => 'Unauthorized access'));
        return;
    }

}