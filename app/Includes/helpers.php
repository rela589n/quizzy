<?php


if (!function_exists('str_contains')) {

    /**
     * Determine if <b>$needle</b> is substring of <b>$haystack</b>
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    function str_contains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }
}

if (!function_exists('singleVar')) {
    /**
     * Return variable if it is not null <br>
     * or calls $initializer
     * @param mixed $var
     * @param callable $initializer
     * @return mixed <b>$var</b>
     */
    function &singleVar(&$var, $initializer)
    {
        if ($var !== null) {
            return $var;
        }

        $returned = call_user_func($initializer);
        if ($var === null) {
            $var = $returned;
        }

        return $var;
    }
}

if (!function_exists('floatReadable')) {
    /**
     * Returns rounded to two digits after comma float value
     * @param float $float
     * @return float
     */
    function floatReadable(float $float)
    {
        return round($float, 2);
    }
}

if (!function_exists('next_line')) {

    /**
     * Reads file line by line
     * @param string $fileName
     * @return Generator
     * @throws \App\Exceptions\FileUnopenableException
     */
    function next_line(string $fileName) {
        $handle = fopen($fileName, 'r');

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                yield $line;
            }

            fclose($handle);
        } else {
            throw new \App\Exceptions\FileUnopenableException("Could not open file $fileName");
        }
    }
}
