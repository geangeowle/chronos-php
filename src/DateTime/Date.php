<?php

namespace Chronos\DateTime;

/**
 * Convert Date between formats.
 */
class Date
{
    /**
     * Patterns used to convert Brazilian Dates to US Dates.
     *
     * @var array
     */
    private static $fromBRToUS = [
        // DD/MM/YYYY --> YYYY-MM-DD
        [
            'pattern' => '([\d]{2})\/([\d]{2})\/([\d]{4})',
            'replace' => '$3-$2-$1',
        ],
    ];

    /**
     * Convert a date informed in Brazilian format to US format.
     *
     * @param string $datetime
     * @param bool   $withtime
     */
    public static function fromBRToUS($datetime, $withtime = false)
    {
        if (static::checkExists($datetime)) {
            $dateInformed = static::normalizeDate($datetime);
            list($date, $time) = static::splitDateTime($dateInformed);
            $time = static::timeExists($time);
            $date = static::convertDateWithRegex($date, static::$fromBRToUS);

            if ($withtime) {
                return static::removeWhiteSpace("{$date} {$time}");
            }

            return static::removeWhiteSpace($date);
        }
    }

    /**
     * Trim an informed value removing white spaces.
     *
     * @param string $value
     *
     * @return string
     */
    private static function removeWhiteSpace($value)
    {
        return trim($value);
    }

    /**
     * Check if a value was informed.
     *
     * @param string $value
     */
    private static function checkExists($value)
    {
        return strlen(static::removeWhiteSpace($value)) > 0;
    }

    /**
     * Normalize the date informed.
     *
     * @param string $date
     *
     * @return string
     */
    private static function normalizeDate($date)
    {
        return str_replace(['-', '.'], '/', $date);
    }

    /**
     * Separte date part from time part.
     *
     * @param string $datetime
     *
     * @return array
     */
    private static function splitDateTime($datetime)
    {
        $parts = explode(' ', $datetime);
        $datePart = !empty($parts[0]) ? $parts[0] : '';
        $timePart = !empty($parts[1]) ? $parts[1] : '';

        return [$datePart, $timePart];
    }

    /**
     * Normalize the regex pattern informed.
     *
     * @param string $pattern
     *
     * @return string
     */
    private static function normalizePattern($pattern)
    {
        return '/^'.$pattern.'$/';
    }

    /**
     * Convert date if it matches with regex.
     *
     * @param string $date
     * @param array  $convertions
     *
     * @return string
     */
    private static function convertDateWithRegex($date, $convertions = [])
    {
        if (static::checkExists($date)) {
            foreach ($convertions as $convert) {
                $pattern = static::normalizePattern($convert['pattern']);
                $subject = static::removeWhiteSpace($date);
                $replace = $convert['replace'];

                if (preg_match($pattern, $subject)) {
                    return preg_replace($pattern, $replace, $subject);
                }
            }
        }
    }

    /**
     * Check if time exists.
     *
     * @param string $time
     *
     * @return string
     */
    private static function timeExists($time)
    {
        if (static::checkExists($time)) {
            return static::removeWhiteSpace($time);
        }

        return '00:00:00';
    }
}
