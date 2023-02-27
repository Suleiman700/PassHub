<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/settings/db.php';

class UsersSettings
{
    /**
     * get user data by id
     * @param string|int $_userId
     * @return array
     */
    public function get_user_settings(string|int $_userId): array
    {
        global $conn;

        $res = array(
            'dataFound' => false,
            'data' => array()
        );

        // sanitize the email address
        $_userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_userId)));

        $query = "SELECT * FROM users_settings WHERE user_id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $result = $stmt->fetch_assoc();

        if ($result) {
            $res['dataFound'] = true;
            $res['data'] = $result;
        }

        return $res;
    }

    public function is_login_alerts_enabled(string|int $_userId): bool
    {
        global $conn;

        // sanitize the email address
        $_userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_userId)));

        $query = "SELECT enable_login_alerts FROM users_settings WHERE user_id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $result = $stmt->fetch_assoc();

        return $result['enable_login_alerts'];
    }

    public function is_password_change_alert_enabled(string|int $_userId): bool
    {
        global $conn;

        // sanitize the email address
        $_userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_userId)));

        $query = "SELECT enable_password_change_alert FROM users_settings WHERE user_id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $result = $stmt->fetch_assoc();

        return $result['enable_password_change_alert'];
    }

    public function is_2fa_enabled(string|int $_userId): bool
    {
        global $conn;

        // sanitize the email address
        $_userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_userId)));

        $query = "SELECT enable_2fa FROM users_settings WHERE user_id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $result = $stmt->fetch_assoc();

        return $result['enable_2fa'];
    }

    public function save_twofactor_code(string|int $_userId, int $_twoFactorCode): void
    {
        global $conn;

        $_userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_userId)));
        $_twoFactorCode = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_twoFactorCode)));

        $query = "UPDATE users_settings SET twofactor_code = '$_twoFactorCode' WHERE user_id = '$_userId'";
        $result = mysqli_query($conn, $query);
    }
}