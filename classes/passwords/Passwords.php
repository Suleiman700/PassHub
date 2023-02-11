<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/classes/helpers/Generators.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/helpers/Encryption.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/users/Users.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/settings/ERROR_CODES.php';

class Passwords
{
    private string $tableName = 'passwords'; // store MySql table name

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

        $query = "SELECT passwords.*, categories.name AS category_name, categories.color AS category_color
                    FROM passwords
                    LEFT JOIN categories ON passwords.category_id = categories.id
                    WHERE passwords.user_id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $results = $stmt->fetch_all(MYSQLI_ASSOC);

        // check if data found
        if ($stmt->num_rows) {
            $res['dataFound'] = true;
            $res['data'] = $results;
        }

        return $res;
    }


    /**
     * create new password
     * @param string|int $_userId
     * @param array $_newPasswordData
     * @return array
     */
    public function create_password(string|int $_userId, array $_newPasswordData): array
    {
        global $conn;
        global $ERROR_CODES;
        $Generators = new Generators();
        $Encryption = new Encryption();
        $Users = new Users();

        $res = array(
            'dataInserted' => false,
            'errors' => array()
        );

        // generate new row id
        $new_key = $Generators->gen_table_primary_key($this->tableName);

        // sanitize data
        $categoryId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_newPasswordData['categoryId'])));
        $username = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_newPasswordData['username'])));
        $password = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_newPasswordData['password'])));
        $website = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_newPasswordData['website'])));
        $description = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_newPasswordData['description'])));
        $note = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_newPasswordData['note'])));

        // get users keys to encrypt password
        $userKeys = $Encryption->get_user_secrets($_userId);

        // user keys found
        if ($userKeys['dataFound']) {
            // encrypt password
            $encryptedPassword = $Encryption->encrypt_string($password, $userKeys['data']['secret_key'], $userKeys['data']['secret_iv']);

            // insert record
            $query = "INSERT INTO `$this->tableName` (id, user_id, category_id, username, password, website, description, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "iiisssss", $new_key, $_userId, $categoryId, $username, $encryptedPassword, $website, $description, $note);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $res['dataInserted'] = true;
            } else {
                // echo "Insert query failed: " . mysqli_stmt_error($stmt);

                $res['errors'][] = array(
                    'error' => $ERROR_CODES['PASSWORDS']['INSERT']['QUERY_FAILED']['NAME'],
                    'errorCode' => $ERROR_CODES['PASSWORDS']['INSERT']['QUERY_FAILED']['CODE'],
                );
            }
            mysqli_stmt_close($stmt);
        }
        else {
            $res['errors'][] = array(
                'error' => $ERROR_CODES['ENCRYPTION']['USER_SECRETS']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['ENCRYPTION']['USER_SECRETS']['NOT_FOUND']['CODE'],
            );
        }

        return $res;
    }
}