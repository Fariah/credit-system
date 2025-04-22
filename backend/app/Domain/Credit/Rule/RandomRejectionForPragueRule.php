<?php

namespace App\Domain\Credit\Rule;

use App\Domain\Client\Entity\Client;

class RandomRejectionForPragueRule implements CreditRuleInterface
{
    public function isSatisfiedBy(Client $client): bool
    {
        if ($client->getRegion() !== 'PR') {
            return true;
        }

        return random_int(0, 1) === 1;
    }

    public function getFailureMessage(): ?string
    {
        return 'Random rejection applied for region PR.';
    }
}
