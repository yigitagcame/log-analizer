<?php

namespace App\Validations;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

abstract class BaseValidator
{
    protected $validator;
    protected $constraint;
    protected $input;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    abstract protected function constraints() : Assert\Collection;

    public function input(array $input)
    {
        $this->input = $input;
    }

    public function validate()
    {
        return $this->validator->validate($this->input, $this->constraints());
    }
}
