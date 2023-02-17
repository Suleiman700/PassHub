<?php

require_once '../../../settings/db.php';

class SuccessfulLogin
{
    private string|int $userId;
    private string $ipAddress;
    private string $userAgent;

    function __construct() {}

    public function save(): void
    {
        // Store the login data in the database
        // using the user_id, ip_address, user_agent, and other_data properties
        global $conn;

        // sanitize the email address
        $userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $this->userId)));

        $query = "SELECT * FROM users WHERE id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $result = $stmt->fetch_assoc();

        if ($result) {
            $res['state'] = true;
            $res['data'] = $result;
        }

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