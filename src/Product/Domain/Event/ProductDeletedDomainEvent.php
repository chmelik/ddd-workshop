<?php

declare(strict_types=1);

namespace App\Product\Domain\Event;

use App\Product\Domain\ValueObject\ProductId;
use App\Shared\Domain\Event\AbstractDomainEvent;
use App\Shared\Domain\ValueObject\DomainEventId;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class ProductDeletedDomainEvent extends AbstractDomainEvent
{
    public function __construct(
        public readonly ProductId $aggregateId,
        ?DomainEventId $eventId = null,
        ?DateTimeImmutable $occurredOn = null,
    ) {
        parent::__construct($eventId, $occurredOn);
    }

    public function aggregateId(): string
    {
        return (string) $this->aggregateId;
    }

    public static function fromPrimitives(string $aggregateId, array $body, DomainEventId $eventId, DateTimeImmutable $occurredOn): AbstractDomainEvent
    {
        return new self(
            aggregateId: new ProductId(Uuid::fromString($aggregateId)),
            eventId: $eventId,
            occurredOn: $occurredOn,
        );
    }

    public function toPrimitives(): array
    {
        return [];
    }

    public static function eventName(): string
    {
        return 'product.deleted';
    }
}
