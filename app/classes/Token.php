<?php

class Token
{
    public static function generate()
    {
        $token = md5(microtime());
        Session::put(Config::get('session.tokenName'), $token);
        return $token;
    }

    public static function check($token)
    {
        $tokenName = Config::get('session.tokenName');
        if (Session::exists($tokenName) && $token == Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}
