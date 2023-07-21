<?php

declare(strict_types=1);

namespace App\Product\Domain\Event;

use App\Product\Domain\ValueObject\Discount;
use App\Product\Domain\ValueObject\ProductId;
use App\Shared\Domain\Event\AbstractDomainEvent;
use App\Shared\Domain\ValueObject\DomainEventId;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class ProductDiscountAppliedDomainEvent extends AbstractDomainEvent
{
    public function __construct(
        public readonly ProductId $aggregateId,
        public readonly Discount $discount,
        ?DomainEventId $eventId = null,
        ?DateTimeImmutable $occurredOn = null,
    ) {
        parent::__construct($eventId, $occurredOn);
    }

    public function aggregateId(): string
    {
        return (string) $this->aggregateId;
    }

    public static function fromPrimitives(string $aggregateId, array $body, DomainEventId $eventId, DateTimeImmutable $occurredOn): self
    {
        return new self(
            aggregateId: new ProductId(Uuid::fromString($aggregateId)),
            discount: new Discount($body['discount']),
            eventId: $eventId,
            occurredOn: $occurredOn,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'discount' => $this->discount->getAmount(),
        ];
    }

    public static function eventName(): string
    {
        return 'product.discount_applied';
    }
}
