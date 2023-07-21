<?php

declare(strict_types=1);

namespace App\Product\Domain\Event;

use App\Product\Domain\ValueObject\Currency;
use App\Product\Domain\ValueObject\Decimal;
use App\Product\Domain\ValueObject\DistributionType;
use App\Product\Domain\ValueObject\ProductDescription;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Domain\ValueObject\ShopReference;
use App\Product\Domain\ValueObject\Toggle;
use App\Shared\Domain\Event\AbstractDomainEvent;
use App\Shared\Domain\ValueObject\DomainEventId;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\Uid\Uuid;

final class ProductCreatedDomainEvent extends AbstractDomainEvent
{
    public function __construct(
        public readonly ProductId $aggregateId,
        public readonly ShopReference $shop,
        public readonly ProductName $name,
        public readonly ProductDescription $description,
        public readonly ProductPrice $price,
        public readonly DistributionType $distributionType,
        public readonly Toggle $enabled,
        public readonly DateTimeInterface $createdAt,
        public readonly DateTimeInterface $updatedAt,
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
            shop: new ShopReference(Uuid::fromString($body['shop'])),
            name: new ProductName($body['name']),
            description: new ProductDescription($body['description']),
            price: new ProductPrice(
                amount: new Decimal($body['price']['amount']),
                currency: new Currency($body['price']['currency']),
            ),
            distributionType: DistributionType::from($body['distributionType']),
            enabled: Toggle::from($body['enabled']),
            createdAt: new DateTimeImmutable($body['createdAt']),
            updatedAt: new DateTime($body['updatedAt']),
            eventId: $eventId,
            occurredOn: $occurredOn,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'shop' => $this->shop->toPrimitives(),
            'name' => $this->name->toPrimitives(),
            'description' => $this->description->toPrimitives(),
            'price' => $this->price->toPrimitives(),
            'distributionType' => $this->distributionType->toPrimitives(),
            'enabled' => $this->enabled->toPrimitives(),
            'createdAt' => $this->createdAt->format(DateTimeInterface::RFC3339_EXTENDED),
            'updatedAt' => $this->updatedAt->format(DateTimeInterface::RFC3339_EXTENDED),
        ];
    }

    public static function eventName(): string
    {
        return 'product.created';
    }
}
