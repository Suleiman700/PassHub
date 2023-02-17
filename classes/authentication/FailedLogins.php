<?php

require_once '../../../settings/db.php';
require_once '../../../classes/helpers/Generators.php';

class FailedLogins
{
    private string|int $userId;
    private string|int $pinCode;
    private string $password;
    private string $ipAddress;
    private string $userAgent;
    private string $failReason;

    function __construct() {}

    public function save(): void
    {
        // Store the login data in the database
        // using the user_id, ip_address, user_agent, and other_data properties
        global $conn;
        $Generators = new Generators();
        $rowId = $Generators->gen_table_primary_key('failed_logins');

        // sanitize the email address
        $this->userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->userId)));
        $this->pinCode = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->pinCode)));
        $this->password = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->password)));
        $this->ipAddress = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->ipAddress)));
        $this->userAgent = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->userAgent)));
        $this->failReason = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->failReason)));

        $query = "INSERT INTO failed_logins (id, user_id, used_pin_code, used_password, ip_address, user_agent, fail_reason) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "iisssss", $rowId, $this->userId, $this->pinCode, $this->password, $this->ipAddress, $this->userAgent, $this->failReason);
        mysqli_stmt_execute($stmt);
    }

    /**
     * get history by user id
     * @return void
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

        $query = "SELECT * FROM failed_logins WHERE user_id = ? ORDER BY id DESC";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $this->userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result !== false) {
            $res['dataFound'] = true;
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $res['data'] = $data;
            mysqli_stmt_free_result($stmt); // Free the result set
        }
        else {
            $res['dataFound'] = false;
        }
        mysqli_stmt_close($stmt);

        return $res;
    }

    public function setUserId(string|int $_userId): void
    {
        $this->userId = $_userId;
    }

    public function setUsedPinCode(string|int $_pinCode): void
    {
        $this->pinCode = $_pinCode;
    }

    public function setUsedPassword(string|int $_password): void
    {
        $this->password = $_password;
    }

    public function setIpAddress($_ipAddress): void
    {
        $this->ipAddress = $_ipAddress;
    }

    public function setUserAgent($_userAgent): void
    {
        $this->userAgent = $_userAgent;
    }

    public function setFailReason(string $_failReason): void
    {
        $this->failReason = $_failReason;
    }
}