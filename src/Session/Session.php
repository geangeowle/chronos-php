<?php

namespace Chronos\Session;

class Session
{
    public static function start()
    {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);

        session_name('chronosID');
        session_start();
    }

    public static function write($config, $value = null)
    {
        // $_this = static::getInstance();

        if (!is_array($config)) {
            $config = [
                $config => $value,
            ];
        }

        foreach ($config as $names => $value) {
            $name = explode('.', $names);
            $size = count($name);
            if (3 === $size) {
                $_SESSION[$name[0]][$name[1]][$name[2]] = $value;
            } elseif (2 === $size) {
                $_SESSION[$name[0]][$name[1]] = $value;
            } elseif (1 === $size) {
                $_SESSION[$name[0]] = $value;
            }
        }

        return true;
    }

    public static function read($var = null)
    {
        if (null === $var) {
            return null;
        }

        // $_this = static::getInstance();

        $name = explode('.', $var);
        switch (count($name)) {
          case 3:
            if (isset($_SESSION[$name[0]][$name[1]][$name[2]])) {
                return $_SESSION[$name[0]][$name[1]][$name[2]];
            }

            break;
          case 2:
            if (isset($_SESSION[$name[0]][$name[1]])) {
                return $_SESSION[$name[0]][$name[1]];
            }

            break;
          case 1:
            if (isset($_SESSION[$name[0]])) {
                return $_SESSION[$name[0]];
            }

            break;
        }
    }

    public static function check($name)
    {
        if (null !== self::read($name)) {
            return true;
        }

        return false;
    }
}
