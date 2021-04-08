<?php


namespace App\Lib\Statements\FilePathGenerators;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function url(string $filePath): string
    {
        return Storage::disk('public')
            ->url(Str::after($filePath, app('path.storage').'/app/public'));
    }

    abstract function generateFileName(): string;
}
