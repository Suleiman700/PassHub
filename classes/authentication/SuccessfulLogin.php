<?php

require_once '../../../settings/db.php';
require_once '../../../classes/helpers/Generators.php';

class SuccessfulLogin
{
    private string|int $userId;
    private string $ipAddress;
    private string $userAgent;

    function __construct() {}

    /**
     * save login history
     * @return void
     */
    public function save(): void
    {
        // Store the login data in the database
        // using the user_id, ip_address, user_agent, and other_data properties
        global $conn;
        $Generators = new Generators();
        $rowId = $Generators->gen_table_primary_key('successful_logins');

        // sanitize the email address
        $this->userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->userId)));
        $this->ipAddress = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->ipAddress)));
        $this->userAgent = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->userAgent)));

        $query = "INSERT INTO successful_logins (id, user_id, ip_address, user_agent) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "iiss", $rowId, $this->userId, $this->ipAddress, $this->userAgent);
        mysqli_stmt_execute($stmt);
    }

    /**
     * get history by user id
     * @return array
     */
    public function get_history_of_user_id(): array
    {
        global $conn;

        $res = array(
            'dataFound' => false,
            'data' => array()
        );

        // sanitize data
        $this->userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->userId)));

        $query = "SELECT * FROM successful_logins WHERE user_id = '$this->userId' ORDER BY id DESC";
        $stmt = mysqli_query($conn, $query);
        $result = $stmt->fetch_all(MYSQLI_ASSOC);
        if ($result) {
            $res['dataFound'] = true;
            $res['data'] = $result;
        }
        else {
            $res['dataFound'] = false;
        }

        return $res;
    }

    /**
     * get history by id
     * @return void
     */
    public function get_history_by_id(string|int $_id): array
    {
        global $conn;

        $res = array(
            'dataFound' => false,
            'data' => array()
        );

        // sanitize data
        $_id = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_id)));

        $query = "SELECT * FROM successful_logins WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $result = $result->fetch_array(MYSQLI_ASSOC);
        if ($result) {
            $res['dataFound'] = true;
            $res['data'] = $result;
        }
        else {
            $res['dataFound'] = false;
        }
        mysqli_stmt_close($stmt);

        return $res;
    }

    /**
     * delete history
     * @param string|int $_id
     * @return array
     */
    public function delete_history_by_id(string|int $_id): array
    {
        global $conn;
        $res = array(
            'dataDeleted' => false,
            'errors' => array()
        );

        $_id = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_id)));

        $query = "DELETE FROM successful_logins WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $_id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $res['dataDeleted'] = true;
        } else {
            // echo "Insert query failed: " . mysqli_stmt_error($stmt);

            $res['errors'][] = array(
                'error' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['QUERY_FAILED']['NAME'],
                'errorCode' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['QUERY_FAILED']['CODE'],
            );
        }
        mysqli_stmt_close($stmt);

        return $res;
    }

    /**
     * delete all user history
     * @param string|int $_id
     * @return array
     */
    public function delete_all_user_history(): array
    {
        global $conn;
        $res = array(
            'dataDeleted' => false,
            'errors' => array()
        );

        $this->userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->userId)));

        $query = "DELETE FROM successful_logins WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $this->userId);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $res['dataDeleted'] = true;
        } else {
//             echo "Insert query failed: " . mysqli_stmt_error($stmt);

            $res['errors'][] = array(
                'error' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['QUERY_FAILED']['NAME'],
                'errorCode' => $ERROR_CODES['SUCCESSFUL_LOGINS']['DELETE']['QUERY_FAILED']['CODE'],
            );
        }
        mysqli_stmt_close($stmt);

        return $res;
    }

    public function setUserId(string|int $_userId): void
    {
        $this->userId = $_userId;
    }

    public function setIpAddress($_ipAddress): void
    {
        $this->ipAddress = $_ipAddress;
    }

    public function setUserAgent($_userAgent): void
    {
        $this->userAgent = $_userAgent;
    }
}