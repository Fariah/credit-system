<?php

namespace Tests\Unit\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;
use App\Domain\Credit\Rule\IncomeRule;
use PHPUnit\Framework\TestCase;

class IncomeRuleTest extends TestCase
{
    private function makeClient(float $income): Client
    {
        return new Client(
            name: 'Income Test',
            age: 30,
            region: 'BR',
            income: $income,
            score: 600,
            pin: new Pin('111-22-3333'),
            email: new Email('test@example.com'),
            phone: new Phone('+420000000000'),
        );
    }

    public function test_client_with_valid_income_passes(): void
    {
        $rule = new IncomeRule;
        $this->assertTrue($rule->isSatisfiedBy($this->makeClient(1000)));
        $this->assertTrue($rule->isSatisfiedBy($this->makeClient(1500)));
    }

    public function test_client_with_insufficient_income_fails(): void
    {
        $rule = new IncomeRule;
        $this->assertFalse($rule->isSatisfiedBy($this->makeClient(999.99)));
        $this->assertFalse($rule->isSatisfiedBy($this->makeClient(0)));
    }
}
