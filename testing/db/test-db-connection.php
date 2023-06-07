<?php

/*
 * This php file is used to test the connection to the database
 *
 * If database connected successfully you'll see "Database connection successfully" message on screen
 */

require_once '../../settings/db.php';

if ($conn) {
    echo 'Database connection successfully';
}
else if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}