<?php

namespace App\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Credit\CreditConditions;

class IncomeRule implements CreditRuleInterface
{
    public function isSatisfiedBy(Client $client): bool
    {
        return $client->getIncome() >= CreditConditions::MIN_INCOME;
    }

    public function getFailureMessage(): ?string
    {
        return 'Income must be at least '.CreditConditions::MIN_INCOME.'.';
    }
}
