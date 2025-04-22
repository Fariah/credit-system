<?php

namespace App\Domain\Credit\Entity;

use App\Domain\Client\Entity\Client;

class Credit
{
    public function __construct(
        private string $name,
        private float $amount,
        private float $rate,
        private \DateTimeInterface $startDate,
        private \DateTimeInterface $endDate,
        private Client $client
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
