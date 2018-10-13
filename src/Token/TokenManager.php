<?php

namespace App\Token;

session_start();

/**
 * Class TokenManager
 * @package Token
 * @author Sébastien Lorrain
 */
class TokenManager
{
    /**
     * @return string
     * @throws \Exception
     */
    public static function create()
    {
        if (version_compare(phpversion(), '7.0.0', '<')) {
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

    /**
     * @return bool
     * @throws \Exception
     */
    public static function check()
    {
        if (empty($_POST['token'])) {
            throw new \Exception("Le token est vide");
        }

        if (!hash_equals($_SESSION['token'], $_POST['token'])) {
            throw new \Exception("Le token a echoué");
        }

        return true;
    }
}
