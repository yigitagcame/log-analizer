<?php

namespace App\Validations;

use Symfony\Component\Validator\Constraints as Assert;

class LogCountRequestValidation extends BaseValidator
{
    protected function constraints() : Assert\Collection
    {
        return new Assert\Collection([
          'serviceNames' => [
            new Assert\Type(['type' => 'array']),
            new Assert\Optional()
          ],
          'startDate' => [
            new Assert\DateTime('d/M/Y:H:i:s O'),
            new Assert\Optional()
          ],
          'endDate' => [
            new Assert\DateTime('d/M/Y:H:i:s O'),
            new Assert\Optional()
          ],
          'statusCode' => [
            new Assert\Length(['min' => 3, 'max' => 3]),
            new Assert\Type('numeric'),
            new Assert\Optional()
          ]
        ]);
    }
}
