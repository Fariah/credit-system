<?php

namespace App\Application\Credit\DTO;

class CreditCheckResult
{
    public function __construct(
        public readonly bool $approved,
        public readonly string $rate,
        /** @var string[] */
        public readonly array $reasons
    ) {}
}
