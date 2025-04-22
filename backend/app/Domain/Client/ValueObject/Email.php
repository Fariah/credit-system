<?php

namespace App\Domain\Client\ValueObject;

class Email
{
    public function __construct(private string $value)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email.');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
