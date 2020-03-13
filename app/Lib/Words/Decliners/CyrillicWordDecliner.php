<?php


namespace App\Lib\Words\Decliners;


class CyrillicWordDecliner implements WordDeclinerInterface
{

    public function decline($numberOf, string $wordRoot, array $endings)
    {
        $keys = [2, 0, 1, 1, 1, 2];

        if (floor($numberOf) != $numberOf) {
            $suffix_key = 1;
        }
        else {
            $mod = $numberOf % 100;
            $suffix_key = $mod > 4 && $mod < 20 ? 2 : $keys[min($mod%10, 5)];
        }

        return $wordRoot . $endings[$suffix_key];
    }
}
