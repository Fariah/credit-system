<?php

namespace App\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Credit\CreditConditions;

class RegionRule implements CreditRuleInterface
{
    public function isSatisfiedBy(Client $client): bool
    {
        return in_array($client->getRegion(), CreditConditions::ALLOWED_REGIONS, true);
    }

    public function getFailureMessage(): ?string
    {
        return 'Region must be one of: '.implode(', ', CreditConditions::ALLOWED_REGIONS).'.';
    }
}
