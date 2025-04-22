<?php

namespace App\Listeners;

use App\Domain\Credit\Event\CreditIssued;
use App\Domain\Notification\ClientNotificationInterface;

class NotifyClientAboutCredit
{
    public function __construct(
        private ClientNotificationInterface $notifier
    ) {}

    public function handle(CreditIssued $event): void
    {
        $this->notifier->notify($event->client, $event->message);
    }
}
