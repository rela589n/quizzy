<?php


namespace App\Lib\Words;


use App\Lib\Words\Decliners\WordDeclinerInterface;
use App\Lib\Words\Repositories\WordsRepository;

class WordsManager
{
    /**
     * @var WordDeclinerInterface
     */
    private $wordDecliner;

    /**
     * @var WordsRepository
     */
    private $wordsRepository;

    /**
     * WordsManager constructor.
     * @param WordDeclinerInterface $wordDecliner
     * @param WordsRepository $wordsRepository
     */
    public function __construct(WordDeclinerInterface $wordDecliner, WordsRepository $wordsRepository)
    {
        $this->wordDecliner = $wordDecliner;
        $this->wordsRepository = $wordsRepository;
    }

    /**
     * @param float|int $number
     * @param string $word
     */
    public function decline($number, string $word)
    {
        return $this->wordDecliner->decline(
            $number,
            $word,
            $this->wordsRepository->findEndings($word)
        );
    }
}
