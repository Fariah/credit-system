<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Client\Entity\Client as DomainClient;
use App\Domain\Client\Repository\ClientRepositoryInterface;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;
use App\Models\Client as EloquentClient;

class EloquentClientRepository implements ClientRepositoryInterface
{
    public function save(DomainClient $client): void
    {
        EloquentClient::updateOrCreate(
            ['pin' => $client->getPin()->getValue()],
            [
                'name' => $client->getName(),
                'age' => $client->getAge(),
                'region' => $client->getRegion(),
                'income' => $client->getIncome(),
                'score' => $client->getScore(),
                'email' => $client->getEmail()->getValue(),
                'phone' => $client->getPhone()->getValue(),
            ]
        );
    }

    public function findByPin(string $pin): ?DomainClient
    {
        $model = EloquentClient::where('pin', $pin)->first();

        if (! $model) {
            return null;
        }

        return new DomainClient(
            $model->name,
            $model->age,
            $model->region,
            (float) $model->income,
            $model->score,
            new Pin($model->pin),
            new Email($model->email),
            new Phone($model->phone)
        );
    }
}
