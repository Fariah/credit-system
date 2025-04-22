<?php

namespace App\Application\Credit\DTO;

class IssueCreditDto
{
    public function __construct(
        public string $pin,
        public string $name,
        public float $amount,
        public string $start_date,
        public string $end_date
    ) {}
}
