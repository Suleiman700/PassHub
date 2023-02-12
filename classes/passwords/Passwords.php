<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/classes/helpers/Generators.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/helpers/Encryption.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/users/Users.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/settings/ERROR_CODES.php';

class Passwords
{
    private string $tableName = 'passwords'; // store MySql table name

    function __construct() {}

    public function get_password_info(string|int $_passwordId, string|int $_userId): array
    {
        global $conn;
        global $ERROR_CODES;
        $Encryption = new Encryption();

        $res = array(
            'dataFound' => false,
            'data' => array()
        );

        $_passwordId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_passwordId)));

        $query = "SELECT * FROM $this->tableName WHERE id = '$_passwordId' and user_id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $results = $stmt->fetch_assoc();

        // check if data found
        if ($stmt->num_rows) {
            $res['dataFound'] = true;
            $res['data'] = $results;

            // get user keys to decrypt password
            $userKeys = $Encryption->get_user_secrets($_userId);
            if ($userKeys['dataFound']) {
                $secretKey = $userKeys['data']['secret_key'];
                $secretIv = $userKeys['data']['secret_iv'];

                // decrypt passwords
                $decryptedPassword = $Encryption->decrypt_string($res['data']['password'], $secretKey, $secretIv);

                $res['dataFound'] = true;
                $res['data']['password'] = $decryptedPassword;
            }
            else {
                $res['dataFound'] = false;
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['DECRYPTION']['USER_SECRETS']['NOT_FOUND']['NAME'],
                    'errorCode' => $ERROR_CODES['DECRYPTION']['USER_SECRETS']['NOT_FOUND']['CODE'],
                );
            }
        }

        return $res;
    }

    /**
     * count user passwords
     * @param string|int $_userId
     * @return int
     */
    public function count_user_passwords(string|int $_userId): int
    {
        global $conn;

        $_userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_userId)));

        $query = "SELECT COUNT(*) AS count FROM $this->tableName WHERE user_id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $results = $stmt->fetch_assoc();

        return $results['count'];
    }

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

    public function update_password(string|int $_passwordId, string|int $_userId, array $_newPasswordData): array
    {
        global $conn;
        global $ERROR_CODES;
        $Generators = new Generators();
        $Encryption = new Encryption();
        $Users = new Users();

        $res = array(
            'dataUpdated' => false,
            'errors' => array()
        );

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

            try {
                // update row
                $query = "UPDATE $this->tableName SET category_id=?, username=?, password=?, website=?, description=?, note=? WHERE id=? AND user_id=?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "isssssii", $categoryId, $username, $encryptedPassword, $website, $description, $note, $_passwordId, $_userId);
                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_errno($stmt) == 0) {
                    $res['dataUpdated'] = true;
                    // if (mysqli_stmt_affected_rows($stmt) > 0) {
                    //     $res['dataUpdated'] = true;
                    // } else {
                    //     $res['dataUpdated'] = false;
                    // }
                } else {
                    $res['errors'][] = array(
                        'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['QUERY_FAILED']['NAME'],
                        'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['QUERY_FAILED']['CODE'],
                    );
                }
                mysqli_stmt_close($stmt);
            }
            catch (Exception $e) {
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['PASSWORDS']['UPDATE']['QUERY_FAILED_TRY_CATCH']['NAME'],
                    'errorCode' => $ERROR_CODES['PASSWORDS']['UPDATE']['QUERY_FAILED_TRY_CATCH']['CODE'],
                );
            }
        }
        else {
            $res['errors'][] = array(
                'error' => $ERROR_CODES['ENCRYPTION']['USER_SECRETS']['NOT_FOUND']['NAME'],
                'errorCode' => $ERROR_CODES['ENCRYPTION']['USER_SECRETS']['NOT_FOUND']['CODE'],
            );
        }

        return $res;
    }

    public function delete_password(string|int $_passwordId): array
    {
        global $conn;
        global $ERROR_CODES;

        $res = array(
            'dataDeleted' => false,
            'errors' => array()
        );


        try {
            $_passwordId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_passwordId)));

            // update row
            $query = "DELETE FROM $this->tableName WHERE id=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $_passwordId);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_errno($stmt) == 0) {
                 if (mysqli_stmt_affected_rows($stmt) > 0) {
                     $res['dataDeleted'] = true;
                 } else {
                     $res['errors'][] = array(
                         'error' => $ERROR_CODES['PASSWORDS']['DELETE']['QUERY']['QUERY_FAILED']['NAME'],
                         'errorCode' => $ERROR_CODES['PASSWORDS']['DELETE']['QUERY']['QUERY_FAILED']['CODE'],
                     );
                 }
            } else {
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['PASSWORDS']['DELETE']['QUERY']['NO_AFFECTED_ROWS']['NAME'],
                    'errorCode' => $ERROR_CODES['PASSWORDS']['DELETE']['QUERY']['NO_AFFECTED_ROWS']['CODE'],
                );
            }
            mysqli_stmt_close($stmt);
        }
        catch (Exception $e) {
            $res['errors'][] = array(
                'error' => $ERROR_CODES['PASSWORDS']['DELETE']['QUERY']['ERROR_PERFORMING_QUERY']['NAME'],
                'errorCode' => $ERROR_CODES['PASSWORDS']['DELETE']['QUERY']['ERROR_PERFORMING_QUERY']['CODE'],
            );
        }

        return $res;
    }
}