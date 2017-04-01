<?php

class Hash {

    public static function make($string, $salt = '') {
        return hash('sha256', $string . $salt);
    }

    public static function salt($length) {
        if (function_exists('random_bytes')) {
            return random_bytes($length);
        } elseif (function_exists('mcrypt_create_iv')) {
            return mcrypt_create_iv($length);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            return openssl_random_pseudo_bytes($length);
        }
    }

    public static function unique() {
        return self::make(uniqid());
    }

    public static function password($string, $salt = null) {
        if ($string != '' and $salt) {
            return password_hash($string, PASSWORD_DEFAULT, ['salt' => $salt]);
        } else if ($string != '') {
            return password_hash($string, PASSWORD_DEFAULT);
        }
    }

}