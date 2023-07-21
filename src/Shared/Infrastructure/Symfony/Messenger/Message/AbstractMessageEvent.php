<?php

namespace App\Shared\Infrastructure\Symfony\Messenger\Message;

use App\Shared\Domain\Event\DomainEventInterface;
use DateTimeInterface;

abstract class AbstractMessageEvent implements MessageInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $occurredOn,
        public readonly array $data,
        public readonly array $meta = [],
    ) {
    }

    public static function fromDomainEvent(DomainEventInterface $domainEvent): self
    {
        return new static(
            id: (string)$domainEvent->getEventId(),
            type: $domainEvent::eventName(),
            occurredOn: $domainEvent->getOccurredOn()->format(DateTimeInterface::RFC3339_EXTENDED),
            data: array_merge($domainEvent->toPrimitives(), ['id' => $domainEvent->aggregateId()]),
        );
    }
}
