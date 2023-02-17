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

        $query = "SELECT * FROM successful_logins WHERE user_id = ? ORDER BY id DESC";
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

    public function setIpAddress($_ipAddress): void
    {
        $this->ipAddress = $_ipAddress;
    }

    public function setUserAgent($_userAgent): void
    {
        $this->userAgent = $_userAgent;
    }
}