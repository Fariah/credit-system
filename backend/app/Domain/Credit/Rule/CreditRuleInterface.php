<?php

namespace App\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;

interface CreditRuleInterface
{
    public function isSatisfiedBy(Client $client): bool;

    public function getFailureMessage(): ?string;
}
