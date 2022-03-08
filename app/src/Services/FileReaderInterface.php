<?php

namespace App\Services;

interface FileReaderInterface
{
    /**
     * Get full of the file content
     *
     * @return string
     */
    public function read(): string;

    /**
     * Get the file content line by line
     *
     * @return array
     */
    public function readByLineIterator($iterator): array;
}
