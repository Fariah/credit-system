<?php

namespace Tests\Unit\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;
use App\Domain\Credit\Rule\AgeRule;
use PHPUnit\Framework\TestCase;

class AgeRuleTest extends TestCase
{
    private function makeClient(int $age): Client
    {
        return new Client(
            name: 'Age Test',
            age: $age,
            region: 'BR',
            income: 2000,
            score: 700,
            pin: new Pin('123-45-6789'),
            email: new Email('test@example.com'),
            phone: new Phone('+420000000000'),
        );
    }

    public function test_client_within_valid_age_passes(): void
    {
        $rule = new AgeRule;
        $this->assertTrue($rule->isSatisfiedBy($this->makeClient(18)));
        $this->assertTrue($rule->isSatisfiedBy($this->makeClient(35)));
        $this->assertTrue($rule->isSatisfiedBy($this->makeClient(60)));
    }

    public function test_client_too_young_fails(): void
    {
        $rule = new AgeRule;
        $this->assertFalse($rule->isSatisfiedBy($this->makeClient(17)));
    }

    public function test_client_too_old_fails(): void
    {
        $rule = new AgeRule;
        $this->assertFalse($rule->isSatisfiedBy($this->makeClient(61)));
    }
}
