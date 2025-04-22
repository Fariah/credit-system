<?php

namespace Tests\Unit\Domain\Credit\Service;

use App\Domain\Client\Entity\Client;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;
use App\Domain\Credit\CreditConditions;
use App\Domain\Credit\Rule\AgeRule;
use App\Domain\Credit\Rule\IncomeRule;
use App\Domain\Credit\Rule\RegionRule;
use App\Domain\Credit\Rule\ScoreRule;
use App\Domain\Credit\Service\CreditEligibilityChecker;
use PHPUnit\Framework\TestCase;

class CreditEligibilityCheckerTest extends TestCase
{
    /**
     * @param  array<string, mixed>  $data
     */
    private function makeClient(array $data = []): Client
    {
        return new Client(
            name: $data['name'] ?? 'Checker Test',
            age: $data['age'] ?? 30,
            region: $data['region'] ?? 'BR',
            income: $data['income'] ?? 1500,
            score: $data['score'] ?? 600,
            pin: new Pin($data['pin'] ?? '000-00-0000'),
            email: new Email($data['email'] ?? 'client@example.com'),
            phone: new Phone($data['phone'] ?? '+420000000000')
        );
    }

    public function test_eligible_client_passes_all_rules(): void
    {
        $checker = new CreditEligibilityChecker([
            new ScoreRule,
            new IncomeRule,
            new AgeRule,
            new RegionRule,
        ]);

        $client = $this->makeClient();
        $this->assertTrue($checker->isEligible($client));
        $this->assertEquals([], $checker->getFailureMessages($client));
    }

    public function test_client_fails_due_to_score_and_age(): void
    {
        $checker = new CreditEligibilityChecker([
            new ScoreRule,
            new AgeRule,
        ]);

        $client = $this->makeClient([
            'score' => 100,
            'age' => 17,
        ]);

        $this->assertFalse($checker->isEligible($client));

        $messages = $checker->getFailureMessages($client);

        $this->assertContains('Score must be at least '.CreditConditions::MIN_SCORE.'.', $messages);
        $this->assertContains('Age must be between '.CreditConditions::MIN_AGE.' and '.CreditConditions::MAX_AGE.'.', $messages);
    }
}
