<?php

namespace App\Application\Client\Service;

use App\Application\Client\DTO\CreateClientDto;
use App\Domain\Client\Entity\Client;
use App\Domain\Client\Repository\ClientRepositoryInterface;
use App\Domain\Client\ValueObject\Email;
use App\Domain\Client\ValueObject\Phone;
use App\Domain\Client\ValueObject\Pin;

class CreateClientService
{
    public function __construct(
        private ClientRepositoryInterface $repository
    ) {}

    public function create(CreateClientDto $dto): Client
    {
        $client = new Client(
            $dto->name,
            $dto->age,
            $dto->region,
            $dto->income,
            $dto->score,
            new Pin($dto->pin),
            new Email($dto->email),
            new Phone($dto->phone)
        );

        $this->repository->save($client);

        return $client;
    }
}
