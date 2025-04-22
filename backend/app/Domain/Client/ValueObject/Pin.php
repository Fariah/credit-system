<?php

namespace App\Domain\Client\ValueObject;

class Pin
{
    public function __construct(private string $value)
    {
        if (! preg_match('/^\d{3}-\d{2}-\d{4}$/', $value)) {
            throw new \InvalidArgumentException('Invalid PIN format.');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
