<?php

namespace Tests\Fake;

use App\Domain\Client\Entity\Client;
use App\Domain\Notification\ClientNotificationInterface;

class FakeClientNotification implements ClientNotificationInterface
{
    /**
     * @var array{0: \App\Domain\Client\Entity\Client, 1: string}[]
     */
    public array $calls = [];

    public function notify(Client $client, string $message): void
    {
        $this->calls[] = [$client, $message];
    }
}
