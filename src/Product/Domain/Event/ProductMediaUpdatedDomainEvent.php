<?php

declare(strict_types=1);

namespace App\Product\Domain\Event;

use App\Product\Domain\ValueObject\MediaDescription;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Domain\ValueObject\MediaName;
use App\Product\Domain\ValueObject\ProductId;
use App\Shared\Domain\Event\AbstractDomainEvent;
use App\Shared\Domain\ValueObject\DomainEventId;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class ProductMediaUpdatedDomainEvent extends AbstractDomainEvent
{
    public function __construct(
        public readonly ProductId $aggregateId,
        public readonly MediaId $mediaId,
        public readonly ?MediaName $name,
        public readonly ?MediaDescription $description,
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
            mediaId: new MediaId($body['mediaId']),
            name: isset($body['name']) ? new MediaName($body['name']) : null,
            description: isset($body['description']) ? new MediaDescription($body['description']) : null,
            eventId: $eventId,
            occurredOn: $occurredOn,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'mediaId' => $this->mediaId->toPrimitives(),
            'name' => $this->name?->toPrimitives(),
            'description' => $this->description?->toPrimitives(),
        ];
    }

    public static function eventName(): string
    {
        return 'product.media_updated';
    }
}
