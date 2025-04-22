<?php

namespace App\Domain\Credit\Event;

use App\Domain\Client\Entity\Client;

class CreditIssued
{
    public function __construct(
        public readonly Client $client,
        public readonly string $message
    ) {}
}
