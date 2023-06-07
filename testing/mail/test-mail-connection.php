<?php

/*
 * This php file is used to test the connection of the SMTP mailer
 *
 * Make sure to put your email in: $your_email
 */

require_once '../../settings/config.php';
require_once '../../classes/mail/Mail.php';

$your_email = 'person@domain.com';

$Mail = new Mail();
$Mail->send_test_connection_mail($your_email);