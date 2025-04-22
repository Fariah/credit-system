<?php

namespace Tests\Unit\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;
use App\Domain\Credit\Rule\RegionRule;
use PHPUnit\Framework\TestCase;

class RegionRuleTest extends TestCase
{
    private function makeClient(string $region): Client
    {
        return new Client(
            name: 'Region Test',
            age: 25,
            region: $region,
            income: 1200,
            score: 610,
            pin: new Pin('555-66-7777'),
            email: new Email('test@example.com'),
            phone: new Phone('+420000000000'),
        );
    }

    public function test_allowed_regions_pass(): void
    {
        $rule = new RegionRule;

        $this->assertTrue($rule->isSatisfiedBy($this->makeClient('PR')));
        $this->assertTrue($rule->isSatisfiedBy($this->makeClient('BR')));
        $this->assertTrue($rule->isSatisfiedBy($this->makeClient('OS')));
    }

    public function test_disallowed_region_fails(): void
    {
        $rule = new RegionRule;

        $this->assertFalse($rule->isSatisfiedBy($this->makeClient('NY')));
        $this->assertFalse($rule->isSatisfiedBy($this->makeClient('LA')));
    }
}
