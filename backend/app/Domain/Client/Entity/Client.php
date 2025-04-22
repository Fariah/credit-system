<?php

namespace App\Domain\Client\Entity;

use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;

class Client
{
    public function __construct(
        private string $name,
        private int $age,
        private string $region,
        private float $income,
        private int $score,
        private Pin $pin,
        private Email $email,
        private Phone $phone
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getIncome(): float
    {
        return $this->income;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getPin(): Pin
    {
        return $this->pin;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
