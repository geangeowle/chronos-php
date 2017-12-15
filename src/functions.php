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
        $template = '<pre>%s</pre>';
        printf($template, print_r($var, true));
    }
}
