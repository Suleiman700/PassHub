<?php

session_start();

class Session
{
    private string $session_isLogged = 'PASSHUB_ISLOGGED';
    private string $session_userId = 'PASSHUB_USERID';
    private string $session_userEmail = 'PASSHUB_USEREMAIL';

    function __contructor(): void
    {}

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
     * receive user data and set logged in session
     * @param int $_userId example: 1
     * @param string $_userEmail example: person@domain.com
     * @return void
     */
    public function set_logged_session(int $_userId, string $_userEmail): void
    {
        $_SESSION[$this->session_isLogged] = true;
        $_SESSION[$this->session_userId] = $_userId;
        $_SESSION[$this->session_userEmail] = $_userEmail;
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
    }
}