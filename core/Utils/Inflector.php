<?php

namespace Chronos\Utils;

class Inflector
{
    public static function underscore($string)
    {
        return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $string));
    }

    public static function humanize($string)
    {
        return ucwords(str_replace('_', ' ', $string));
    }

    public static function camelize($string)
    {
        return str_replace(' ', '', self::humanize($string));
    }

    public static function _underscore($string)
    {
        return self::underscore(self::camelize($string));
    }

    public static function _humanize($string)
    {
        return self::humanize(self::underscore($string));
    }

    public static function _camelize($string)
    {
        return self::camelize(self::underscore($string));
    }

    public static function lCamelize($string)
    {
        return lcfirst(self::camelize($string));
    }
}
