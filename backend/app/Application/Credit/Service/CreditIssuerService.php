<?php

namespace App\Application\Credit\Service;

use App\Application\Credit\DTO\IssueCreditDto;
use App\Domain\Client\Repository\ClientRepositoryInterface;
use App\Domain\Credit\CreditConditions;
use App\Domain\Credit\Entity\Credit;
use App\Domain\Credit\Event\CreditIssued;
use App\Domain\Credit\Repository\CreditRepositoryInterface;
use App\Domain\Credit\Rule\RegionRateModifierRule;
use App\Domain\Credit\Service\CreditEligibilityChecker;
use Illuminate\Support\Facades\DB;

class CreditIssuerService
{
    public function __construct(
        private ClientRepositoryInterface $clients,
        private CreditRepositoryInterface $credits,
        private CreditEligibilityChecker $checker,
        private RegionRateModifierRule $rateModifier,
    ) {}

    public function issue(IssueCreditDto $dto): ?Credit
    {
        $client = $this->clients->findByPin($dto->pin);

        if (! $client || ! $this->checker->isEligible($client)) {
            return null;
        }

        return DB::transaction(function () use ($client, $dto) {
            $baseRate = CreditConditions::BASE_RATE;
            $rate = $baseRate + $this->rateModifier->getRateModifier($client);

            $credit = new Credit(
                $dto->name,
                $dto->amount,
                $rate,
                new \DateTimeImmutable($dto->start_date),
                new \DateTimeImmutable($dto->end_date),
                $client
            );

            $this->credits->save($credit);

            event(new CreditIssued($client, 'Loan approved...'));

            return $credit;
        });
    }
}
