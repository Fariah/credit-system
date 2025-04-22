<?php

namespace App\Domain\Credit\Repository;

use App\Domain\Credit\Entity\Credit;

interface CreditRepositoryInterface
{
    public function save(Credit $credit): void;
}
