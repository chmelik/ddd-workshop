<?php

namespace App\Shared\Domain\Model;

use App\Shared\Domain\Event\DomainEventInterface;

trait DomainEventAwareTrait
{
    /**
     * @var DomainEventInterface[]
     */
    private array $domainEvents = [];

    /**
     * @return DomainEventInterface[]
     */
    final public function releaseDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final public function addDomainEvent(DomainEventInterface $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
