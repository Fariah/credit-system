<?php

namespace Tests\Unit\Application\Credit\Service;

use App\Application\Credit\DTO\IssueCreditDto;
use App\Application\Credit\Service\CreditIssuerService;
use App\Domain\Client\Entity\Client;
use App\Domain\Client\Repository\ClientRepositoryInterface;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;
use App\Domain\Credit\Entity\Credit;
use App\Domain\Credit\Event\CreditIssued;
use App\Domain\Credit\Repository\CreditRepositoryInterface;
use App\Domain\Credit\Rule\RegionRateModifierRule;
use App\Domain\Credit\Service\CreditEligibilityChecker;
use App\Domain\Notification\ClientNotificationInterface;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase;
use Tests\Fake\FakeClientNotification;

class CreditIssuerServiceTest extends TestCase
{
    private function makeClient(): Client
    {
        return new Client(
            name: 'Test User',
            age: 35,
            region: 'BR',
            income: 1500,
            score: 600,
            pin: new Pin('123-45-6789'),
            email: new Email('test@example.com'),
            phone: new Phone('+420123456789')
        );
    }

    public function test_credit_is_issued_and_client_notified(): void
    {
        Event::fake();
        $client = $this->makeClient();

        $clientRepo = $this->createMock(ClientRepositoryInterface::class);
        $clientRepo->method('findByPin')->willReturn($client);

        $creditRepo = $this->createMock(CreditRepositoryInterface::class);
        $creditRepo->expects($this->once())->method('save');

        $notifier = new FakeClientNotification;

        $checker = $this->createMock(CreditEligibilityChecker::class);
        $checker->method('isEligible')->willReturn(true);

        $modifier = new RegionRateModifierRule;

        $dto = new IssueCreditDto(
            pin: '123-45-6789',
            name: 'Test Loan',
            amount: 1000,
            start_date: '2024-01-01',
            end_date: '2024-12-31'
        );

        $service = new CreditIssuerService(
            clients: $clientRepo,
            credits: $creditRepo,
            checker: $checker,
            rateModifier: $modifier,
        );

        $result = $service->issue($dto);

        $this->assertInstanceOf(Credit::class, $result);
        $this->assertEquals('Test Loan', $result->getName());

        Event::assertDispatched(CreditIssued::class, function ($event) use ($client) {
            return $event->client === $client && str_contains($event->message, 'Loan approved');
        });
    }

    public function test_credit_is_not_issued_if_client_not_eligible(): void
    {
        $client = $this->makeClient();

        $clientRepo = $this->createMock(ClientRepositoryInterface::class);
        $clientRepo->method('findByPin')->willReturn($client);

        $creditRepo = $this->createMock(CreditRepositoryInterface::class);
        $creditRepo->expects($this->never())->method('save');

        $notifier = $this->createMock(ClientNotificationInterface::class);
        $notifier->expects($this->never())->method('notify');

        $checker = $this->createMock(CreditEligibilityChecker::class);
        $checker->method('isEligible')->willReturn(false);

        $modifier = new RegionRateModifierRule;

        $dto = new IssueCreditDto(
            pin: '123-45-6789',
            name: 'Test Loan',
            amount: 1000,
            start_date: '2024-01-01',
            end_date: '2024-12-31'
        );

        $service = new CreditIssuerService(
            clients: $clientRepo,
            credits: $creditRepo,
            checker: $checker,
            rateModifier: $modifier,
        );

        $result = $service->issue($dto);

        $this->assertNull($result);
    }
}
