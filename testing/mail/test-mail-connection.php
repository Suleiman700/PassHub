<?php

/*
 * This php file is used to test the connection of the SMTP mailer
 *
 * Make sure to put your email in: $your_email
 */
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once '../../settings/config.php';
require_once '../../classes/mail/Mail.php';

$your_email = 'person@domain.com';

$Mail = new Mail();
$Mail->send_test_connection_mail($your_email);