<?php

namespace Chronos\Utils;

/**
 * This class abstracts how we deal with the global variable $ _COOKIE.
 */
class Cookie
{
    /**
     * Set new value to cookie.
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $expires
     *
     * @return mixed
     */
    public static function set($key, $value, $expires = 0)
    {
        // By default it will expires at midnight of the current day
        $expires = $expires > 0 ? $expires : strtotime(date('Y-m-d 23:59:59'));

        setcookie($key, $value, $expires, '', '', false, true);
    }

    /**
     * Get value from cookie by the given key.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default;
    }

    /**
     * Determine if the cookie has the given key.
     *
     * @param string $key
     *
     * @return bool
     */
    public static function has($key)
    {
        return array_key_exists($key, $_COOKIE);
    }

    /**
     * Remove the given key from the cookie.
     *
     * @param string $key
     */
    public static function remove($key)
    {
        setcookie($key, null, -1);
        unset($_COOKIE[$key]);
    }

    /**
     * Get all cookies data.
     *
     * @return array
     */
    public static function all()
    {
        return $_COOKIE;
    }

    /**
     * Remove all cookies.
     */
    public static function destroy()
    {
        foreach (array_keys(static::all()) as $key) {
            static::remove($key);
        }

        unset($_COOKIE);
    }
}
