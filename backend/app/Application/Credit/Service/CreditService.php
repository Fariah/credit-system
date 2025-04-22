<?php

namespace App\Application\Credit\Service;

use App\Application\Credit\DTO\CreditCheckResult;
use App\Domain\Client\Entity\Client;
use App\Domain\Credit\CreditConditions;
use App\Domain\Credit\Rule\RegionRateModifierRule;
use App\Domain\Credit\Service\CreditEligibilityChecker;

class CreditService
{
    public function __construct(
        private CreditEligibilityChecker $checker,
        private RegionRateModifierRule $rateModifier
    ) {}

    public function check(Client $client): CreditCheckResult
    {
        $isEligible = $this->checker->isEligible($client);
        $failures = $this->checker->getFailureMessages($client);

        $baseRate = CreditConditions::BASE_RATE;
        $rate = $baseRate + $this->rateModifier->getRateModifier($client);

        return new CreditCheckResult(
            approved: $isEligible,
            rate: round($rate * CreditConditions::RATE_MULTIPLIER, 2).'%',
            reasons: $failures
        );
    }
}
