<?php

namespace Tests\Unit\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;
use App\Domain\Credit\Rule\RegionRateModifierRule;
use PHPUnit\Framework\TestCase;

class RegionRateModifierRuleTest extends TestCase
{
    private function makeClient(string $region): Client
    {
        return new Client(
            name: 'Region Modifier',
            age: 40,
            region: $region,
            income: 2000,
            score: 650,
            pin: new Pin('333-22-1111'),
            email: new Email('test@example.com'),
            phone: new Phone('+420000000000'),
        );
    }

    public function test_modifier_for_ostrava_is_5_percent(): void
    {
        $rule = new RegionRateModifierRule;
        $client = $this->makeClient('OS');

        $this->assertEquals(0.05, $rule->getRateModifier($client));
    }

    public function test_modifier_for_other_regions_is_zero(): void
    {
        $rule = new RegionRateModifierRule;

        $this->assertEquals(0.0, $rule->getRateModifier($this->makeClient('PR')));
        $this->assertEquals(0.0, $rule->getRateModifier($this->makeClient('BR')));
        $this->assertEquals(0.0, $rule->getRateModifier($this->makeClient('NY')));
    }
}
