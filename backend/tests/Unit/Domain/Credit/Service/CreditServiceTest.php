<?php

namespace Tests\Unit\Application\Credit\Service;

use App\Application\Credit\Service\CreditService;
use App\Domain\Client\Entity\Client;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;
use App\Domain\Credit\Rule\RegionRateModifierRule;
use App\Domain\Credit\Service\CreditEligibilityChecker;
use PHPUnit\Framework\TestCase;

class CreditServiceTest extends TestCase
{
    /**
     * @param  array<string, mixed>  $data
     */
    private function makeClient(array $data = []): Client
    {
        return new Client(
            name: $data['name'] ?? 'Client',
            age: $data['age'] ?? 40,
            region: $data['region'] ?? 'OS',
            income: $data['income'] ?? 2000,
            score: $data['score'] ?? 650,
            pin: new Pin($data['pin'] ?? '000-11-2222'),
            email: new Email($data['email'] ?? 'test@client.com'),
            phone: new Phone($data['phone'] ?? '+420123456789')
        );
    }

    public function test_approved_client_gets_correct_rate(): void
    {
        $client = $this->makeClient();

        $checker = $this->createMock(CreditEligibilityChecker::class);
        $checker->method('isEligible')->willReturn(true);
        $checker->method('getFailureMessages')->willReturn([]);

        $modifier = new RegionRateModifierRule;
        $service = new CreditService($checker, $modifier);

        $result = $service->check($client);

        $this->assertTrue($result->approved);
        $this->assertEquals('15%', $result->rate);
        $this->assertEmpty($result->reasons);
    }

    public function test_rejected_client_gets_failure_messages(): void
    {
        $client = $this->makeClient();

        $checker = $this->createMock(CreditEligibilityChecker::class);
        $checker->method('isEligible')->willReturn(false);
        $checker->method('getFailureMessages')->willReturn([
            'Client is too young',
            'Income too low',
        ]);

        $modifier = new RegionRateModifierRule;
        $service = new CreditService($checker, $modifier);

        $result = $service->check($client);

        $this->assertFalse($result->approved);
        $this->assertEquals('15%', $result->rate);
        $this->assertContains('Client is too young', $result->reasons);
        $this->assertContains('Income too low', $result->reasons);
    }
}
