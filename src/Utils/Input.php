<?php

namespace Chronos\Utils;

/**
 * Class used to get values from $_GET, $_POST global array...
 */
class Input
{
    /**
     * Get an expecific value of a determined key in a $_GET array
     * or return the entire $_GET array.
     *
     * @param string $key
     */
    public static function get(string $key = null)
    {
        return static::arrayGet($key, $_GET);
    }

    /**
     * Get an expecific value of a determined key in a $_POST array
     * or return the entire $_POST array.
     *
     * @param string $key
     */
    public static function post(string $key = null)
    {
        return static::arrayGet($key, $_POST);
    }

    /**
     * Helper method used to get information of an array and the ability to return a default value.
     *
     * @param null|mixed $default
     */
    private static function arrayGet(string $key, array $array, $default = null)
    {
        if (!isset($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        return $default;
    }
}
