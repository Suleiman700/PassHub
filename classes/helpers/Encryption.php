<?php

class Encryption
{
    function __construct() {}

    /**
     * generate random key and iv
     * @return array
     */
    public function gen_random_encryption_keys(): array
    {
        // Generate a new key and IV for the user
        $key = base64_encode(openssl_random_pseudo_bytes(32));
        $iv = base64_encode(openssl_random_pseudo_bytes(16));

        return array(
            'key' => $key,
            'iv' => $iv
        );
    }

    /**
     * encrypt string
     * @param string $_plaintext
     * @param string $_key
     * @param string $_iv
     * @return string
     */
    public function encrypt_string(string $_plaintext, string $_key, string $_iv): string
    {
        return openssl_encrypt($_plaintext, "AES-256-CBC", $_key, 0, $_iv);
    }

    /**
     * decrypt string
     * @param string $_ciphertext
     * @param string $_key
     * @param string $_iv
     * @return string
     */
    public function decrypt_string(string $_ciphertext, string $_key, string $_iv): string
    {
        return openssl_decrypt($_ciphertext, "AES-256-CBC", $_key, 0, $_iv);
    }
}