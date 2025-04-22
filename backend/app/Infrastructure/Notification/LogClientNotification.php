<?php

namespace App\Infrastructure\Notification;

use App\Domain\Client\Entity\Client;
use App\Domain\Notification\ClientNotificationInterface;
use Illuminate\Support\Facades\Log;

class LogClientNotification implements ClientNotificationInterface
{
    public function notify(Client $client, string $message): void
    {
        Log::info("Notification to client {$client->getName()}: {$message}");
    }
}
