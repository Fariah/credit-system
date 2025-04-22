<?php

namespace Tests\Unit\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;
use App\Domain\Credit\Rule\RandomRejectionForPragueRule;
use PHPUnit\Framework\TestCase;

class RandomRejectionForPragueRuleTest extends TestCase
{
    private function makeClient(string $region): Client
    {
        return new Client(
            name: 'Random PR',
            age: 35,
            region: $region,
            income: 1500,
            score: 600,
            pin: new Pin('999-88-7777'),
            email: new Email('test@example.com'),
            phone: new Phone('+420000000000'),
        );
    }

    public function test_clients_not_from_prague_always_pass(): void
    {
        $rule = new RandomRejectionForPragueRule;
        $client = $this->makeClient('BR');
        $this->assertTrue($rule->isSatisfiedBy($client));

        $client = $this->makeClient('OS');
        $this->assertTrue($rule->isSatisfiedBy($client));
    }
}
