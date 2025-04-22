<?php

namespace Tests\Unit\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;
use App\Domain\Credit\Rule\ScoreRule;
use PHPUnit\Framework\TestCase;

class ScoreRuleTest extends TestCase
{
    public function test_rule_passes_if_score_is_high_enough(): void
    {
        $client = new Client(
            name: 'Test',
            age: 30,
            region: 'BR',
            income: 2000,
            score: 700,
            pin: new Pin('111-11-1111'),
            email: new Email('test@example.com'),
            phone: new Phone('+420000000000'),
        );

        $rule = new ScoreRule;
        $this->assertTrue($rule->isSatisfiedBy($client));
    }

    public function test_rule_fails_if_score_is_too_low(): void
    {
        $client = new Client(
            name: 'Test',
            age: 30,
            region: 'BR',
            income: 2000,
            score: 400,
            pin: new Pin('111-11-1111'),
            email: new Email('tes2t@example.com'),
            phone: new Phone('+420000200000'),
        );

        $rule = new ScoreRule;
        $this->assertFalse($rule->isSatisfiedBy($client));
    }
}
