<?php

if (!function_exists('pr')) {
    /**
     * print_r convenience function.
     *
     * Will wrap <pre> tags around the output of given.
     *
     * @param mixed $var Variable to print out
     */
    function pr($var)
    {
        $template = (PHP_SAPI !== 'cli') ? '<pre>%s</pre>' : "\n%s\n\n";
        printf($template, trim(print_r($var, true)));

        return $var;
    }
}
