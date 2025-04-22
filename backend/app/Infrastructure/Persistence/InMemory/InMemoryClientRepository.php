<?php

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Client\Entity\Client;
use App\Domain\Client\Repository\ClientRepositoryInterface;

class InMemoryClientRepository implements ClientRepositoryInterface
{
    /**
     * @var Client[]
     */
    private array $clients = [];

    public function save(Client $client): void
    {
        $this->clients[$client->getPin()->getValue()] = $client;
    }

    public function findByPin(string $pin): ?Client
    {
        return $this->clients[$pin] ?? null;
    }
}
