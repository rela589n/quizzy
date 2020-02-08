<?php

if (!function_exists('print_arr')) {
    /**
     * Prints human-readable information about a variable
     * @link https://php.net/manual/en/function.print-r.php
     * @param mixed $expression <p>
     * The expression to be printed.
     * </p>
     * @param bool $return [optional] <p>
     * If you would like to capture the output of print_r,
     * use the return parameter. If this parameter is set
     * to true, print_r will return its output, instead of
     * printing it (which it does by default).
     * </p>
     * @return string|true If given a string, integer or float,
     * the value itself will be printed. If given an array, values
     * will be presented in a format that shows keys and elements. Similar
     * notation is used for objects.
     * @since 4.0
     * @since 5.0
     */
    function print_arr($expression, $return = null)
    {
        if ($return) {
            ob_start();
        }
        print '<pre>';
        print_r($expression);
        print '</pre>';

        if ($return) {
            return ob_get_clean();
        }

        return null;
    }
}

if (!function_exists('log_r')) {
    function log_r($var, $mark = '') {
        \Log::info(
            $mark .
            print_r($var, true)
        );
    }
}
