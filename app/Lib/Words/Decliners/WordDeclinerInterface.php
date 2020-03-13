<?php


namespace App\Lib\Words\Decliners;


interface WordDeclinerInterface
{
    public function decline($numberOf, string $wordRoot, array $endings);
}
