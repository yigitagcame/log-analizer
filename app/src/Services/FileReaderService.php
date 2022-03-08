<?php

namespace App\Services;

use App\Exceptions\FileNotFoundException;
use App\Services\FileReaderInterface;

class FileReaderService implements FileReaderInterface
{
    private string $filePath;
    private $file;

    /**
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = __DIR__.'/../../'.$filePath;

        if (!file_exists($this->filePath)) {
            throw new FileNotFoundException();
            return;
        }

        $this->file = fopen($this->filePath, 'r');
    }

    /**
     * Get full of the file content
     *
     * @return string
     */
    public function read(): string
    {
        return fread($this->file, filesize($this->filePath));
    }
    
    /**
     * Get the file content line by line
     *
     * @return array
     */
    public function readByLine() : array
    {
        while (!feof($this->file)) {
            $lines[] = fgets($this->file);
        }

        return $lines;
    }

    public function __destruct()
    {
        return fclose($this->file);
    }
}
