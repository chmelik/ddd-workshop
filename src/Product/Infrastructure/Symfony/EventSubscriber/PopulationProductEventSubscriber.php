<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Symfony\EventSubscriber;

use App\Product\Domain\Event\ProductCreatedDomainEvent;
use App\Product\Domain\Event\ProductDeletedDomainEvent;
use App\Product\Domain\Event\ProductUpdatedDomainEvent;
use App\Product\Infrastructure\Symfony\Messenger\Message\ProductCreatedEvent as MessageProductCreatedEvent;
use App\Product\Infrastructure\Symfony\Messenger\Message\ProductDeletedEvent as MessageProductDeletedEvent;
use App\Product\Infrastructure\Symfony\Messenger\Message\ProductUpdatedEvent as MessageProductUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class PopulationProductEventSubscriber implements EventSubscriberInterface
{
    use PopulationAwareEventTrait;

    public static function getSubscribedEvents()
    {
        return [
            ProductCreatedDomainEvent::class => 'onCreated',
            ProductUpdatedDomainEvent::class => 'onUpdated',
            ProductDeletedDomainEvent::class => 'onDeleted',
        ];
    }

    public function onCreated(ProductCreatedDomainEvent $event): void
    {
        $message = MessageProductCreatedEvent::fromDomainEvent($event);
        $this->dispatchMessage($message, 'product_persisting');
    }

    public function onUpdated(ProductUpdatedDomainEvent $event): void
    {
        $message = MessageProductUpdatedEvent::fromDomainEvent($event);
        $this->dispatchMessage($message, 'product_persisting');
    }

    public function onDeleted(ProductDeletedDomainEvent $event): void
    {
        $message = MessageProductDeletedEvent::fromDomainEvent($event);
        $this->dispatchMessage($message, 'product_persisting');
    }
}
