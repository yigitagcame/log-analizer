<?php

namespace App\Services;

use App\Services\FileReaderInterface;
use App\Services\FileReaderService;
use App\Services\RegexExtracterService;

use Carbon\Carbon;

class HttpLogCounterService
{
    private FileReaderInterface $fileReader;

    private object $regexExtracter;

    private array $fileContent;

    private array $searchFields;
  
    public function __construct(array $searchFields, string $filePath)
    {
        $this->fileReader = new FileReaderService($filePath);
        $this->regexExtracter = new RegexExtracterService([
          'serviceName' => '/(.*)\s-\s-\s/',
          'date' => '/\[(\d{2}\/\w{3}\/\d{4}:\d{2}:\d{2}:\d{2}\s\+\d{1,4})\]/',
          'statusCode' => '/\s(\d{3})/',
        ]);

        $this->fileContent = $this->fileReader->readByLine();
        $this->searchFields = $searchFields;
    }

    public function count()
    {
        $search = array_map(function ($logLine) {
            $this->regexExtracter->setInput($logLine);
            return (int) $this->matchMaker();
        }, $this->fileContent);

        return array_sum($search);
    }

    public function serviceNamesMatch() : bool
    {
        return in_array($this->regexExtracter->serviceName(), $this->searchFields['serviceNames']);
    }

    public function startDateMatch() : bool
    {
        $logDate = $this->dateInstance($this->regexExtracter->date());
        $inputDate = $this->dateInstance($this->searchFields['startDate']);

        $result = $logDate->greaterThanOrEqualTo($inputDate);
        return (bool) $result;
    }

    public function endDateMatch() : bool
    {
        $logDate = $this->dateInstance($this->regexExtracter->date());
        $inputDate =$this->dateInstance($this->searchFields['endDate']);

        $result = $logDate->lessThanOrEqualTo($inputDate);
        return (bool) $result;
    }

    public function statusCodeMatch() : bool
    {
        return $this->regexExtracter->statusCode() == trim($this->searchFields['statusCode']);
    }

    protected function matchMaker()
    {
        $results = array_map(function ($search) {
            return $this->{$search.'Match'}();
        }, array_keys($this->searchFields));
        return !in_array(false, $results);
    }

    protected function dateInstance($date)
    {
        return Carbon::createFromFormat("d/M/Y:H:i:s O", $date);
    }
}
