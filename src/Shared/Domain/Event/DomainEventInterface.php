<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use App\Shared\Domain\ValueObject\DomainEventId;
use DateTimeImmutable;

interface DomainEventInterface
{
    public function aggregateId(): string;

    public function getEventId(): DomainEventId;

    public function getOccurredOn(): DateTimeImmutable;

    public static function fromPrimitives(string $aggregateId, array $body, DomainEventId $eventId, DateTimeImmutable $occurredOn): self;

    public function toPrimitives(): array;

    public static function eventName(): string;
}
