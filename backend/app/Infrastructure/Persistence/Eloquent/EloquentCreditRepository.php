<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Credit\Entity\Credit as DomainCredit;
use App\Domain\Credit\Repository\CreditRepositoryInterface;
use App\Models\Credit as EloquentCredit;
use Illuminate\Support\Facades\Log;

class EloquentCreditRepository implements CreditRepositoryInterface
{
    public function save(DomainCredit $credit): void
    {
        EloquentCredit::create([
            'name' => $credit->getName(),
            'amount' => $credit->getAmount(),
            'rate' => $credit->getRate() * 100, // Сохраняем как 10.0
            'start_date' => $credit->getStartDate()->format('Y-m-d'),
            'end_date' => $credit->getEndDate()->format('Y-m-d'),
            'client_pin' => $credit->getClient()->getPin()->getValue(),
        ]);

        Log::info('[DB] Notification to client '.$credit->getClient()->getName().': Loan approved.');
    }
}
