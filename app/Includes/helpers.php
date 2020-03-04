<?php


if (!function_exists('declineCyrillicWord')) {
    /**
     * @param $numberOf - declined number
     * @param $wordRoot - the first part of the word (can be called the root)
     * @param $postfixes - array of possible word endings
     * @return string
     */
    function declineCyrillicWord(int $numberOf, $wordRoot, $postfixes) : string
    {
        $keys = array(2, 0, 1, 1, 1, 2);
        $mod = $numberOf % 100;
        $suffix_key = $mod > 4 && $mod < 20 ? 2 : $keys[min($mod%10, 5)];

        return $wordRoot . $postfixes[$suffix_key];
    }
}
