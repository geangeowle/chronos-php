<?php

namespace Chronos\Utils;

class Configure
{
    private static $instance = null;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public static function write($config, $value = null)
    {
        $_this = static::getInstance();

        if (!is_array($config)) {
            $config = [
                $config => $value,
            ];
        }

        foreach ($config as $names => $value) {
            $name = explode('.', $names);
            $size = count($name);
            if (3 === $size) {
                $_this->{$name[0]}[$name[1]][$name[2]] = $value;
            } elseif (2 === $size) {
                $_this->{$name[0]}[$name[1]] = $value;
            } elseif (1 === $size) {
                $_this->{$name[0]} = $value;
            }
        }

        return true;
    }

    public static function read($var = null)
    {
        if (null === $var) {
            return null;
        }

        $_this = static::getInstance();

        $name = explode('.', $var);
        switch (count($name)) {
            case 3:
                if (isset($_this->{$name[0]}[$name[1]][$name[2]])) {
                    return $_this->{$name[0]}[$name[1]][$name[2]];
                }

                break;
            case 2:
                if (isset($_this->{$name[0]}[$name[1]])) {
                    return $_this->{$name[0]}[$name[1]];
                }

                break;
            case 1:
                if (isset($_this->{$name[0]})) {
                    return $_this->{$name[0]};
                }

                break;
        }
    }
}
