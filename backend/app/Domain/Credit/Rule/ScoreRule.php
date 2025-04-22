<?php

namespace App\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;
use App\Domain\Credit\CreditConditions;

class ScoreRule implements CreditRuleInterface
{
    public function isSatisfiedBy(Client $client): bool
    {
        return $client->getScore() >= CreditConditions::MIN_SCORE;
    }

    public function getFailureMessage(): ?string
    {
        return 'Score must be at least '.CreditConditions::MIN_SCORE.'.';
    }
}
