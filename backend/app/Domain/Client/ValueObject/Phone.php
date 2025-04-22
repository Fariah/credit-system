<?php

namespace App\Domain\Client\ValueObject;

class Phone
{
    public function __construct(private string $value)
    {
        if (! preg_match('/^\+?\d{9,15}$/', $value)) {
            throw new \InvalidArgumentException('Invalid phone number.');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
