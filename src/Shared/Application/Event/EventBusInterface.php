<?php

declare(strict_types=1);

namespace App\Shared\Application\Event;

use App\Shared\Domain\Event\DomainEventInterface;

interface EventBusInterface
{
    public function publish(DomainEventInterface ...$domainEvents): void;
}
