<?php

namespace Chronos\Utils;

/**
 * Class used to get and set values from and to the globals available.
 */
class Input
{
    /**
     * Array containig values passed by the method "static::set".
     *
     * @var array
     */
    private static $array = [];

    /**
     * An array containing values of indices that should be ignored from returning.
     *
     * @var array
     */
    private static $but = [];

    /**
     * Pass value to "static::$array", the first parameter "$key" accepts an array key
     * or an "Array" and the "$value" accepts a mixed or a \Closure, if the
     * second option is used you have to return a "String" or an "Array"
     * containing the fields you want to remove.
     *
     * @param mixed               $key
     * @param null|\Closure|mixed $value
     * @param \Closure            $change
     */
    public static function set($key, $value, \Closure $change = null)
    {
        if (is_array($key) && !isset($value)) {
            static::$array = array_merge(static::$array, $key);
        } elseif (is_array($key) && $value instanceof \Closure) {
            static::$array = array_merge(static::$array, $key);
            static::but($value());
        } else {
            static::$array[$key] = $value;
        }

        if (isset($change) && $change instanceof \Closure) {
            $override = $change(static::$array);
            static::$array = !empty($override) ? $override : static::$array;
        }
    }

    /**
     * Define keys you don't want to passe to "static::$array", it accepts the
     * "$key" argument as a string or an array of strings representing the
     * indices you don't want to mass assign to the "static::$array".
     *
     * @param mixed $key
     */
    public static function but($key)
    {
        if (is_array($key)) {
            static::$but = array_merge(static::$but, $key);
        } else {
            static::$but[] = $key;
        }
    }

    /**
     * Get an expecific value of a determined key in the "static::$array" array
     * or return the entire "static::$array" array.
     *
     * @param null|\Closure|string $key
     * @param \Closure             $change
     */
    public static function field($key = null, \Closure $change = null)
    {
        return static::pull($key, static::$array, $change);
    }

    /**
     * Get an expecific value of a determined key in the $_GET array
     * or return the entire $_GET array.
     *
     * @param null|\Closure|string $key
     * @param \Closure             $change
     */
    public static function get($key = null, \Closure $change = null)
    {
        return static::pull($key, $_GET, $change);
    }

    /**
     * Get an expecific value of a determined key in the $_POST array
     * or return the entire $_POST array.
     *
     * @param null|\Closure|string $key
     * @param \Closure             $change
     */
    public static function post($key = null, \Closure $change = null)
    {
        return static::pull($key, $_POST, $change);
    }

    /**
     * Get an expecific value of a determined key in the $_SERVER array
     * or return the entire $_SERVER array.
     *
     * @param null|\Closure|string $key
     * @param \Closure             $change
     */
    public static function server($key = null, \Closure $change = null)
    {
        return static::pull($key, $_SERVER, $change);
    }

    /**
     * Helper method for pulling things out of an array, it abstracts the logic
     * for changing the array contents, it avoids code repetition.
     *
     * @param mixed    $key
     * @param mixed    $array
     * @param \Closure $change
     */
    private static function pull($key, $array, \Closure $change = null)
    {
        if ($key instanceof \Closure) {
            return static::arrayPull('', static::change($array, $key));
        }

        return static::arrayPull($key, static::change($array, $change));
    }

    /**
     * Helper method used to change values from a given "$array".
     *
     * @param mixed         $array
     * @param null|\Closure $change
     */
    private static function change($array, \Closure $change = null)
    {
        if (null !== $change && ($change instanceof \Closure)) {
            $array = $change($array);
        } elseif (null !== $change && !($change instanceof \Closure)) {
            throw new \InvalidArgumentException('Second argument should be an instance "\Closure"');
        }

        return $array;
    }

    /**
     * Helper method used to get information of an array and the
     * ability to return a default value.
     *
     * @param null|mixed $default
     * @param mixed      $key
     * @param mixed      $default
     */
    private static function arrayPull($key, array $array, $default = null)
    {
        // return the whole array
        if (!isset($key)) {
            return $array;
        }

        // return a value of a specific key
        if (isset($array[$key])) {
            return $array[$key];
        }

        // when getting the values ignore some predefined indices
        if (isset(static::$array[$key]) && !in_array($key, static::$but, true)) {
            return static::$array[$key];
        }

        // case the conditions were not satisfied
        // return a default value
        return $default;
    }
}
