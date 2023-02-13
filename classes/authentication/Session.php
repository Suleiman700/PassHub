<?php

session_start();

class Session
{
    private string $session_isLogged = 'PASSHUB_ISLOGGED';

    private string $session_userId = 'PASSHUB_USERID';
    private string $session_userEmail = 'PASSHUB_USEREMAIL';
    private string $session_fullname = 'PASSHUB_USERNAME';
    private string $session_inLockMode = 'PASSHUB_INLOCKMODE';

    function __contructor(): void
    {}

    /**
     * @return string
     */
    public function getSessionUserId(): string
    {
        return $_SESSION[$this->session_userId];
    }

    /**
     * @param string $session_userId
     */
    public function setSessionUserId(string $session_userId): void
    {
        $_SESSION[$this->session_userId] = $session_userId;
    }

    /**
     * @return string
     */
    public function getSessionUserEmail(): string
    {
        return $_SESSION[$this->session_userEmail];
    }

    /**
     * @param string $session_userEmail
     */
    public function setSessionUserEmail(string $session_userEmail): void
    {
        $_SESSION[$this->session_userEmail] = $session_userEmail;
    }

    /**
     * @return string
     */
    public function getSessionUsername(): string
    {
        return $_SESSION[$this->session_fullname];
    }

    /**
     * @param string $session_fullname
     */
    public function setSessionUsername(string $session_fullname): void
    {
        $_SESSION[$this->session_fullname] = $session_fullname;
    }


    /**
     * check if user is logged in
     * @return bool
     */
    public function isLogged(): bool
    {
        if (isset($_SESSION[$this->session_isLogged]) && $_SESSION[$this->session_isLogged]) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * set user lock mode
     * @param bool $_option
     * @return bool
     */
    public function setLockMode(bool $_option): void
    {
        if ($_option) {
            $_SESSION[$this->session_inLockMode] = true;
        }
        else {
            $_SESSION[$this->session_inLockMode] = false;
        }
    }

    /**
     * check if user in lock mode
     * @return bool
     */
    public function inLockMode(): bool
    {
        return $_SESSION[$this->session_inLockMode];
        if (isset($_SESSION[$this->session_inLockMode]) && $_SESSION[$this->session_inLockMode]) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * receive user data and set logged in session
     * @param int $_userId example: 1
     * @param string $_userEmail example: person@domain.com
     * @param string $_fullname example: John Doe
     * @return void
     */
    public function set_logged_session(int $_userId, string $_userEmail, string $_fullname): void
    {
        $_SESSION[$this->session_isLogged] = true;
        $_SESSION[$this->session_userId] = $_userId;
        $_SESSION[$this->session_userEmail] = $_userEmail;
        $_SESSION[$this->session_fullname] = $_fullname;
        $_SESSION[$this->session_inLockMode] = false;
    }

    /**
     * destory logged in session
     * @return void
     */
    public function destory_logged_session(): void
    {
        unset($_SESSION[$this->session_isLogged]);
        unset($_SESSION[$this->session_userId]);
        unset($_SESSION[$this->session_userEmail]);
        unset($_SESSION[$this->session_fullname]);
        unset($_SESSION[$this->session_inLockMode]);
    }
}