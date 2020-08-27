<?php


namespace App\Lib\Words\Repositories;


abstract class WordsRepository
{
    protected array $wordEndings = [
        // 'word' => ['', 's']
    ];

    public function findEndings(string $word)
    {
        return $this->wordEndings[trim($word)] ?? [];
    }
}
