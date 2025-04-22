<?php

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Credit\Entity\Credit;
use App\Domain\Credit\Repository\CreditRepositoryInterface;
use Illuminate\Support\Facades\Log;

class InMemoryCreditRepository implements CreditRepositoryInterface
{
    /** @var Credit[] */
    private array $credits = [];

    public function save(Credit $credit): void
    {
        $this->credits[] = $credit;

        Log::info('Notification to client '.$credit->getClient()->getName().': Loan approved.');
    }

    /**
     * @return Credit[]
     */
    public function getAll(): array
    {
        return $this->credits;
    }
}
