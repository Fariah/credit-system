<?php

namespace App\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Credit\CreditConditions;

class RegionRateModifierRule implements CreditRuleInterface
{
    public function isSatisfiedBy(Client $client): bool
    {
        return true;
    }

    public function getFailureMessage(): ?string
    {
        return null;
    }

    public function getRateModifier(Client $client): float
    {
        return CreditConditions::REGION_RATE_MODIFIERS[$client->getRegion()] ?? 0.0;
    }
}
