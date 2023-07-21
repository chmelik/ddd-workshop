<?php

namespace App\Shared\Domain\Event;

use App\Shared\Domain\ValueObject\DomainEventId;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;

abstract class AbstractDomainEvent extends Event implements DomainEventInterface
{
    public readonly DomainEventId $eventId;
    public readonly DateTimeImmutable $occurredOn;

    public function __construct(?DomainEventId $eventId = null, ?DateTimeImmutable $occurredOn = null)
    {
        $this->eventId = $eventId ?: new DomainEventId(Uuid::v7());
        $this->occurredOn = $occurredOn ?: new DateTimeImmutable();
    }

    public function getEventId(): DomainEventId
    {
        return $this->eventId;
    }

    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
