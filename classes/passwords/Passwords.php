<?php

class Passwords
{
    function __construct() {}

    /**
     * get user data by email address
     * @param string $_emailAddress
     * @return array
     */
    public function get_user_passwords(string|int $_userId): array
    {
        global $conn;

        $res = array(
            'dataFound' => false,
            'data' => array()
        );

        $query = "SELECT * FROM passwords WHERE user_id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $results = $stmt->fetch_all(MYSQLI_ASSOC);

        // check if data found
        if ($stmt->num_rows) {
            $res['dataFound'] = true;
            $res['data'] = $results;
        }

        return $res;
    }
}