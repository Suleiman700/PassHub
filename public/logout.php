<?php

require_once '../classes/authentication/Session.php';
$Session = new Session();
$Session->destory_logged_session();
header('Location: ./login/index.php');