<?php

namespace App\Domain\Notification;

use App\Domain\Client\Entity\Client;

interface ClientNotificationInterface
{
    public function notify(Client $client, string $message): void;
}
