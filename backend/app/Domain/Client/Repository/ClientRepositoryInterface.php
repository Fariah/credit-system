<?php

namespace App\Domain\Client\Repository;

use App\Domain\Client\Entity\Client;

interface ClientRepositoryInterface
{
    public function save(Client $client): void;

    public function findByPin(string $pin): ?Client;
}
