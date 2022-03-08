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
     * Iterate the file content line by line
     *
     * @return array
     */
    public function readByLineIterator($iterator) : array
    {
        if (!is_callable($iterator)) {
            return null;
        }

        while (!feof($this->file)) {
            $lines[] = $iterator(fgets($this->file), null);
        }

        return $lines;
    }

    public function __destruct()
    {
        return fclose($this->file);
    }
}
