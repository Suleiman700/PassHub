<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/classes//helpers/Encryption.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/helpers/Generators.php';

class Users
{
    function __construct() {}

    /**
     * get user data by id
     * @param string|int $_userId
     * @return array
     */
    public function get_data_by_id(string|int $_userId): array
    {
        global $conn;

        $res = array(
            'state' => false,
            'data' => array()
        );

        // sanitize the email address
        $_userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_userId)));

        $query = "SELECT * FROM users WHERE id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $result = $stmt->fetch_assoc();

        if ($result) {
            $res['state'] = true;
            $res['data'] = $result;
        }

        return $res;
    }

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

    public function create_new_user(array $_newUserData): array
    {
        global $conn;
        $Encryption = new Encryption();
        $Generators = new Generators();

        $res = array(
            'dataInserted' => false,
            'errors' => array()
        );

        // generate new row id
        $userId = $this->gen_new_primary_key();

        $fullname = $_newUserData['fullname'];
        $email = $_newUserData['email'];
        $hashedPassword = $_newUserData['hashedPassword'];
        $pinCode = $_newUserData['pinCode'];

        $query = "INSERT INTO users (id, fullname, email, password, pin_code) VALUES ($userId, '$fullname', '$email', '$hashedPassword', '$pinCode')";
        $result = mysqli_query($conn, $query);

        if (isset($result) && $result === true) {
            // generate new row id
            $new_key = $Generators->gen_table_primary_key('users_keys');

            // generate random key and iv
            $encryptionKeys = $Encryption->gen_random_encryption_keys();
            $key = $encryptionKeys['key'];
            $iv = $encryptionKeys['iv'];

            // insert key and iv into users_keys table
            $query = "INSERT INTO users_keys (id, user_id, secret_key, secret_iv) VALUES ($new_key, $userId, '$key', '$iv')";
            $result = mysqli_query($conn, $query);

            if (isset($result) && $result === true) {
                $res['dataInserted'] = true;
            }
            else {
                $res['dataInserted'] = false;
                $res['errors'][] = 'An error occurred while saving encryption keys';
            }
        }
        else {
            $res['dataInserted'] = false;
            $res['errors'][] = 'An error occurred';
        }

        return $res;
    }

    /**
     * generate new primary key for inserting new record into table
     * @return int
     */
    private function gen_new_primary_key(): int
    {
        global $conn;

        $query = "SELECT MAX(id) + 1 AS new_primary_key FROM users";
        $stmt = mysqli_query($conn, $query);
        $results = $stmt->fetch_assoc();

        // if found new primary key
        if ($stmt->num_rows && !empty($results['new_primary_key'])) {
            return $results['new_primary_key'];
        }
        else {
            return 0;
        }
    }
}