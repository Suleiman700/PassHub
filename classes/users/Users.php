<?php

class Users
{
    function __construct() {}

    /**
     * get user data by email address
     * @param string $_emailAddress
     * @return array
     */
    public function get_data_by_email(string $_emailAddress): array
    {
        global $conn;

        $res = array(
            'state' => false,
            'data' => array()
        );

        // sanitize the email address
        $_emailAddress = mysqli_real_escape_string($conn, $_emailAddress);

        $query = "SELECT * FROM users WHERE email = '$_emailAddress'";
        $stmt = mysqli_query($conn, $query);
        $result = $stmt->fetch_assoc();

        if ($result) {
            $res['state'] = true;
            $res['data'] = $result;
        }

        return $res;
    }
}