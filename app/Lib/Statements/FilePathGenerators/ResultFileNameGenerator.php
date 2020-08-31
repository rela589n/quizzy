<?php


namespace App\Lib\Statements\FilePathGenerators;


abstract class ResultFileNameGenerator
{
    protected string $storageDir = 'app/public/statements/';
    protected string $filePrefix = 'Відомість';

    public function generate(): string
    {
        return storage_path(
            sprintf(
                '%s%s',
                $this->storageDir,
                $this->generateFileName()
            )
        );
    }

    abstract protected function generateFileName(): string;
}
