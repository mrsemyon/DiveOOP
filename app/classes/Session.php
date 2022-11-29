<?php

class Session
{
    public static function exists(string $name): bool
    {
        return isset($_SESSION[$name]);
    }

    public static function put(string $name, string $value): void
    {
        $_SESSION[$name] = $value;
    }

    public static function get(string $name): string
    {
        return $_SESSION[$name];
    }

    public static function delete(string $name): void
    {
        if (self::exists($name)) {

            unset($_SESSION[$name]);
        }
    }

    public static function flash($name, $message = '')
    {
        if (self::exists($name) && self::get($name) != '') {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $message);
        }
    }
}
