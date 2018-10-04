<?php
namespace Utils;

session_start();
class TokenManager
{
    public static function create()
    {
       
        if (version_compare(phpversion(), '7.0.0', '<')) {
            $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
            if (function_exists('mcrypt_create_iv')) {
                $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
            } else {
                $token = bin2hex(openssl_random_pseudo_bytes(32));
            }
        } else {
            $token = bin2hex(random_bytes(32));
        }
        $_SESSION['token'] = $token;
        return $token;
    }

    public static function check()
    {
        if (!empty($_POST['token'])) {
            if (hash_equals($_SESSION['token'], $_POST['token'])) {
                return true;
            } else {
                echo "Le token a échoué";
            }
        }

    }
}
