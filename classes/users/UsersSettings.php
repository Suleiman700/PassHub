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

    /**
     * update user settings
     * @param array $_newSettingsData
     * @param string|int $_userId
     * @return array
     */
    public function update_user_settings(array $_newSettingsData, string|int $_userId): array
    {
        global $conn;
        global $ERROR_CODES;

        $res = array(
            'dataUpdated' => false,
            'errors' => array()
        );

        // sanitize data
        $enable2FA = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_newSettingsData['enable2FA'])));
        $enableLoginAlerts = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_newSettingsData['enableLoginAlerts'])));
        $enablePasswordChangeAlerts = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_newSettingsData['enablePasswordChangeAlerts'])));
        $enablePinCodeChangeAlerts = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_newSettingsData['enablePinCodeChangeAlerts'])));

        // convert boolean (true/false) to char (0/1)
        $enable2FA = filter_var($enable2FA, FILTER_VALIDATE_BOOLEAN) ?'1':'0';
        $enableLoginAlerts = filter_var($enableLoginAlerts, FILTER_VALIDATE_BOOLEAN) ?'1':'0';
        $enablePasswordChangeAlerts = filter_var($enablePasswordChangeAlerts, FILTER_VALIDATE_BOOLEAN) ?'1':'0';
        $enablePinCodeChangeAlerts = filter_var($enablePinCodeChangeAlerts, FILTER_VALIDATE_BOOLEAN) ?'1':'0';

        try {
            // update row
            $query = "UPDATE users_settings SET enable_2fa=?, enable_login_alerts=?, enable_password_change_alert=?, enabled_pin_code_change_alert=? WHERE user_id=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssssi", $enable2FA, $enableLoginAlerts, $enablePasswordChangeAlerts, $enablePinCodeChangeAlerts, $_userId);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_errno($stmt) == 0) {
                $res['dataUpdated'] = true;
            } else {
                $res['errors'][] = array(
                    'error' => $ERROR_CODES['USER_SETTINGS']['UPDATE']['QUERY_FAILED']['NAME'],
                    'errorCode' => $ERROR_CODES['USER_SETTINGS']['UPDATE']['QUERY_FAILED']['CODE'],
                );
            }
            mysqli_stmt_close($stmt);
        }
        catch (Exception $e) {
            $res['errors'][] = array(
                'error' => $ERROR_CODES['USER_SETTINGS']['UPDATE']['QUERY_FAILED_TRY_CATCH']['NAME'],
                'errorCode' => $ERROR_CODES['USER_SETTINGS']['UPDATE']['QUERY_FAILED_TRY_CATCH']['CODE'],
            );
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

    public function is_pin_code_change_alert_enabled(string|int $_userId): bool
    {
        global $conn;

        // sanitize the email address
        $_userId = strip_tags(htmlspecialchars(mysqli_real_escape_string($conn, $_userId)));

        $query = "SELECT enabled_pin_code_change_alert FROM users_settings WHERE user_id = '$_userId'";
        $stmt = mysqli_query($conn, $query);
        $result = $stmt->fetch_assoc();

        return $result['enabled_pin_code_change_alert'];
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