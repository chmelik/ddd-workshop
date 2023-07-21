<?php

namespace App\Shared\Infrastructure\Symfony\EventDispatcher;

use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Domain\Event\DomainEventInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class EventBus implements EventBusInterface
{
    public function __construct(private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    public function publish(DomainEventInterface ...$domainEvents): void
    {
        foreach ($domainEvents as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}
