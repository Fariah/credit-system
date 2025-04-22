<?php

namespace App\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Credit\CreditConditions;

class AgeRule implements CreditRuleInterface
{
    public function isSatisfiedBy(Client $client): bool
    {
        $age = $client->getAge();

        return $age >= CreditConditions::MIN_AGE && $age <= CreditConditions::MAX_AGE;
    }

    public function getFailureMessage(): ?string
    {
        return 'Age must be between '.CreditConditions::MIN_AGE.' and '.CreditConditions::MAX_AGE.'.';
    }
}
