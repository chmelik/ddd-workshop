<?php

declare(strict_types=1);

namespace App\Product\Domain\Event;

use App\Product\Domain\ValueObject\Currency;
use App\Product\Domain\ValueObject\Decimal;
use App\Product\Domain\ValueObject\ProductDescription;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Domain\ValueObject\Toggle;
use App\Shared\Domain\Event\AbstractDomainEvent;
use App\Shared\Domain\ValueObject\DomainEventId;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class ProductUpdatedDomainEvent extends AbstractDomainEvent
{
    public function __construct(
        public readonly ProductId $aggregateId,
        public readonly ?ProductName $name,
        public readonly ?ProductDescription $description,
        public readonly ?ProductPrice $price,
        public readonly ?Toggle $enabled,
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
            name: isset($body['name']) ? new ProductName($body['name']) : null,
            description: isset($body['description']) ? new ProductDescription($body['description']) : null,
            price: isset($body['price'])
                ? new ProductPrice(
                    amount: new Decimal($body['price']['amount']),
                    currency: new Currency($body['price']['currency']),
                )
                : null,
            enabled: isset($body['enabled']) ? Toggle::from($body['enabled']) : null,
            eventId: $eventId,
            occurredOn: $occurredOn,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'name' => $this->name?->toPrimitives(),
            'description' => $this->description?->toPrimitives(),
            'price' => $this->price?->toPrimitives(),
            'enabled' => $this->enabled?->toPrimitives(),
        ];
    }

    public static function eventName(): string
    {
        return 'product.updated';
    }
}
