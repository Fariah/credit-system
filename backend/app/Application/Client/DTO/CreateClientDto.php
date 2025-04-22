<?php

namespace App\Application\Client\DTO;

class CreateClientDto
{
    public function __construct(
        public string $name,
        public int $age,
        public string $region,
        public float $income,
        public int $score,
        public string $pin,
        public string $email,
        public string $phone
    ) {}
}
