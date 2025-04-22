<?php

namespace App\Domain\Credit\Service;

use App\Domain\Client\Entity\Client;
use App\Domain\Credit\Rule\CreditRuleInterface;

class CreditEligibilityChecker
{
    /**
     * @param  CreditRuleInterface[]  $rules
     */
    public function __construct(
        private array $rules
    ) {}

    public function isEligible(Client $client): bool
    {
        foreach ($this->rules as $rule) {
            if (! $rule->isSatisfiedBy($client)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string[]
     */
    public function getFailureMessages(Client $client): array
    {
        $messages = [];

        foreach ($this->rules as $rule) {
            if (! $rule->isSatisfiedBy($client)) {
                $msg = $rule->getFailureMessage();
                if ($msg !== null) {
                    $messages[] = $msg;
                }
            }
        }

        return $messages;
    }
}
