<?php

require_once '../../../settings/db.php';
require_once '../../../classes/users/Users.php';

class Login
{

    private string $username = '';
    private string $emailAddress = '';
    private string $password = '';
    private int $pinCode;

    function __constructor() {}

    /**
     * receive hashed password and verify it with request password
     * @param string $_hashedPassword
     * @return bool
     */
    public function verify_password_hash(string $_hashedPassword): bool {
        if (password_verify($this->getPassword(), $_hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * set username
     * @param string $_username
     */
    public function setUsername(string $_username): void
    {
        $this->username = $_username;
    }

    /**
     * get username
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }



    /**
     * set email address
     * @param string $emailAddress
     */
    public function setEmailAddress(string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * get email address
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /**
     * set password
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * get password
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * set pin code
     * @param int $pinCode
     */
    public function setPinCode(int $pinCode): void
    {
        $this->pinCode = $pinCode;
    }

    /**
     * @return int
     */
    public function getPinCode(): int
    {
        return $this->pinCode;
    }

}