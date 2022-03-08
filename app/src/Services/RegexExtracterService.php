<?php

namespace App\Services;

class RegexExtracterService
{
    protected string $input;
    protected array $regexList;

    /**
     *
     * @param array $regexList
     */
    public function __construct(array $regexList)
    {
        $this->regexList = $regexList;
    }

    /**
     * Extracted string return as if function named after regexlist key
     */

    public function __call($name, $arguments)
    {
        preg_match($this->regexList[$name], $this->input, $output_array);
        return isset($output_array[1]) ? $output_array[1] : null;
    }

    /**
     * Set text regex gonna be applied
     *
     * @param [type] $input
     * @return void
     */
    public function setInput($input)
    {
        $this->input = $input;
    }
}
