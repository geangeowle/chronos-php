<?php

namespace Chronos\Utils;

class Inflector
{
    public static function underscore($string)
    {
        return self::delimit(str_replace('-', '_', $string), '_');
    }

    public static function humanize($string, $delimiter = '_')
    {
        return ucwords(str_replace($delimiter, ' ', str_replace('-', '_', $string)));
    }

    public static function camelize($string, $delimiter = '_')
    {
        $result = str_replace(' ', '', self::humanize($string));

        return $result;
    }

    public static function delimit($string, $delimiter = '_')
    {
        $result = strtolower(preg_replace('/(?<=\\w)([A-Z])/', $delimiter.'\\1', $string));

        return $result;
    }
}
