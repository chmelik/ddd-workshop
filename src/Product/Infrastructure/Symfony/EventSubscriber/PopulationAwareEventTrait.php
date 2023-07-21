<?php

namespace App\Product\Infrastructure\Symfony\EventSubscriber;

use App\Shared\Infrastructure\Symfony\Messenger\Message\MessageInterface;
#use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait PopulationAwareEventTrait
{
    private MessageBusInterface $eventBus;

    #[Required]
    public function setEventBus(MessageBusInterface $eventBus): void
    {
        $this->eventBus = $eventBus;
    }

    private function dispatchMessage(MessageInterface $message, ?string $routingKey = null): void
    {
        $envelope = new Envelope($message);
        if (null !== $routingKey) {
            //$envelope = $envelope->with(new AmqpStamp($routingKey));
        }

        $this->eventBus->dispatch($envelope);
    }
}
