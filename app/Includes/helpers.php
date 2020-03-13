<?php


if (!function_exists('declineCyrillicWord')) {
    /**
     * @param $numberOf - declined number
     * @param $wordRoot - the first part of the word (can be called the root)
     * @param $postfixes - array of possible word endings
     * @return string
     */
    function declineCyrillicWord($numberOf, $wordRoot, $postfixes) : string
    {
        $keys = array(2, 0, 1, 1, 1, 2);

        if (floor($numberOf) != $numberOf) {
            $suffix_key = 1;
        }
        else {
            $mod = $numberOf % 100;
            $suffix_key = $mod > 4 && $mod < 20 ? 2 : $keys[min($mod%10, 5)];
        }

        return $wordRoot . $postfixes[$suffix_key];
    }
}

if(!function_exists('str_contains')) {

    /**
     * Determine if <b>$needle</b> is substring of <b>$haystack</b>
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    function str_contains($haystack, $needle) {
        return strpos($haystack, $needle) !== false;
    }
}
